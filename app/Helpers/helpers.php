<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('settings')) {
    /**
     * Get a setting value from the database with caching
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = DB::table('settings')->where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}

if (!function_exists('active_link')) {
    /**
     * Check if the current route matches the given route name
     *
     * @param string|array $route
     * @param string $class
     * @return string
     */
    function active_link($route, $class = 'active')
    {
        if (is_array($route)) {
            return in_array(request()->route()->getName(), $route) ? $class : '';
        }

        return request()->routeIs($route) ? $class : '';
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date using Carbon
     *
     * @param string|DateTime $date
     * @param string $format
     * @return string
     */
    function format_date($date, $format = 'M d, Y')
    {
        if (!$date) {
            return '';
        }

        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text to a specified length
     *
     * @param string $text
     * @param int $length
     * @param string $suffix
     * @return string
     */
    function truncate_text($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . $suffix;
    }
}
