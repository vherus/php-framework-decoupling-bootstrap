<?php

namespace Vherus\Framework\Entity\Helper;

use Vherus\Framework\Exception\UndefinedException;

trait UsesPrivateAttributes
{
    private $attributes = [];

    private function set(string $property, $value): self
    {
        $this->attributes[$property] = $value;
        return $this;
    }

    /**
     * @param string $property
     * @param mixed $default
     *  The default value to return if the property has not been set. Callbacks may be
     *  passed here to perform custom logic in the event of an undefined property.
     * @return mixed
     */
    private function get(string $property, $default)
    {
        if (!isset($this->attributes[$property])) {
            if (is_callable($default)) {
                return call_user_func($default);
            }

            return $default;
        }

        return $this->attributes[$property];
    }

    private function throwUndefined(string $property): \Closure
    {
        return function () use ($property) {
            throw new UndefinedException("Property `$property` is not defined.");
        };
    }
}
