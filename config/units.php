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

    // Base: pascal. psi = lbf/in²; torr = atm/760; mmHg and inHg are the conventional (0 °C mercury) values.
    'pressure' => [
        'pa' => ['name' => 'Pascals', 'symbol' => 'Pa', 'factor' => 1],
        'hpa' => ['name' => 'Hectopascals', 'symbol' => 'hPa', 'factor' => 100],
        'kpa' => ['name' => 'Kilopascals', 'symbol' => 'kPa', 'factor' => 1000],
        'mpa' => ['name' => 'Megapascals', 'symbol' => 'MPa', 'factor' => 1e6],
        'bar' => ['name' => 'Bar', 'symbol' => 'bar', 'factor' => 1e5],
        'mbar' => ['name' => 'Millibar', 'symbol' => 'mbar', 'factor' => 100],
        'atm' => ['name' => 'Atmospheres', 'symbol' => 'atm', 'factor' => 101325],
        'torr' => ['name' => 'Torr', 'symbol' => 'Torr', 'factor' => 101325 / 760],
        'mtorr' => ['name' => 'Millitorr', 'symbol' => 'mTorr', 'factor' => 101325 / 760 / 1000],
        'mmhg' => ['name' => 'Millimeters of mercury', 'symbol' => 'mmHg', 'factor' => 133.322387415],
        'inhg' => ['name' => 'Inches of mercury', 'symbol' => 'inHg', 'factor' => 3386.388640341],
        'inh2o' => ['name' => 'Inches of water', 'symbol' => 'inH₂O', 'factor' => 249.08891],
        'mmh2o' => ['name' => 'Millimeters of water', 'symbol' => 'mmH₂O', 'factor' => 9.80665],
        'psi' => ['name' => 'Pounds per square inch', 'symbol' => 'psi', 'factor' => 6894.757293168361],
        'psf' => ['name' => 'Pounds per square foot', 'symbol' => 'psf', 'factor' => 47.88025898033584],
        'ksi' => ['name' => 'Kilopounds per square inch', 'symbol' => 'ksi', 'factor' => 6894757.293168361],
    ],

    // Base: newton. lbf = 0.45359237 kg × 9.80665 m/s² exactly.
    'force' => [
        'meganewton' => ['name' => 'Meganewtons', 'symbol' => 'MN', 'factor' => 1e6],
        'kn' => ['name' => 'Kilonewtons', 'symbol' => 'kN', 'factor' => 1000],
        'n' => ['name' => 'Newtons', 'symbol' => 'N', 'factor' => 1],
        'millinewton' => ['name' => 'Millinewtons', 'symbol' => 'mN', 'factor' => 0.001],
        'dyn' => ['name' => 'Dynes', 'symbol' => 'dyn', 'factor' => 1e-5],
        'tf' => ['name' => 'Tonnes-force', 'symbol' => 'tf', 'factor' => 9806.65],
        'kgf' => ['name' => 'Kilograms-force', 'symbol' => 'kgf', 'factor' => 9.80665],
        'gf' => ['name' => 'Grams-force', 'symbol' => 'gf', 'factor' => 0.00980665],
        'tonf_us' => ['name' => 'US tons-force', 'symbol' => 'tonf (US)', 'factor' => 8896.443230521],
        'tonf_uk' => ['name' => 'Long tons-force', 'symbol' => 'tonf (UK)', 'factor' => 9964.01641818352],
        'kip' => ['name' => 'Kips', 'symbol' => 'kip', 'factor' => 4448.2216152605],
        'lbf' => ['name' => 'Pounds-force', 'symbol' => 'lbf', 'factor' => 4.4482216152605],
        'ozf' => ['name' => 'Ounces-force', 'symbol' => 'ozf', 'factor' => 4.4482216152605 / 16],
        'pdl' => ['name' => 'Poundals', 'symbol' => 'pdl', 'factor' => 0.138254954376],
    ],

    // Base: newton meter.
    'torque' => [
        'knm' => ['name' => 'Kilonewton meters', 'symbol' => 'kN·m', 'factor' => 1000],
        'nm' => ['name' => 'Newton meters', 'symbol' => 'N·m', 'factor' => 1],
        'ncm' => ['name' => 'Newton centimeters', 'symbol' => 'N·cm', 'factor' => 0.01],
        'nmm' => ['name' => 'Newton millimeters', 'symbol' => 'N·mm', 'factor' => 0.001],
        'kgfm' => ['name' => 'Kilogram-force meters', 'symbol' => 'kgf·m', 'factor' => 9.80665],
        'kgfcm' => ['name' => 'Kilogram-force centimeters', 'symbol' => 'kgf·cm', 'factor' => 0.0980665],
        'gfcm' => ['name' => 'Gram-force centimeters', 'symbol' => 'gf·cm', 'factor' => 9.80665e-5],
        'dyncm' => ['name' => 'Dyne centimeters', 'symbol' => 'dyn·cm', 'factor' => 1e-7],
        'lbfft' => ['name' => 'Foot-pounds', 'symbol' => 'ft·lbf', 'factor' => 1.3558179483314004],
        'lbfin' => ['name' => 'Inch-pounds', 'symbol' => 'in·lbf', 'factor' => 0.1129848290276167],
        'ozfft' => ['name' => 'Foot-ounces', 'symbol' => 'ft·ozf', 'factor' => 1.3558179483314004 / 16],
        'ozfin' => ['name' => 'Inch-ounces', 'symbol' => 'in·ozf', 'factor' => 0.1129848290276167 / 16],
    ],

    // Base: meter per second. Mach uses the speed of sound in dry air at 20 °C.
    'speed' => [
        'ms' => ['name' => 'Meters per second', 'symbol' => 'm/s', 'factor' => 1],
        'kmh' => ['name' => 'Kilometers per hour', 'symbol' => 'km/h', 'factor' => 1 / 3.6],
        'mph' => ['name' => 'Miles per hour', 'symbol' => 'mph', 'factor' => 0.44704],
        'knot' => ['name' => 'Knots', 'symbol' => 'kn', 'factor' => 1852 / 3600],
        'fts' => ['name' => 'Feet per second', 'symbol' => 'ft/s', 'factor' => 0.3048],
        'ftmin' => ['name' => 'Feet per minute', 'symbol' => 'ft/min', 'factor' => 0.00508],
        'yds' => ['name' => 'Yards per second', 'symbol' => 'yd/s', 'factor' => 0.9144],
        'ins' => ['name' => 'Inches per second', 'symbol' => 'in/s', 'factor' => 0.0254],
        'cms' => ['name' => 'Centimeters per second', 'symbol' => 'cm/s', 'factor' => 0.01],
        'kms' => ['name' => 'Kilometers per second', 'symbol' => 'km/s', 'factor' => 1000],
        'mis' => ['name' => 'Miles per second', 'symbol' => 'mi/s', 'factor' => 1609.344],
        'mach' => ['name' => 'Mach (20 °C air)', 'symbol' => 'Mach', 'factor' => 343],
        'c' => ['name' => 'Speed of light', 'symbol' => 'c', 'factor' => 299792458],
    ],

    // Base: kilometers per liter. Per-distance units are inverse: base = factor ÷ value.
    // Electric units use the EPA equivalence of 33.705 kWh per US gallon of gasoline.
    'fuel_economy' => [
        'mpg_us' => ['name' => 'Miles per US gallon', 'symbol' => 'mpg', 'factor' => 1.609344 / 3.785411784],
        'mpg_uk' => ['name' => 'Miles per imperial gallon', 'symbol' => 'mpg (UK)', 'factor' => 1.609344 / 4.54609],
        'kml' => ['name' => 'Kilometers per liter', 'symbol' => 'km/L', 'factor' => 1],
        'l100km' => ['name' => 'Liters per 100 km', 'symbol' => 'L/100 km', 'factor' => 100, 'inverse' => true],
        'l100mi' => ['name' => 'Liters per 100 miles', 'symbol' => 'L/100 mi', 'factor' => 160.9344, 'inverse' => true],
        'gal100mi' => ['name' => 'US gallons per 100 miles', 'symbol' => 'gal/100 mi', 'factor' => 160.9344 / 3.785411784, 'inverse' => true],
        'mpge' => ['name' => 'MPGe (electric)', 'symbol' => 'MPGe', 'factor' => 1.609344 / 3.785411784],
        'kwh100mi' => ['name' => 'kWh per 100 miles', 'symbol' => 'kWh/100 mi', 'factor' => 3370.5 * 1.609344 / 3.785411784, 'inverse' => true],
    ],

    // Base: joule. Calorie is the thermochemical calorie; BTU and therm are the IT definitions.
    'energy' => [
        'j' => ['name' => 'Joules', 'symbol' => 'J', 'factor' => 1],
        'kj' => ['name' => 'Kilojoules', 'symbol' => 'kJ', 'factor' => 1e3],
        'mj' => ['name' => 'Megajoules', 'symbol' => 'MJ', 'factor' => 1e6],
        'gj' => ['name' => 'Gigajoules', 'symbol' => 'GJ', 'factor' => 1e9],
        'wh' => ['name' => 'Watt-hours', 'symbol' => 'Wh', 'factor' => 3600],
        'kwh' => ['name' => 'Kilowatt-hours', 'symbol' => 'kWh', 'factor' => 3.6e6],
        'mwh' => ['name' => 'Megawatt-hours', 'symbol' => 'MWh', 'factor' => 3.6e9],
        'cal' => ['name' => 'Calories', 'symbol' => 'cal', 'factor' => 4.184],
        'kcal' => ['name' => 'Kilocalories (food Calories)', 'symbol' => 'kcal', 'factor' => 4184],
        'btu' => ['name' => 'British thermal units', 'symbol' => 'BTU', 'factor' => 1055.05585262],
        'therm' => ['name' => 'Therms', 'symbol' => 'thm', 'factor' => 105505585.262],
        'ftlbf' => ['name' => 'Foot-pounds', 'symbol' => 'ft·lbf', 'factor' => 1.3558179483314004],
        'hph' => ['name' => 'Horsepower-hours', 'symbol' => 'hp·h', 'factor' => 2684519.537696172],
        'ev' => ['name' => 'Electronvolts', 'symbol' => 'eV', 'factor' => 1.602176634e-19],
        'erg' => ['name' => 'Ergs', 'symbol' => 'erg', 'factor' => 1e-7],
        'tnt' => ['name' => 'Tons of TNT', 'symbol' => 't TNT', 'factor' => 4.184e9],
    ],

    // Base: watt. Mechanical horsepower = 550 ft·lbf/s; metric horsepower = 75 kgf·m/s.
    'power' => [
        'gw' => ['name' => 'Gigawatts', 'symbol' => 'GW', 'factor' => 1e9],
        'mw' => ['name' => 'Megawatts', 'symbol' => 'MW', 'factor' => 1e6],
        'kw' => ['name' => 'Kilowatts', 'symbol' => 'kW', 'factor' => 1e3],
        'w' => ['name' => 'Watts', 'symbol' => 'W', 'factor' => 1],
        'milliwatt' => ['name' => 'Milliwatts', 'symbol' => 'mW', 'factor' => 1e-3],
        'hp' => ['name' => 'Horsepower (mechanical)', 'symbol' => 'hp', 'factor' => 745.6998715822702],
        'ps' => ['name' => 'Metric horsepower', 'symbol' => 'PS', 'factor' => 735.49875],
        'hp_e' => ['name' => 'Electrical horsepower', 'symbol' => 'hp(E)', 'factor' => 746],
        'hp_boiler' => ['name' => 'Boiler horsepower', 'symbol' => 'hp(S)', 'factor' => 9809.5],
        'btuh' => ['name' => 'BTU per hour', 'symbol' => 'BTU/h', 'factor' => 1055.05585262 / 3600],
        'tr' => ['name' => 'Tons of refrigeration', 'symbol' => 'TR', 'factor' => 12000 * 1055.05585262 / 3600],
        'ftlbfs' => ['name' => 'Foot-pounds per second', 'symbol' => 'ft·lbf/s', 'factor' => 1.3558179483314004],
        'cals' => ['name' => 'Calories per second', 'symbol' => 'cal/s', 'factor' => 4.184],
    ],

    // Base: coulomb.
    'charge' => [
        'c' => ['name' => 'Coulombs', 'symbol' => 'C', 'factor' => 1],
        'mc' => ['name' => 'Millicoulombs', 'symbol' => 'mC', 'factor' => 1e-3],
        'uc' => ['name' => 'Microcoulombs', 'symbol' => 'µC', 'factor' => 1e-6],
        'nc' => ['name' => 'Nanocoulombs', 'symbol' => 'nC', 'factor' => 1e-9],
        'ah' => ['name' => 'Ampere-hours', 'symbol' => 'Ah', 'factor' => 3600],
        'mah' => ['name' => 'Milliampere-hours', 'symbol' => 'mAh', 'factor' => 3.6],
        'e' => ['name' => 'Elementary charges', 'symbol' => 'e', 'factor' => 1.602176634e-19],
    ],

    // Base: radian.
    'angle' => [
        'deg' => ['name' => 'Degrees', 'symbol' => '°', 'factor' => M_PI / 180],
        'rad' => ['name' => 'Radians', 'symbol' => 'rad', 'factor' => 1],
        'grad' => ['name' => 'Gradians', 'symbol' => 'gon', 'factor' => M_PI / 200],
        'turn' => ['name' => 'Turns', 'symbol' => 'rev', 'factor' => 2 * M_PI],
        'arcmin' => ['name' => 'Arc minutes', 'symbol' => '′', 'factor' => M_PI / 10800],
        'arcsec' => ['name' => 'Arc seconds', 'symbol' => '″', 'factor' => M_PI / 648000],
        'mrad' => ['name' => 'Milliradians', 'symbol' => 'mrad', 'factor' => 0.001],
        'mil' => ['name' => 'NATO mils', 'symbol' => 'mil', 'factor' => 2 * M_PI / 6400],
        'point' => ['name' => 'Compass points', 'symbol' => 'pt', 'factor' => 2 * M_PI / 32],
    ],

];
