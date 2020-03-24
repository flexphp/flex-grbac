<?php declare(strict_types=1);
/*
 * This file is part of FlexPHP.
 *
 * (c) Freddie Gar <freddie.gar@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FlexPHP\GRBAC\Tests\Unit;

use FlexPHP\GRBAC\Control;
use FlexPHP\GRBAC\Role;
use FlexPHP\GRBAC\Tests\Mocks\AutorizableMock;
use FlexPHP\GRBAC\Tests\TestCase;

final class AutorizableTraitTest extends TestCase
{
    public function testItAttachRole(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);

        $autorizable = new AutorizableMock();
        $autorizable->attach($role);

        $this->assertTrue($autorizable->can($control->slug()));
    }

    public function testItDetachRole(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);

        $autorizable = new AutorizableMock();
        $autorizable->detach($role);

        $this->assertFalse($autorizable->can($control->slug()));
    }

    public function testItAttachDetachControl(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);

        $autorizable = new AutorizableMock();
        $autorizable->attach($role);

        $this->assertTrue($autorizable->can($control->slug()));

        $autorizable->detach($role);

        $this->assertFalse($autorizable->can($control->slug()));
    }

    public function testItCanAnyControl(): void
    {
        $userRead = new Control('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->grant($userRead);

        $userCreate = new Control('user.create');
        $roleB = new Role('ROL' . __LINE__);
        $roleB->grant($userCreate);

        $autorizable = new AutorizableMock();
        $autorizable->attach($roleA);

        $this->assertTrue($autorizable->canAny([$userRead->slug()]));
        $this->assertFalse($autorizable->canAny([$userCreate->slug()]));
        $this->assertTrue($autorizable->canAny([$userRead->slug(), $userCreate->slug()]));

        $autorizable->attach($roleB);

        $this->assertTrue($autorizable->canAny([$userRead->slug()]));
        $this->assertTrue($autorizable->canAny([$userCreate->slug()]));
        $this->assertTrue($autorizable->canAny([$userRead->slug(), $userCreate->slug()]));

        $autorizable->detach($roleA);
        $autorizable->detach($roleB);

        $this->assertFalse($autorizable->canAny([$userRead->slug()]));
        $this->assertFalse($autorizable->canAny([$userCreate->slug()]));
        $this->assertFalse($autorizable->canAny([$userRead->slug(), $userCreate->slug()]));
    }

    public function testItCanAllControl(): void
    {
        $userRead = new Control('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->grant($userRead);

        $userCreate = new Control('user.create');
        $roleB = new Role('ROL' . __LINE__);
        $roleB->grant($userCreate);

        $autorizable = new AutorizableMock();
        $autorizable->attach($roleA);

        $this->assertTrue($autorizable->canAll([$userRead->slug()]));
        $this->assertFalse($autorizable->canAll([$userCreate->slug()]));
        $this->assertFalse($autorizable->canAll([$userRead->slug(), $userCreate->slug()]));

        $autorizable->attach($roleB);

        $this->assertTrue($autorizable->canAll([$userRead->slug()]));
        $this->assertTrue($autorizable->canAll([$userCreate->slug()]));
        $this->assertTrue($autorizable->canAll([$userRead->slug(), $userCreate->slug()]));

        $autorizable->detach($roleA);
        $autorizable->detach($roleB);

        $this->assertFalse($autorizable->canAll([$userRead->slug()]));
        $this->assertFalse($autorizable->canAll([$userCreate->slug()]));
        $this->assertFalse($autorizable->canAll([$userRead->slug(), $userCreate->slug()]));
    }

    public function testItDenyOverAllGrant(): void
    {
        $control = new Control('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->deny($control);

        $roleB = new Role('ROL' . __LINE__);
        $roleB->grant($control);

        $autorizable = new AutorizableMock();
        $autorizable->attach($roleA);

        $this->assertFalse($autorizable->can($control->slug()));

        $autorizable->attach($roleB);

        $this->assertFalse($autorizable->can($control->slug()));

        $autorizable->detach($roleA);

        $this->assertTrue($autorizable->can($control->slug()));

        $autorizable->detach($roleB);

        $this->assertFalse($autorizable->can($control->slug()));

        $autorizable->attach($roleB);

        $this->assertTrue($autorizable->can($control->slug()));

        $autorizable->attach($roleA);

        $this->assertFalse($autorizable->can($control->slug()));
    }
}
