<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EverydayController extends Controller
{
    public function index(): View
    {
        return view('everyday.index', [
            'categories' => config('everyday.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("everyday.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
