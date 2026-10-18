<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ConstructionController extends Controller
{
    public function index(): View
    {
        return view('construction.index', [
            'categories' => config('construction.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("construction.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
