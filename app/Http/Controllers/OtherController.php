<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class OtherController extends Controller
{
    public function index(): View
    {
        return view('other.index', [
            'categories' => config('other.categories', []),
        ]);
    }

    public function show(string $calculator): View
    {
        $calculatorConfig = config("other.calculators.{$calculator}");

        abort_if(! is_array($calculatorConfig) || empty($calculatorConfig['view']), 404);

        return view($calculatorConfig['view']);
    }
}
