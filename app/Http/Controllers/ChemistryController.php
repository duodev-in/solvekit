<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ChemistryController extends Controller
{
    public function index(): View
    {
        return view('chemistry.index', [
            'categories' => config('chemistry.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("chemistry.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
