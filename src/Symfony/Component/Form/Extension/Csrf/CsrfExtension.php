<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Csrf;

use Symfony\Component\Form\Extension\Csrf\Type;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Symfony\Component\Form\AbstractExtension;

class CsrfExtension extends AbstractExtension
{
    private $csrfProvider;

    public function __construct(CsrfProviderInterface $csrfProvider)
    {
        $this->csrfProvider = $csrfProvider;
    }

    protected function loadTypes()
    {
        return array(
            new Type\CsrfType($this->csrfProvider),
        );
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeCsrfExtension(),
        );
    }
}
