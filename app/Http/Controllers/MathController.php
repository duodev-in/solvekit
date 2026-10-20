<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MathController extends Controller
{
    public function index(): View
    {
        return view('math.index', [
            'categories' => config('math.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("math.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
