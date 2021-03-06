<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class ValueToDuplicatesTransformer implements DataTransformerInterface
{
    private $keys;

    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    public function transform($value)
    {
        $result = array();

        foreach ($this->keys as $key) {
            $result[$key] = $value;
        }

        return $result;
    }

    public function reverseTransform($array)
    {
        if (!is_array($array) ) {
            throw new UnexpectedTypeException($array, 'array');
        }

        $result = current($array);
        $emptyKeys = array();

        foreach ($this->keys as $key) {
            if (!empty($array[$key])) {
                if ($array[$key] !== $result) {
                    throw new TransformationFailedException(
                            'All values in the array should be the same');
                }
            } else {
                $emptyKeys[] = $key;
            }
        }

        if (count($emptyKeys) > 0) {
            if (count($emptyKeys) === count($this->keys)) {
                // All keys empty
                return null;
            }

            throw new TransformationFailedException(sprintf(
                    'The keys "%s" should not be empty', implode('", "', $emptyKeys)));
        }

        return $result;
    }
}