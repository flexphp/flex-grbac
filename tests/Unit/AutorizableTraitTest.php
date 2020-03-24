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

use FlexPHP\GRBAC\Permission;
use FlexPHP\GRBAC\Role;
use FlexPHP\GRBAC\Tests\Mocks\AutorizableMock;
use FlexPHP\GRBAC\Tests\TestCase;

final class AutorizableTraitTest extends TestCase
{
    public function testItAttachRole(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($permission);

        $autorizable = new AutorizableMock();
        $autorizable->attach($role);

        $this->assertTrue($autorizable->can($permission->slug()));
    }

    public function testItDetachRole(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($permission);

        $autorizable = new AutorizableMock();
        $autorizable->detach($role);

        $this->assertFalse($autorizable->can($permission->slug()));
    }

    public function testItAttachDetachPermission(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($permission);

        $autorizable = new AutorizableMock();
        $autorizable->attach($role);

        $this->assertTrue($autorizable->can($permission->slug()));

        $autorizable->detach($role);

        $this->assertFalse($autorizable->can($permission->slug()));
    }

    public function testItCanAnyPermission(): void
    {
        $userRead = new Permission('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->grant($userRead);

        $userCreate = new Permission('user.create');
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

    public function testItCanAllPermission(): void
    {
        $userRead = new Permission('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->grant($userRead);

        $userCreate = new Permission('user.create');
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
        $permission = new Permission('user.read');
        $roleA = new Role('ROL' . __LINE__);
        $roleA->deny($permission);

        $roleB = new Role('ROL' . __LINE__);
        $roleB->grant($permission);

        $autorizable = new AutorizableMock();
        $autorizable->attach($roleA);

        $this->assertFalse($autorizable->can($permission->slug()));

        $autorizable->attach($roleB);

        $this->assertFalse($autorizable->can($permission->slug()));

        $autorizable->detach($roleA);

        $this->assertTrue($autorizable->can($permission->slug()));

        $autorizable->detach($roleB);

        $this->assertFalse($autorizable->can($permission->slug()));

        $autorizable->attach($roleB);

        $this->assertTrue($autorizable->can($permission->slug()));

        $autorizable->attach($roleA);

        $this->assertFalse($autorizable->can($permission->slug()));
    }
}
