<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\FormView;

class RadioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->appendClientTransformer(new BooleanToStringTransformer())
            ->setAttribute('value', $options['value']);
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('value', $form->getAttribute('value'));
        $view->set('checked', (bool)$form->getData());

        if ($view->hasParent()) {
            $view->set('name', $view->getParent()->get('name'));
        }
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'value' => null,
        );
    }

    public function getParent(array $options)
    {
        return 'field';
    }

    public function getName()
    {
        return 'radio';
    }
}
