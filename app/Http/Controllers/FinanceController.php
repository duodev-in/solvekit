<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(): View
    {
        return view('finance.index', [
            'categories' => config('finance.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("finance.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
