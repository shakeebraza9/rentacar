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

        $peakSeasons = PeakSeason::where('enable', 1)
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate)
            ->get();

        foreach ($peakSeasons as $season) {

            $carTypes = json_decode($season->value, true);


            foreach ($carTypes as $carType) {
                if ($carType['car_type_slug'] === $carTypeSlug) {
                    return (float) $carType['price'];
                }
            }
        }


        return 0;
    }
}
