<?php
use Illuminate\Support\Facades\DB;
use App\Models\Faq;

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


if (!function_exists('getFaqsByType')) {
    function getFaqsByType($type)
    {
        $faqs = Faq::where('type', $type)->get();
        $accordionId = 'accordionFaq_' . $type;

        $html = '<div class="accordion alt mt-4" id="' . $accordionId . '">';

        if ($faqs->isEmpty()) {
            $html .= '<div class="alert alert-warning">No FAQs found for this category.</div>';
        } else {
            foreach ($faqs as $index => $faq) {
                $collapseId = "collapse-$type-$index";
                $headingId = "heading-$type-$index";

                $html .= '<div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="' . $headingId . '">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
                                    ' . htmlspecialchars($faq->name) . '
                                </button>
                            </h2>
                            <div id="' . $collapseId . '" class="accordion-collapse collapse" aria-labelledby="' . $headingId . '"
                                data-bs-parent="#' . $accordionId . '">
                                <div class="accordion-body">
                                    ' . htmlspecialchars($faq->description) . '
                                </div>
                            </div>
                        </div>';
            }
        }

        $html .= '</div>';

        return $html;
    }
    if (!function_exists('getCarTypeBySlug')) {
        function getCarTypeBySlug($slug)
        {
            return DB::table('car_type')->where('slug', $slug)->first();
        }
    }

}
