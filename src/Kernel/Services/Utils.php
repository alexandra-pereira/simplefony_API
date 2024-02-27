<?php

namespace Mvc\Framework\Kernel\Services;

abstract class Utils
{

    public static function isPrimitiveFromString(string $type): bool
    {
        return match ($type) {
            'string', 'int', 'float', 'bool', 'array', 'object', 'null' => true,
            default => false,
        };
    }
}