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
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var array<bool>
     */
    private $control = [];

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

    public function grant(ControlInterface $control): void
    {
        $this->control[$control->slug()] = true;
    }

    public function revoke(ControlInterface $control): void
    {
        unset($this->control[$control->slug()]);
    }

    public function deny(ControlInterface $control): void
    {
        $this->control[$control->slug()] = false;
    }

    public function allow(string $slug): bool
    {
        return $this->control[$slug] ?? false;
    }

    public function allowAny(array $slugs): bool
    {
        $permissions = \array_filter($slugs, function ($slug) {
            return ($this->control[$slug] ?? false) === true;
        });

        return (bool)\count($permissions);
    }

    public function allowAll(array $slugs): bool
    {
        $permissions = \array_filter($slugs, function ($slug) {
            return ($this->control[$slug] ?? false) === true;
        });

        return \count($permissions) === \count($slugs);
    }
}
