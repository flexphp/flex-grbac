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
use FlexPHP\GRBAC\Tests\TestCase;

final class PermissionTest extends TestCase
{
    public function testItCreate(): void
    {
        $slug = 'create';
        $description = 'Create a new resource';
        $permission = new Permission($slug, $description);

        $this->assertEquals($slug, $permission->slug());
        $this->assertEquals($description, $permission->description());
    }

    public function testItCreateWithoutDescription(): void
    {
        $slug = 'create';
        $permission = new Permission($slug);

        $this->assertEquals($slug, $permission->slug());
        $this->assertEquals(null, $permission->description());
    }
}
