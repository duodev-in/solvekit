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

    // Base: gram. The avoirdupois pound is exactly 0.45359237 kg (1959); 1 oz = 1/16 lb.
    'mass' => [
        't' => ['name' => 'Metric tons', 'symbol' => 't', 'factor' => 1e6],
        'kg' => ['name' => 'Kilograms', 'symbol' => 'kg', 'factor' => 1000],
        'dag' => ['name' => 'Decagrams', 'symbol' => 'dag', 'factor' => 10],
        'g' => ['name' => 'Grams', 'symbol' => 'g', 'factor' => 1],
        'mg' => ['name' => 'Milligrams', 'symbol' => 'mg', 'factor' => 0.001],
        'ug' => ['name' => 'Micrograms', 'symbol' => 'mcg', 'factor' => 1e-6],
        'ng' => ['name' => 'Nanograms', 'symbol' => 'ng', 'factor' => 1e-9],
        'ton_us' => ['name' => 'US tons (short)', 'symbol' => 'US ton', 'factor' => 907184.74],
        'ton_uk' => ['name' => 'Long tons (UK)', 'symbol' => 'long ton', 'factor' => 1016046.9088],
        'st' => ['name' => 'Stone', 'symbol' => 'st', 'factor' => 6350.29318],
        'lb' => ['name' => 'Pounds', 'symbol' => 'lb', 'factor' => 453.59237],
        'oz' => ['name' => 'Ounces', 'symbol' => 'oz', 'factor' => 28.349523125],
    ],

    // Base: liter. US gallon = 231 in³ exactly; imperial gallon = 4.54609 L exactly.
    'volume' => [
        'm3' => ['name' => 'Cubic meters', 'symbol' => 'm³', 'factor' => 1000],
        'l' => ['name' => 'Liters', 'symbol' => 'L', 'factor' => 1],
        'dl' => ['name' => 'Deciliters', 'symbol' => 'dL', 'factor' => 0.1],
        'cl' => ['name' => 'Centiliters', 'symbol' => 'cL', 'factor' => 0.01],
        'ml' => ['name' => 'Milliliters', 'symbol' => 'mL', 'factor' => 0.001],
        'ccf' => ['name' => 'Hundred cubic feet', 'symbol' => 'CCF', 'factor' => 2831.6846592],
        'yd3' => ['name' => 'Cubic yards', 'symbol' => 'yd³', 'factor' => 764.554857984],
        'ft3' => ['name' => 'Cubic feet', 'symbol' => 'ft³', 'factor' => 28.316846592],
        'in3' => ['name' => 'Cubic inches', 'symbol' => 'in³', 'factor' => 0.016387064],
        'gal_us' => ['name' => 'US gallons', 'symbol' => 'gal', 'factor' => 3.785411784],
        'qt_us' => ['name' => 'US quarts', 'symbol' => 'qt', 'factor' => 0.946352946],
        'pt_us' => ['name' => 'US pints', 'symbol' => 'pt', 'factor' => 0.473176473],
        'cup_us' => ['name' => 'US cups', 'symbol' => 'cup', 'factor' => 0.2365882365],
        'floz_us' => ['name' => 'US fluid ounces', 'symbol' => 'fl oz', 'factor' => 0.0295735295625],
        'tbsp_us' => ['name' => 'US tablespoons', 'symbol' => 'tbsp', 'factor' => 0.01478676478125],
        'tsp_us' => ['name' => 'US teaspoons', 'symbol' => 'tsp', 'factor' => 0.00492892159375],
        'cup_metric' => ['name' => 'Metric cups', 'symbol' => 'metric cup', 'factor' => 0.25],
        'gal_uk' => ['name' => 'Imperial gallons', 'symbol' => 'imp gal', 'factor' => 4.54609],
        'qt_uk' => ['name' => 'Imperial quarts', 'symbol' => 'imp qt', 'factor' => 1.1365225],
        'pt_uk' => ['name' => 'Imperial pints', 'symbol' => 'imp pt', 'factor' => 0.56826125],
        'cup_uk' => ['name' => 'Imperial cups', 'symbol' => 'imp cup', 'factor' => 0.284130625],
        'floz_uk' => ['name' => 'Imperial fluid ounces', 'symbol' => 'imp fl oz', 'factor' => 0.0284130625],
    ],

];
