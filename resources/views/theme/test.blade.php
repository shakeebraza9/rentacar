<?php

use App\Helpers\PeakSeasonHelper;

$carTypeSlug = 'compact';
$startDate = '2025-03-22';
$endDate = '2025-03-24';

$price = PeakSeasonHelper::getPrice($carTypeSlug, $startDate, $endDate);

echo $price; // This will print the price if a match is found, otherwise 0

?>
