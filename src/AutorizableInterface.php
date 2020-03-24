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

interface AutorizableInterface
{
    public function can(string $slug): bool;

    /**
     * @param array<string> $slugs
     */
    public function canAny(array $slugs): bool;

    /**
     * @param array<string> $slugs
     */
    public function canAll(array $slugs): bool;

    public function attach(RoleInterface $role): void;

    public function detach(RoleInterface $role): void;
}
