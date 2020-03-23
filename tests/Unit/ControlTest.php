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
use FlexPHP\GRBAC\Tests\TestCase;

final class ControlTest extends TestCase
{
    public function testItCreate(): void
    {
        $slug = 'create';
        $description = 'Create a new resource';
        $control = new Control($slug, $description);

        $this->assertEquals($slug, $control->slug());
        $this->assertEquals($description, $control->description());
    }
}
