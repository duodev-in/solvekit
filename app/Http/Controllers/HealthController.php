<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HealthController extends Controller
{
    public function index(): View
    {
        return view('health.index', [
            'categories' => config('health.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("health.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
