<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EcologyController extends Controller
{
    public function index(): View
    {
        return view('ecology.index', [
            'categories' => config('ecology.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("ecology.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
