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

final class Control implements ControlInterface
{
    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $description;

    public function __construct(string $slug, string $description = null)
    {
        $this->slug = $slug;
        $this->description = $description;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
