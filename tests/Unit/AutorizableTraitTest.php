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

        $this->assertEquals(true, $autorizable->can($control->slug()));
    }

    public function testItDetachRole(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);
        
        $autorizable = new AutorizableMock();
        $autorizable->detach($role);
        
        $this->assertEquals(false, $autorizable->can($control->slug()));
    }

    public function testItAttachDetachControl(): void
    {
        $control = new Control('user.read');

        $role = new Role('ROL' . __LINE__);
        $role->grant($control);
        
        $autorizable = new AutorizableMock();
        $autorizable->attach($role);
        
        $this->assertEquals(true, $autorizable->can($control->slug()));

        $autorizable->detach($role);

        $this->assertEquals(false, $autorizable->can($control->slug()));
    }
}
