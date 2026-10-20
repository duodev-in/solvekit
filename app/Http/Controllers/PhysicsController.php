<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PhysicsController extends Controller
{
    public function index(): View
    {
        return view('physics.index', [
            'categories' => config('physics.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("physics.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
