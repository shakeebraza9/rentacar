<?php


if (!function_exists('getset')) {
    function getset($key)
    {
        $setting = \App\Models\Setting::where('field', $key)->first();

        if ($setting) {
            return $setting->type === 'image' && $setting->image
                ? $setting->image
                : $setting->value;
        }

        // Return a default placeholder image or null if the key is not found.
        return 'uploads/default-placeholder.png'; // Or return null if preferred
    }
}