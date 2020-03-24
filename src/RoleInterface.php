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

interface RoleInterface
{
    public function __construct(string $name, string $description);

    public function name(): string;

    public function description(): ?string;

    public function grant(ControlInterface $control): void;

    public function revoke(ControlInterface $control): void;

    public function deny(ControlInterface $control): void;

    public function has(string $slug): bool;

    public function allow(string $slug): bool;

    /**
     * @param array<string> $slugs
     */
    public function allowAny(array $slugs): bool;

    /**
     * @param array<string> $slugs
     */
    public function allowAll(array $slugs): bool;
}
