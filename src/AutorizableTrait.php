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
    /**
     * @var array<string, RoleInterface>
     */
    protected $roles = [];

    public function can(string $slug): bool
    {
        return $this->isAllowed($slug);
    }

    public function canAny(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if ($this->isAllowed($slug)) {
                return true;
            }
        }

        return false;
    }

    public function canAll(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (!$this->isAllowed($slug)) {
                return false;
            }
        }

        return true;
    }

    public function attach(RoleInterface $role): void
    {
        $this->roles[$role->name()] = $role;
    }

    public function detach(RoleInterface $role): void
    {
        unset($this->roles[$role->name()]);
    }

    abstract protected function isAllowed(string $slug): bool;
}
