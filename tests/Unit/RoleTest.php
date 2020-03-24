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

    public function testItGrantPermission(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($permission);

        $this->assertTrue($role->allow($permission->slug()));
    }

    public function testItRevokePermission(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->revoke($permission);

        $this->assertFalse($role->allow($permission->slug()));
    }

    public function testItDenyPermission(): void
    {
        $permission = new Permission('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->deny($permission);

        $this->assertFalse($role->allow($permission->slug()));
    }

    public function testItAllowAnyPermission(): void
    {
        $userRead = new Permission('user.read');
        $userCreate = new Permission('user.create');

        $role = new Role('ROL' . __LINE__);
        $role->grant($userRead);
        $role->grant($userCreate);

        $this->assertTrue($role->allowAny([$userRead->slug()]));
        $this->assertTrue($role->allowAny([$userCreate->slug()]));
        $this->assertTrue($role->allowAny([$userRead->slug(), $userCreate->slug()]));

        $role->deny($userRead);

        $this->assertFalse($role->allowAny([$userRead->slug()]));
        $this->assertTrue($role->allowAny([$userCreate->slug()]));
        $this->assertTrue($role->allowAny([$userRead->slug(), $userCreate->slug()]));

        $role->deny($userCreate);

        $this->assertFalse($role->allowAny([$userRead->slug()]));
        $this->assertFalse($role->allowAny([$userCreate->slug()]));
        $this->assertFalse($role->allowAny([$userRead->slug(), $userCreate->slug()]));
    }

    public function testItAllowAllPermission(): void
    {
        $userRead = new Permission('user.read');
        $userCreate = new Permission('user.create');

        $role = new Role('ROL' . __LINE__);
        $role->deny($userRead);
        $role->deny($userCreate);

        $this->assertFalse($role->allowAll([$userRead->slug()]));
        $this->assertFalse($role->allowAll([$userCreate->slug()]));
        $this->assertFalse($role->allowAll([$userRead->slug(), $userCreate->slug()]));

        $role->grant($userRead);

        $this->assertTrue($role->allowAll([$userRead->slug()]));
        $this->assertFalse($role->allowAll([$userCreate->slug()]));
        $this->assertFalse($role->allowAll([$userRead->slug(), $userCreate->slug()]));

        $role->grant($userCreate);

        $this->assertTrue($role->allowAll([$userRead->slug()]));
        $this->assertTrue($role->allowAll([$userCreate->slug()]));
        $this->assertTrue($role->allowAll([$userRead->slug(), $userCreate->slug()]));
    }
}
