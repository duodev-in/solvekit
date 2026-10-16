<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BiologyController extends Controller
{
    public function index(): View
    {
        return view('biology.index', [
            'categories' => config('biology.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("biology.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
