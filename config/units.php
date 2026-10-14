<?php

/*
|--------------------------------------------------------------------------
| Unit tables
|--------------------------------------------------------------------------
|
| The single source of conversion factors for every calculator. Each table
| converts through one base unit (factor 1). A unit's factor is how many base
| units one of it equals, using exact definitions wherever one exists.
|
| The Blade components render unit menus from these tables and pass the same
| numbers to the browser, so a factor is only ever defined here.
|
*/

return [

    // Base: metre. Imperial units are exact by the 1959 international yard agreement.
    'length' => [
        'km' => ['name' => 'Kilometers', 'symbol' => 'km', 'factor' => 1000],
        'm' => ['name' => 'Meters', 'symbol' => 'm', 'factor' => 1],
        'dm' => ['name' => 'Decimeters', 'symbol' => 'dm', 'factor' => 0.1],
        'cm' => ['name' => 'Centimeters', 'symbol' => 'cm', 'factor' => 0.01],
        'mm' => ['name' => 'Millimeters', 'symbol' => 'mm', 'factor' => 0.001],
        'um' => ['name' => 'Micrometers', 'symbol' => 'µm', 'factor' => 1e-6],
        'nm' => ['name' => 'Nanometers', 'symbol' => 'nm', 'factor' => 1e-9],
        'mi' => ['name' => 'Miles', 'symbol' => 'mi', 'factor' => 1609.344],
        'yd' => ['name' => 'Yards', 'symbol' => 'yd', 'factor' => 0.9144],
        'ft' => ['name' => 'Feet', 'symbol' => 'ft', 'factor' => 0.3048],
        'in' => ['name' => 'Inches', 'symbol' => 'in', 'factor' => 0.0254],
        'nmi' => ['name' => 'Nautical miles', 'symbol' => 'nmi', 'factor' => 1852],
    ],

    // Base: square metre. US survey acre is not used; the international acre is 4840 yd².
    'area' => [
        'km2' => ['name' => 'Square kilometers', 'symbol' => 'km²', 'factor' => 1e6],
        'ha' => ['name' => 'Hectares', 'symbol' => 'ha', 'factor' => 1e4],
        'a' => ['name' => 'Ares', 'symbol' => 'a', 'factor' => 100],
        'm2' => ['name' => 'Square meters', 'symbol' => 'm²', 'factor' => 1],
        'cm2' => ['name' => 'Square centimeters', 'symbol' => 'cm²', 'factor' => 1e-4],
        'mm2' => ['name' => 'Square millimeters', 'symbol' => 'mm²', 'factor' => 1e-6],
        'mi2' => ['name' => 'Square miles', 'symbol' => 'mi²', 'factor' => 2589988.110336],
        'acre' => ['name' => 'Acres', 'symbol' => 'ac', 'factor' => 4046.8564224],
        'yd2' => ['name' => 'Square yards', 'symbol' => 'yd²', 'factor' => 0.83612736],
        'ft2' => ['name' => 'Square feet', 'symbol' => 'ft²', 'factor' => 0.09290304],
        'in2' => ['name' => 'Square inches', 'symbol' => 'in²', 'factor' => 0.00064516],
    ],

    // Base: metre. AU is exact (IAU 2012); light year uses the Julian year; parsec is 648000/π AU.
    'astronomical' => [
        'pc' => ['name' => 'Parsecs', 'symbol' => 'pc', 'factor' => 3.0856775814913673e16],
        'ly' => ['name' => 'Light years', 'symbol' => 'ly', 'factor' => 9460730472580800],
        'au' => ['name' => 'Astronomical units', 'symbol' => 'AU', 'factor' => 149597870700],
        'ls' => ['name' => 'Light seconds', 'symbol' => 'ls', 'factor' => 299792458],
        'km' => ['name' => 'Kilometers', 'symbol' => 'km', 'factor' => 1000],
        'mi' => ['name' => 'Miles', 'symbol' => 'mi', 'factor' => 1609.344],
        'm' => ['name' => 'Meters', 'symbol' => 'm', 'factor' => 1],
    ],

];
