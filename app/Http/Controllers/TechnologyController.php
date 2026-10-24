<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TechnologyController extends Controller
{
    public function index(): View
    {
        return view('technology.index', [
            'categories' => config('technology.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("technology.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
