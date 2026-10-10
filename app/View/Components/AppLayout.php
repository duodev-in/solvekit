<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;

    public $description;

    public function __construct($title = null, $description = null)
    {
        $this->title = $title ?? 'SolveKit - Professional Conversion Tools';
        $this->description = $description ?? 'Professional-grade calculators for accurate unit conversions across length, weight, pressure, torque, and more.';
    }

    public function render()
    {
        return view('layouts.app');
    }
}
