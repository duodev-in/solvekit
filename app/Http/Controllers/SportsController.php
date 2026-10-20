<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SportsController extends Controller
{
    public function index(): View
    {
        return view('sports.index', [
            'categories' => config('sports.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("sports.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
