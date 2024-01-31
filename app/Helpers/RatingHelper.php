<?php

if (!function_exists('calculateAverageRating')) {
    /**
     * Calculate the average rating for a product ordered by the same user.
     *
     * @param array $ratings
     * @return float
     */
    function calculateAverageRating($ratings)
    {
        if (empty($ratings)) {
            return 0; // No ratings available
        }

        $totalRating = array_sum($ratings);
        $numRatings = count($ratings);

        // Calculate the average rating
        $averageRating = $totalRating / $numRatings;

        // Round the average rating to, for example, two decimal places
        $roundedRating = round($averageRating);

        return $roundedRating;
    }
}
