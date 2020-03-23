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

interface ControlInterface
{
    public function __construct(string $slug, string $description = null);

    public function slug(): string;

    public function description(): ?string;
}
