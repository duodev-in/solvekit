<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FoodController extends Controller
{
    public function index(): View
    {
        return view('food.index', [
            'categories' => config('food.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("food.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
