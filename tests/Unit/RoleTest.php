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
use FlexPHP\GRBAC\RoleInterface;
use FlexPHP\GRBAC\Tests\TestCase;

final class RoleTest extends TestCase
{
    public function testItCreate(): void
    {
        $name = 'ROL';
        $role = new Role($name);

        $this->assertInstanceOf(RoleInterface::class, $role);
        $this->assertEquals($name, $role->name());
        $this->assertEquals(null, $role->description());
    }

    public function testItCreateWithDescription(): void
    {
        $name = 'ROL';
        $description = 'My cool role!';
        $role = new Role($name, $description);

        $this->assertInstanceOf(RoleInterface::class, $role);
        $this->assertEquals($name, $role->name());
        $this->assertEquals($description, $role->description());
    }

    public function testItGrantControl(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);

        $this->assertTrue($role->allow($control->slug()));
    }

    public function testItRevokeControl(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->revoke($control);

        $this->assertFalse($role->allow($control->slug()));
    }

    public function testItDenyControl(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->deny($control);

        $this->assertFalse($role->allow($control->slug()));
    }

    public function testItAllowAnyControl(): void
    {
        $userRead = new Control('user.read');
        $userCreate = new Control('user.create');

        $role = new Role('ROL' . __LINE__);
        $role->grant($userRead);
        $role->grant($userCreate);

        $this->assertTrue($role->allowAny([$userRead->slug(), $userCreate->slug()]));

        $role->deny($userRead);

        $this->assertTrue($role->allowAny([$userRead->slug(), $userCreate->slug()]));

        $role->deny($userCreate);

        $this->assertFalse($role->allowAny([$userRead->slug(), $userCreate->slug()]));
    }

    public function testItAllowAllControl(): void
    {
        $userRead = new Control('user.read');
        $userCreate = new Control('user.create');

        $role = new Role('ROL' . __LINE__);
        $role->deny($userRead);
        $role->deny($userCreate);

        $this->assertFalse($role->allowAll([$userRead->slug(), $userCreate->slug()]));

        $role->grant($userRead);

        $this->assertFalse($role->allowAll([$userRead->slug(), $userCreate->slug()]));

        $role->grant($userCreate);

        $this->assertTrue($role->allowAll([$userRead->slug(), $userCreate->slug()]));
    }
}
