<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function index()
    {
        return view('cookie-calculator');
    }

    public function calculateCookie(Request $request)
    {
        $ingredients = [
            'Sprinkles' => ['capacity' => 2, 'durability' => 0, 'flavor' => -2, 'texture' => 0, 'calories' => 3],
            'Butterscotch' => ['capacity' => 0, 'durability' => 5, 'flavor' => -3, 'texture' => 0, 'calories' => 3],
            'Chocolate' => ['capacity' => 0, 'durability' => 0, 'flavor' => 5, 'texture' => -1, 'calories' => 8],
            'Candy' => ['capacity' => 0, 'durability' => -1, 'flavor' => 0, 'texture' => 5, 'calories' => 8],
        ];

        $bestScore = $this->getBestCookieScore($ingredients);

        return response()->json(['score' => $bestScore]);
    }

    private function getBestCookieScore($ingredients)
    {
        $combinations = $this->generateCombinations(count($ingredients), 100);
        $bestScore = 0;

        foreach ($combinations as $combination) {
            $score = $this->calculateScore($combination, $ingredients);
            $bestScore = max($bestScore, $score);
        }

        return $bestScore;
    }

    private function generateCombinations($n, $total)
    {
        $combinations = [];

        for ($i = 0; $i <= $total; $i++) {
            for ($j = 0; $j <= $total - $i; $j++) {
                for ($k = 0; $k <= $total - $i - $j; $k++) {
                    $l = $total - $i - $j - $k;
                    $combinations[] = [$i, $j, $k, $l];
                }
            }
        }

        return $combinations;
    }

    private function calculateScore($combination, $ingredients)
    {
        $score = 1;

        foreach ($ingredients as $name => $properties) {
            $propertySum = 0;

            foreach ($combination as $j => $amount) {
                $propertySum += $amount * $properties[$j];
            }

            $score *= max(0, $propertySum);
        }

        return $score;
    }
}