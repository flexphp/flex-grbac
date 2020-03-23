<?php declare(strict_types=1);
/*
 * This file is part of FlexPHP.
 *
 * (c) Freddie Gar <freddie.gar@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FlexPHP\GRBAC\Tests\Mocks;

use FlexPHP\GRBAC\AutorizableInterface;
use FlexPHP\GRBAC\AutorizableTrait;
use FlexPHP\GRBAC\RoleInterface;

final class AutorizableMock implements AutorizableInterface
{
    use AutorizableTrait;

    protected function hasControlBySlug(string $slug): bool
    {
        $control = \array_filter($this->roles, function (RoleInterface $role) use ($slug) {
            return $role->allow($slug);
        });

        return (bool)\count($control);
    }
}
