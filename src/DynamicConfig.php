<?php

namespace Statsig;

class DynamicConfig
{
    private string $name;
    private array $value;
    private string $rule_id;
    private array $secondary_exposures;

    function __construct(string $name, array $value = [], string $rule_id = "", array $secondary_exposures = [])
    {
        $this->name = $name;
        $this->rule_id = $rule_id;
        $this->secondary_exposures = $secondary_exposures;

        // We re-decode here to treat associative arrays as objects, this allows us
        // to differentiate between array ([1,2]) and object (['a' => 'b'])
        $this->value = (array) json_decode(json_encode($value), null, 512, JSON_BIGINT_AS_STRING);
    }

    function get(string $field, $default)
    {
        if (!array_key_exists($field, $this->value)) {
            return $default;
        }
        $val = $this->value[$field];
        if ($default !== null && gettype($val) !== gettype($default)) {
            return $default;
        }
        return $val;
    }

    function getName(): string
    {
        return $this->name;
    }

    function getValue(): array
    {
        return $this->value;
    }

    function getRuleID(): string
    {
        return $this->rule_id;
    }

    function getSecondaryExposures(): array
    {
        return $this->secondary_exposures;
    }
}
