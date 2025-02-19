<?php
use Illuminate\Support\Facades\DB;

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

if (!function_exists('addBrEveryThreeWords')) {
    function addBrEveryThreeWords($text)
    {
        $words = explode(' ', $text);
        $chunkedWords = array_chunk($words, 5);
        $formattedText = array_map(function ($chunk) {
            return implode(' ', $chunk) . '<br>';
        }, $chunkedWords);
        return implode("", $formattedText);
    }
}

if (!function_exists('getLatestAttractions')) {
    function getLatestAttractions($limit = 8)
    {
        return DB::table('attractions')
            ->select('slug', 'title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}