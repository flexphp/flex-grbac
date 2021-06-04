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

final class Role implements RoleInterface
{
    private string $name;

    private ?string $description = null;

    /**
     * @var array<bool>
     */
    private array $permissions = [];

    public function __construct(string $name, string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function grant(PermissionInterface $permission): void
    {
        $this->permissions[$permission->slug()] = true;
    }

    public function revoke(PermissionInterface $permission): void
    {
        unset($this->permissions[$permission->slug()]);
    }

    public function deny(PermissionInterface $permission): void
    {
        $this->permissions[$permission->slug()] = false;
    }

    public function has(string $slug): bool
    {
        return isset($this->permissions[$slug]);
    }

    public function allow(string $slug): bool
    {
        return $this->permissions[$slug] ?? false;
    }

    public function allowAny(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if ($this->allow($slug)) {
                return true;
            }
        }

        return false;
    }

    public function allowAll(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (!$this->allow($slug)) {
                return false;
            }
        }

        return true;
    }
}
