<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StatisticsController extends Controller
{
    public function index(): View
    {
        return view('statistics.index', [
            'categories' => config('statistics.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("statistics.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
