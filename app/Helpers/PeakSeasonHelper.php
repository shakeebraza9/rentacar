<?php

namespace App\Helpers;

use App\Models\PeakSeason;

class PeakSeasonHelper
{
    /**
     * Get price based on car type and date range.
     *
     * @param string $carTypeSlug
     * @param string $startDate
     * @param string $endDate
     * @return float
     */
    public static function getPrice($carTypeSlug, $startDate, $endDate)
    {
        // Fetch the peak seasons that are enabled and within the provided date range
        $peakSeasons = PeakSeason::where('enable', 1)
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate)
            ->get();

        foreach ($peakSeasons as $season) {
            // Decode the 'value' field which contains car type and price info
            $carTypes = json_decode($season->value, true);

            // Find the price for the given car type
            foreach ($carTypes as $carType) {
                if ($carType['car_type_slug'] === $carTypeSlug) {
                    return (float) $carType['price']; // Return price for the matching car type
                }
            }
        }

        // If no matching price is found, return 0
        return 0;
    }
}