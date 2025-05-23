<?php
declare(strict_types=1);

namespace BananaPHP\Helpers;

class StringHelper
{
    public static function camelCase(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return lcfirst(str_replace(' ', '', $value));
    }

    public static function snakeCase(string $value): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }

    public static function random(int $length = 16): string
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        return $string;
    }

    public static function contains(string $haystack, string $needle): bool
    {
        return str_contains($haystack, $needle);
    }

    public static function startsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    public static function endsWith(string $haystack, string $needle): bool
    {
        return str_ends_with($haystack, $needle);
    }
}