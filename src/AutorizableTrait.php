<?php declare(strict_types=1);
/*
 * This file is part of FlexPHP.
 *
 * (c) Freddie Gar <freddie.gar@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FlexPHP\GRBAC;

trait AutorizableTrait
{
    protected $roles = [];

    public function can(string $slug): bool
    {
        return $this->hasControlBySlug($slug);
    }

    public function attach(RoleInterface $role): void
    {
        $this->roles[$role->name()] = $role;
    }

    public function detach(RoleInterface $role): void
    {
        unset($this->roles[$role->name()]);
    }

    abstract protected function hasControlBySlug(string $slug): bool;
}
