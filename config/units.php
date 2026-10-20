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
        'mpc' => ['name' => 'Megaparsecs', 'symbol' => 'Mpc', 'factor' => 3.0856775814913673e22],
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
        'gr' => ['name' => 'Grains', 'symbol' => 'gr', 'factor' => 0.06479891],
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
        'gpa' => ['name' => 'Gigapascals', 'symbol' => 'GPa', 'factor' => 1e9],
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
        'ba' => ['name' => 'Barye (CGS)', 'symbol' => 'Ba', 'factor' => 0.1],
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

    // Base: one. Short scale (US, modern UK) and long scale (traditional European) differ from a billion up.
    'numbers' => [
        'one' => ['name' => 'Ones', 'symbol' => '', 'factor' => 1],
        'thousand' => ['name' => 'Thousands', 'symbol' => 'thousand', 'factor' => 1e3],
        'lakh' => ['name' => 'Lakhs', 'symbol' => 'lakh', 'factor' => 1e5],
        'million' => ['name' => 'Millions', 'symbol' => 'million', 'factor' => 1e6],
        'crore' => ['name' => 'Crores', 'symbol' => 'crore', 'factor' => 1e7],
        'billion' => ['name' => 'Billions', 'symbol' => 'billion', 'factor' => 1e9],
        'trillion' => ['name' => 'Trillions', 'symbol' => 'trillion', 'factor' => 1e12],
        'quadrillion' => ['name' => 'Quadrillions', 'symbol' => 'quadrillion', 'factor' => 1e15],
    ],

    'numbers_long_scale' => [
        'one' => ['name' => 'Ones', 'symbol' => '', 'factor' => 1],
        'thousand' => ['name' => 'Thousands', 'symbol' => 'thousand', 'factor' => 1e3],
        'lakh' => ['name' => 'Lakhs', 'symbol' => 'lakh', 'factor' => 1e5],
        'million' => ['name' => 'Millions', 'symbol' => 'million', 'factor' => 1e6],
        'crore' => ['name' => 'Crores', 'symbol' => 'crore', 'factor' => 1e7],
        'billion' => ['name' => 'Billions', 'symbol' => 'billion', 'factor' => 1e12],
        'trillion' => ['name' => 'Trillions', 'symbol' => 'trillion', 'factor' => 1e18],
        'quadrillion' => ['name' => 'Quadrillions', 'symbol' => 'quadrillion', 'factor' => 1e24],
    ],

    // Base: byte. Decimal (SI) prefixes are powers of 1000; binary (IEC) prefixes are powers of 1024.
    'data' => [
        'bit' => ['name' => 'Bits', 'symbol' => 'bit', 'factor' => 0.125],
        'b' => ['name' => 'Bytes', 'symbol' => 'B', 'factor' => 1],
        'kb' => ['name' => 'Kilobytes', 'symbol' => 'kB', 'factor' => 1e3],
        'mb' => ['name' => 'Megabytes', 'symbol' => 'MB', 'factor' => 1e6],
        'gb' => ['name' => 'Gigabytes', 'symbol' => 'GB', 'factor' => 1e9],
        'tb' => ['name' => 'Terabytes', 'symbol' => 'TB', 'factor' => 1e12],
        'pb' => ['name' => 'Petabytes', 'symbol' => 'PB', 'factor' => 1e15],
        'kib' => ['name' => 'Kibibytes', 'symbol' => 'KiB', 'factor' => 1024],
        'mib' => ['name' => 'Mebibytes', 'symbol' => 'MiB', 'factor' => 1024 ** 2],
        'gib' => ['name' => 'Gibibytes', 'symbol' => 'GiB', 'factor' => 1024 ** 3],
        'tib' => ['name' => 'Tebibytes', 'symbol' => 'TiB', 'factor' => 1024 ** 4],
        'pib' => ['name' => 'Pebibytes', 'symbol' => 'PiB', 'factor' => 1024 ** 5],
    ],

    // Base: bit per second. Network speeds always use decimal prefixes.
    'data_rate' => [
        'bps' => ['name' => 'Bits per second', 'symbol' => 'bit/s', 'factor' => 1],
        'kbps' => ['name' => 'Kilobits per second', 'symbol' => 'kbit/s', 'factor' => 1e3],
        'mbps' => ['name' => 'Megabits per second', 'symbol' => 'Mbit/s', 'factor' => 1e6],
        'gbps' => ['name' => 'Gigabits per second', 'symbol' => 'Gbit/s', 'factor' => 1e9],
        'tbps' => ['name' => 'Terabits per second', 'symbol' => 'Tbit/s', 'factor' => 1e12],
        'kBps' => ['name' => 'Kilobytes per second', 'symbol' => 'kB/s', 'factor' => 8e3],
        'MBps' => ['name' => 'Megabytes per second', 'symbol' => 'MB/s', 'factor' => 8e6],
        'GBps' => ['name' => 'Gigabytes per second', 'symbol' => 'GB/s', 'factor' => 8e9],
    ],

    // Base: farad.
    'capacitance' => [
        'f' => ['name' => 'Farads', 'symbol' => 'F', 'factor' => 1],
        'mf' => ['name' => 'Millifarads', 'symbol' => 'mF', 'factor' => 1e-3],
        'uf' => ['name' => 'Microfarads', 'symbol' => 'µF', 'factor' => 1e-6],
        'nf' => ['name' => 'Nanofarads', 'symbol' => 'nF', 'factor' => 1e-9],
        'pf' => ['name' => 'Picofarads', 'symbol' => 'pF', 'factor' => 1e-12],
        'ff' => ['name' => 'Femtofarads', 'symbol' => 'fF', 'factor' => 1e-15],
        'af' => ['name' => 'Attofarads', 'symbol' => 'aF', 'factor' => 1e-18],
    ],

    // Base: second. Month and year are Gregorian calendar averages (365.2425 days per year).
    'time' => [
        'ns' => ['name' => 'Nanoseconds', 'symbol' => 'ns', 'factor' => 1e-9],
        'us' => ['name' => 'Microseconds', 'symbol' => 'µs', 'factor' => 1e-6],
        'ms' => ['name' => 'Milliseconds', 'symbol' => 'ms', 'factor' => 1e-3],
        's' => ['name' => 'Seconds', 'symbol' => 's', 'factor' => 1],
        'min' => ['name' => 'Minutes', 'symbol' => 'min', 'factor' => 60],
        'h' => ['name' => 'Hours', 'symbol' => 'h', 'factor' => 3600],
        'day' => ['name' => 'Days', 'symbol' => 'd', 'factor' => 86400],
        'week' => ['name' => 'Weeks', 'symbol' => 'wk', 'factor' => 604800],
        'fortnight' => ['name' => 'Fortnights', 'symbol' => 'fn', 'factor' => 1209600],
        'month' => ['name' => 'Months (average)', 'symbol' => 'mo', 'factor' => 2629746],
        'year' => ['name' => 'Years (average)', 'symbol' => 'yr', 'factor' => 31556952],
        'decade' => ['name' => 'Decades', 'symbol' => 'dec', 'factor' => 315569520],
        'century' => ['name' => 'Centuries', 'symbol' => 'c', 'factor' => 3155695200],
        'millennium' => ['name' => 'Millennia', 'symbol' => 'ka', 'factor' => 31556952000],
    ],

    // Base: degree Celsius. value → °C as (value + offset) × factor.
    'temperature' => [
        'c' => ['name' => 'Celsius', 'symbol' => '°C', 'factor' => 1],
        'f' => ['name' => 'Fahrenheit', 'symbol' => '°F', 'factor' => 5 / 9, 'offset' => -32],
        'k' => ['name' => 'Kelvin', 'symbol' => 'K', 'factor' => 1, 'offset' => -273.15],
        'r' => ['name' => 'Rankine', 'symbol' => '°R', 'factor' => 5 / 9, 'offset' => -491.67],
        'de' => ['name' => 'Delisle', 'symbol' => '°De', 'factor' => -2 / 3, 'offset' => -150],
        'n' => ['name' => 'Newton', 'symbol' => '°N', 'factor' => 100 / 33],
        're' => ['name' => 'Réaumur', 'symbol' => '°Ré', 'factor' => 5 / 4],
        'ro' => ['name' => 'Rømer', 'symbol' => '°Rø', 'factor' => 40 / 21, 'offset' => -7.5],
    ],

    // Base: kg/m³ (= g/L). Specific gravity, API and Baumé are relative to water at 60 °F (999.016 kg/m³).
    'density' => [
        'kgm3' => ['name' => 'Kilograms per cubic meter', 'symbol' => 'kg/m³', 'factor' => 1],
        'gcm3' => ['name' => 'Grams per cubic centimeter (= g/mL, kg/L)', 'symbol' => 'g/cm³', 'factor' => 1000],
        'mgl' => ['name' => 'Milligrams per liter', 'symbol' => 'mg/L', 'factor' => 0.001],
        'lbft3' => ['name' => 'Pounds per cubic foot', 'symbol' => 'lb/ft³', 'factor' => 0.45359237 / 0.028316846592],
        'lbin3' => ['name' => 'Pounds per cubic inch', 'symbol' => 'lb/in³', 'factor' => 0.45359237 / 0.000016387064],
        'lbgal' => ['name' => 'Pounds per US gallon', 'symbol' => 'lb/gal', 'factor' => 0.45359237 / 0.003785411784],
        'lbgal_uk' => ['name' => 'Pounds per imperial gallon', 'symbol' => 'lb/imp gal', 'factor' => 0.45359237 / 0.00454609],
        'ozin3' => ['name' => 'Ounces per cubic inch', 'symbol' => 'oz/in³', 'factor' => 0.028349523125 / 0.000016387064],
        'slugft3' => ['name' => 'Slugs per cubic foot', 'symbol' => 'slug/ft³', 'factor' => 14.593902937206364 / 0.028316846592],
        'sg' => ['name' => 'Specific gravity', 'symbol' => 'SG', 'factor' => 999.016],
        'api' => ['name' => 'API gravity', 'symbol' => '°API', 'factor' => 141.5 * 999.016, 'inverse' => true, 'offset' => 131.5],
        'be_light' => ['name' => 'Baumé (lighter than water)', 'symbol' => '°Bé', 'factor' => 140 * 999.016, 'inverse' => true, 'offset' => 130],
        'be_heavy' => ['name' => 'Baumé (heavier than water)', 'symbol' => '°Bé', 'factor' => 145 * 999.016, 'inverse' => true, 'offset' => 145, 'scale' => -1],
    ],

    // Base: BTU. Volumes use a heating value of 1,037 BTU per cubic foot (US average).
    'natural_gas' => [
        'ft3' => ['name' => 'Cubic feet', 'symbol' => 'ft³', 'factor' => 1037],
        'ccf' => ['name' => 'Hundred cubic feet', 'symbol' => 'CCF', 'factor' => 103700],
        'mcf' => ['name' => 'Thousand cubic feet', 'symbol' => 'Mcf', 'factor' => 1037000],
        'm3' => ['name' => 'Cubic meters', 'symbol' => 'm³', 'factor' => 1037 / 0.028316846592],
        'btu' => ['name' => 'British thermal units', 'symbol' => 'BTU', 'factor' => 1],
        'therm' => ['name' => 'Therms', 'symbol' => 'thm', 'factor' => 100000],
        'dth' => ['name' => 'Dekatherms (MMBtu)', 'symbol' => 'Dth', 'factor' => 1e6],
        'kwh' => ['name' => 'Kilowatt-hours', 'symbol' => 'kWh', 'factor' => 3.6e6 / 1055.05585262],
        'mj' => ['name' => 'Megajoules', 'symbol' => 'MJ', 'factor' => 1e6 / 1055.05585262],
        'gj' => ['name' => 'Gigajoules', 'symbol' => 'GJ', 'factor' => 1e9 / 1055.05585262],
    ],

    // Radiation: one table per quantity, because units only convert within a quantity.
    'radiation_dose' => [
        'gy' => ['name' => 'Gray', 'symbol' => 'Gy', 'factor' => 1],
        'mgy' => ['name' => 'Milligray', 'symbol' => 'mGy', 'factor' => 1e-3],
        'ugy' => ['name' => 'Microgray', 'symbol' => 'µGy', 'factor' => 1e-6],
        'rad' => ['name' => 'Rad', 'symbol' => 'rad', 'factor' => 0.01],
        'mrad' => ['name' => 'Millirad', 'symbol' => 'mrad', 'factor' => 1e-5],
    ],

    'radiation_equivalent' => [
        'sv' => ['name' => 'Sievert', 'symbol' => 'Sv', 'factor' => 1],
        'msv' => ['name' => 'Millisievert', 'symbol' => 'mSv', 'factor' => 1e-3],
        'usv' => ['name' => 'Microsievert', 'symbol' => 'µSv', 'factor' => 1e-6],
        'rem' => ['name' => 'Rem', 'symbol' => 'rem', 'factor' => 0.01],
        'mrem' => ['name' => 'Millirem', 'symbol' => 'mrem', 'factor' => 1e-5],
    ],

    'radiation_activity' => [
        'bq' => ['name' => 'Becquerel', 'symbol' => 'Bq', 'factor' => 1],
        'kbq' => ['name' => 'Kilobecquerel', 'symbol' => 'kBq', 'factor' => 1e3],
        'mbq' => ['name' => 'Megabecquerel', 'symbol' => 'MBq', 'factor' => 1e6],
        'gbq' => ['name' => 'Gigabecquerel', 'symbol' => 'GBq', 'factor' => 1e9],
        'tbq' => ['name' => 'Terabecquerel', 'symbol' => 'TBq', 'factor' => 1e12],
        'ci' => ['name' => 'Curie', 'symbol' => 'Ci', 'factor' => 3.7e10],
        'mci' => ['name' => 'Millicurie', 'symbol' => 'mCi', 'factor' => 3.7e7],
        'uci' => ['name' => 'Microcurie', 'symbol' => 'µCi', 'factor' => 3.7e4],
        'dpm' => ['name' => 'Disintegrations per minute', 'symbol' => 'dpm', 'factor' => 1 / 60],
    ],

    'radiation_exposure' => [
        'ckg' => ['name' => 'Coulombs per kilogram', 'symbol' => 'C/kg', 'factor' => 1],
        'mckg' => ['name' => 'Millicoulombs per kilogram', 'symbol' => 'mC/kg', 'factor' => 1e-3],
        'r' => ['name' => 'Roentgen', 'symbol' => 'R', 'factor' => 2.58e-4],
        'mr' => ['name' => 'Milliroentgen', 'symbol' => 'mR', 'factor' => 2.58e-7],
    ],

    // CGS quantities that have no table above. Oersted = 1000/(4π) A/m; statcoulomb = 0.1/c C.
    'cgs_extra' => [
        'p' => ['name' => 'Poise', 'symbol' => 'P', 'factor' => 0.1, 'base' => 'viscosity'],
        'cp' => ['name' => 'Centipoise', 'symbol' => 'cP', 'factor' => 0.001, 'base' => 'viscosity'],
        'pas' => ['name' => 'Pascal seconds', 'symbol' => 'Pa·s', 'factor' => 1, 'base' => 'viscosity'],
        'st' => ['name' => 'Stokes', 'symbol' => 'St', 'factor' => 1e-4, 'base' => 'kinematic'],
        'cst' => ['name' => 'Centistokes', 'symbol' => 'cSt', 'factor' => 1e-6, 'base' => 'kinematic'],
        'm2s' => ['name' => 'Square meters per second', 'symbol' => 'm²/s', 'factor' => 1, 'base' => 'kinematic'],
        'gal' => ['name' => 'Gal', 'symbol' => 'Gal', 'factor' => 0.01, 'base' => 'acceleration'],
        'ms2' => ['name' => 'Meters per second squared', 'symbol' => 'm/s²', 'factor' => 1, 'base' => 'acceleration'],
        'g0' => ['name' => 'Standard gravity', 'symbol' => 'g₀', 'factor' => 9.80665, 'base' => 'acceleration'],
        'gauss' => ['name' => 'Gauss', 'symbol' => 'G', 'factor' => 1e-4, 'base' => 'flux_density'],
        'tesla' => ['name' => 'Tesla', 'symbol' => 'T', 'factor' => 1, 'base' => 'flux_density'],
        'mx' => ['name' => 'Maxwell', 'symbol' => 'Mx', 'factor' => 1e-8, 'base' => 'flux'],
        'wb' => ['name' => 'Weber', 'symbol' => 'Wb', 'factor' => 1, 'base' => 'flux'],
        'oe' => ['name' => 'Oersted', 'symbol' => 'Oe', 'factor' => 1000 / (4 * M_PI), 'base' => 'field'],
        'am' => ['name' => 'Amperes per meter', 'symbol' => 'A/m', 'factor' => 1, 'base' => 'field'],
        'statc' => ['name' => 'Statcoulomb', 'symbol' => 'statC', 'factor' => 0.1 / 299792458, 'base' => 'charge'],
        'coulomb' => ['name' => 'Coulomb', 'symbol' => 'C', 'factor' => 1, 'base' => 'charge'],
        'ergs' => ['name' => 'Ergs per second', 'symbol' => 'erg/s', 'factor' => 1e-7, 'base' => 'power'],
        'watt' => ['name' => 'Watts', 'symbol' => 'W', 'factor' => 1, 'base' => 'power'],
    ],

    // Base: hertz (cycles per second). Periods are inverse units.
    'frequency' => [
        'hz' => ['name' => 'Hertz (cycles per second)', 'symbol' => 'Hz', 'factor' => 1],
        'khz' => ['name' => 'Kilohertz', 'symbol' => 'kHz', 'factor' => 1e3],
        'mhz' => ['name' => 'Megahertz', 'symbol' => 'MHz', 'factor' => 1e6],
        'ghz' => ['name' => 'Gigahertz', 'symbol' => 'GHz', 'factor' => 1e9],
        'rpm' => ['name' => 'Revolutions per minute', 'symbol' => 'rpm', 'factor' => 1 / 60],
        'rads' => ['name' => 'Radians per second', 'symbol' => 'rad/s', 'factor' => 1 / (2 * M_PI)],
        'bpm' => ['name' => 'Beats per minute', 'symbol' => 'bpm', 'factor' => 1 / 60],
        'period_s' => ['name' => 'Period in seconds', 'symbol' => 's', 'factor' => 1, 'inverse' => true],
        'period_ms' => ['name' => 'Period in milliseconds', 'symbol' => 'ms', 'factor' => 1000, 'inverse' => true],
        'period_us' => ['name' => 'Period in microseconds', 'symbol' => 'µs', 'factor' => 1e6, 'inverse' => true],
    ],

    // Base: one item.
    'count' => [
        'each' => ['name' => 'Single items', 'symbol' => 'pcs', 'factor' => 1],
        'pair' => ['name' => 'Pairs', 'symbol' => 'pr', 'factor' => 2],
        'half_dozen' => ['name' => 'Half dozens', 'symbol' => '½ doz', 'factor' => 6],
        'dozen' => ['name' => 'Dozens', 'symbol' => 'doz', 'factor' => 12],
        'bakers_dozen' => ['name' => "Baker's dozens", 'symbol' => "baker's doz", 'factor' => 13],
        'score' => ['name' => 'Scores', 'symbol' => 'score', 'factor' => 20],
        'quire' => ['name' => 'Quires (paper)', 'symbol' => 'quire', 'factor' => 25],
        'hundred' => ['name' => 'Hundreds', 'symbol' => 'C', 'factor' => 100],
        'gross' => ['name' => 'Gross', 'symbol' => 'gr', 'factor' => 144],
        'ream' => ['name' => 'Reams (paper)', 'symbol' => 'ream', 'factor' => 500],
        'thousand' => ['name' => 'Thousands', 'symbol' => 'M', 'factor' => 1000],
        'great_gross' => ['name' => 'Great gross', 'symbol' => 'great gr', 'factor' => 1728],
    ],

    // Quirky units: approximate by nature, grouped by quantity.
    'weird_length' => [
        'm' => ['name' => 'Meters', 'symbol' => 'm', 'factor' => 1],
        'ft' => ['name' => 'Feet', 'symbol' => 'ft', 'factor' => 0.3048],
        'smoot' => ['name' => 'Smoots', 'symbol' => 'smoot', 'factor' => 1.7018],
        'banana' => ['name' => 'Bananas (7 in)', 'symbol' => 'banana', 'factor' => 0.1778],
        'football_field' => ['name' => 'US football fields (100 yd)', 'symbol' => 'field', 'factor' => 91.44],
        'cubit' => ['name' => 'Cubits', 'symbol' => 'cubit', 'factor' => 0.4572],
        'furlong' => ['name' => 'Furlongs', 'symbol' => 'fur', 'factor' => 201.168],
        'light_ns' => ['name' => 'Light-nanoseconds', 'symbol' => 'light-ns', 'factor' => 0.299792458],
        'attoparsec' => ['name' => 'Attoparsecs', 'symbol' => 'apc', 'factor' => 0.030856775814913673],
        'beard_second' => ['name' => 'Beard-seconds (5 nm)', 'symbol' => 'beard-s', 'factor' => 5e-9],
    ],

    'weird_time' => [
        's' => ['name' => 'Seconds', 'symbol' => 's', 'factor' => 1],
        'min' => ['name' => 'Minutes', 'symbol' => 'min', 'factor' => 60],
        'day' => ['name' => 'Days', 'symbol' => 'd', 'factor' => 86400],
        'jiffy' => ['name' => 'Jiffies (1/60 s)', 'symbol' => 'jiffy', 'factor' => 1 / 60],
        'moment' => ['name' => 'Medieval moments (90 s)', 'symbol' => 'moment', 'factor' => 90],
        'microcentury' => ['name' => 'Microcenturies', 'symbol' => 'µcentury', 'factor' => 3155.6952],
        'fortnight' => ['name' => 'Fortnights', 'symbol' => 'fortnight', 'factor' => 1209600],
    ],

    'weird_data' => [
        'b' => ['name' => 'Bytes', 'symbol' => 'B', 'factor' => 1],
        'mb' => ['name' => 'Megabytes', 'symbol' => 'MB', 'factor' => 1e6],
        'gb' => ['name' => 'Gigabytes', 'symbol' => 'GB', 'factor' => 1e9],
        'floppy' => ['name' => 'Floppy disks (1.44 MB)', 'symbol' => 'floppy', 'factor' => 1474560],
        'cd' => ['name' => 'CDs (700 MB)', 'symbol' => 'CD', 'factor' => 700 * 1024 ** 2],
        'dvd' => ['name' => 'DVDs (4.7 GB)', 'symbol' => 'DVD', 'factor' => 4.7e9],
        'library_of_congress' => ['name' => 'Libraries of Congress (10 TB, informal)', 'symbol' => 'LoC', 'factor' => 1e13],
    ],

    'weird_mass' => [
        'kg' => ['name' => 'Kilograms', 'symbol' => 'kg', 'factor' => 1],
        'lb' => ['name' => 'Pounds', 'symbol' => 'lb', 'factor' => 0.45359237],
        'penny' => ['name' => 'US pennies (2.5 g)', 'symbol' => 'penny', 'factor' => 0.0025],
        'paperclip' => ['name' => 'Paper clips (1 g)', 'symbol' => 'clip', 'factor' => 0.001],
        'elephant' => ['name' => 'African elephants (6 t)', 'symbol' => 'elephant', 'factor' => 6000],
        'blue_whale' => ['name' => 'Blue whales (150 t)', 'symbol' => 'whale', 'factor' => 150000],
    ],

    /*
    | Physics quantities. Each table's base is the SI unit (factor 1); the
    | Physics section reads them through `physics/core.js`.
    */

    // Base: m/s². Standard gravity g₀ = 9.80665 m/s² exactly (CGPM 1901).
    'acceleration' => [
        'ms2' => ['name' => 'Meters per second squared', 'symbol' => 'm/s²', 'factor' => 1],
        'cms2' => ['name' => 'Centimeters per second squared (Gal)', 'symbol' => 'cm/s²', 'factor' => 0.01],
        'fts2' => ['name' => 'Feet per second squared', 'symbol' => 'ft/s²', 'factor' => 0.3048],
        'ins2' => ['name' => 'Inches per second squared', 'symbol' => 'in/s²', 'factor' => 0.0254],
        'kmhs' => ['name' => 'Kilometers per hour per second', 'symbol' => 'km/h/s', 'factor' => 1 / 3.6],
        'mphs' => ['name' => 'Miles per hour per second', 'symbol' => 'mph/s', 'factor' => 0.44704],
        'g0' => ['name' => 'Standard gravity', 'symbol' => 'g', 'factor' => 9.80665],
    ],

    // Base: kg·m/s (= N·s).
    'momentum' => [
        'kgms' => ['name' => 'Kilogram meters per second (newton seconds)', 'symbol' => 'kg·m/s', 'factor' => 1],
        'gcms' => ['name' => 'Gram centimeters per second', 'symbol' => 'g·cm/s', 'factor' => 1e-5],
        'lbfts' => ['name' => 'Pound feet per second', 'symbol' => 'lb·ft/s', 'factor' => 0.45359237 * 0.3048],
        'lbfs' => ['name' => 'Pound-force seconds', 'symbol' => 'lbf·s', 'factor' => 0.45359237 * 9.80665],
    ],

    // Base: kg·m²/s.
    'angular_momentum' => [
        'kgm2s' => ['name' => 'Kilogram square meters per second (joule seconds)', 'symbol' => 'kg·m²/s', 'factor' => 1],
        'gcm2s' => ['name' => 'Gram square centimeters per second', 'symbol' => 'g·cm²/s', 'factor' => 1e-7],
        'lbft2s' => ['name' => 'Pound square feet per second', 'symbol' => 'lb·ft²/s', 'factor' => 0.45359237 * 0.3048 ** 2],
    ],

    // Base: rad/s.
    'angular_speed' => [
        'rads' => ['name' => 'Radians per second', 'symbol' => 'rad/s', 'factor' => 1],
        'rpm' => ['name' => 'Revolutions per minute', 'symbol' => 'rpm', 'factor' => 2 * M_PI / 60],
        'rps' => ['name' => 'Revolutions per second', 'symbol' => 'rev/s', 'factor' => 2 * M_PI],
        'degs' => ['name' => 'Degrees per second', 'symbol' => '°/s', 'factor' => M_PI / 180],
        'radmin' => ['name' => 'Radians per minute', 'symbol' => 'rad/min', 'factor' => 1 / 60],
    ],

    // Base: rad/s².
    'angular_acceleration' => [
        'rads2' => ['name' => 'Radians per second squared', 'symbol' => 'rad/s²', 'factor' => 1],
        'degs2' => ['name' => 'Degrees per second squared', 'symbol' => '°/s²', 'factor' => M_PI / 180],
        'rpms' => ['name' => 'rpm per second', 'symbol' => 'rpm/s', 'factor' => 2 * M_PI / 60],
        'revs2' => ['name' => 'Revolutions per second squared', 'symbol' => 'rev/s²', 'factor' => 2 * M_PI],
    ],

    // Base: N/m.
    'stiffness' => [
        'npm' => ['name' => 'Newtons per meter', 'symbol' => 'N/m', 'factor' => 1],
        'npmm' => ['name' => 'Newtons per millimeter', 'symbol' => 'N/mm', 'factor' => 1000],
        'knpm' => ['name' => 'Kilonewtons per meter', 'symbol' => 'kN/m', 'factor' => 1000],
        'npcm' => ['name' => 'Newtons per centimeter', 'symbol' => 'N/cm', 'factor' => 100],
        'lbfpin' => ['name' => 'Pound-force per inch', 'symbol' => 'lbf/in', 'factor' => 0.45359237 * 9.80665 / 0.0254],
        'lbfpft' => ['name' => 'Pound-force per foot', 'symbol' => 'lbf/ft', 'factor' => 0.45359237 * 9.80665 / 0.3048],
        'kgfpmm' => ['name' => 'Kilogram-force per millimeter', 'symbol' => 'kgf/mm', 'factor' => 9.80665 * 1000],
    ],

    // Base: N·m/rad.
    'rotational_stiffness' => [
        'nmrad' => ['name' => 'Newton meters per radian', 'symbol' => 'N·m/rad', 'factor' => 1],
        'nmdeg' => ['name' => 'Newton meters per degree', 'symbol' => 'N·m/°', 'factor' => 180 / M_PI],
        'knmrad' => ['name' => 'Kilonewton meters per radian', 'symbol' => 'kN·m/rad', 'factor' => 1000],
        'lbfinrad' => ['name' => 'Pound-force inches per radian', 'symbol' => 'lbf·in/rad', 'factor' => 0.45359237 * 9.80665 * 0.0254],
        'lbfindeg' => ['name' => 'Pound-force inches per degree', 'symbol' => 'lbf·in/°', 'factor' => 0.45359237 * 9.80665 * 0.0254 * 180 / M_PI],
    ],

    // Base: ampere.
    'current' => [
        'a' => ['name' => 'Amperes', 'symbol' => 'A', 'factor' => 1],
        'ma' => ['name' => 'Milliamperes', 'symbol' => 'mA', 'factor' => 1e-3],
        'ua' => ['name' => 'Microamperes', 'symbol' => 'µA', 'factor' => 1e-6],
        'na' => ['name' => 'Nanoamperes', 'symbol' => 'nA', 'factor' => 1e-9],
        'ka' => ['name' => 'Kiloamperes', 'symbol' => 'kA', 'factor' => 1e3],
    ],

    // Base: volt.
    'voltage' => [
        'v' => ['name' => 'Volts', 'symbol' => 'V', 'factor' => 1],
        'mv' => ['name' => 'Millivolts', 'symbol' => 'mV', 'factor' => 1e-3],
        'uv' => ['name' => 'Microvolts', 'symbol' => 'µV', 'factor' => 1e-6],
        'kv' => ['name' => 'Kilovolts', 'symbol' => 'kV', 'factor' => 1e3],
        'megav' => ['name' => 'Megavolts', 'symbol' => 'MV', 'factor' => 1e6],
    ],

    // Base: ohm.
    'resistance' => [
        'ohm' => ['name' => 'Ohms', 'symbol' => 'Ω', 'factor' => 1],
        'mohm' => ['name' => 'Milliohms', 'symbol' => 'mΩ', 'factor' => 1e-3],
        'kohm' => ['name' => 'Kilohms', 'symbol' => 'kΩ', 'factor' => 1e3],
        'megohm' => ['name' => 'Megohms', 'symbol' => 'MΩ', 'factor' => 1e6],
        'gohm' => ['name' => 'Gigohms', 'symbol' => 'GΩ', 'factor' => 1e9],
    ],

    // Base: henry.
    'inductance' => [
        'h' => ['name' => 'Henries', 'symbol' => 'H', 'factor' => 1],
        'mh' => ['name' => 'Millihenries', 'symbol' => 'mH', 'factor' => 1e-3],
        'uh' => ['name' => 'Microhenries', 'symbol' => 'µH', 'factor' => 1e-6],
        'nh' => ['name' => 'Nanohenries', 'symbol' => 'nH', 'factor' => 1e-9],
    ],

    // Base: tesla. 1 gauss = 10⁻⁴ T.
    'magnetic_field' => [
        't' => ['name' => 'Teslas', 'symbol' => 'T', 'factor' => 1],
        'mt' => ['name' => 'Milliteslas', 'symbol' => 'mT', 'factor' => 1e-3],
        'ut' => ['name' => 'Microteslas', 'symbol' => 'µT', 'factor' => 1e-6],
        'nt' => ['name' => 'Nanoteslas', 'symbol' => 'nT', 'factor' => 1e-9],
        'gauss' => ['name' => 'Gauss', 'symbol' => 'G', 'factor' => 1e-4],
        'mgauss' => ['name' => 'Milligauss', 'symbol' => 'mG', 'factor' => 1e-7],
    ],

    // Base: V/m.
    'electric_field' => [
        'vpm' => ['name' => 'Volts per meter', 'symbol' => 'V/m', 'factor' => 1],
        'kvpm' => ['name' => 'Kilovolts per meter', 'symbol' => 'kV/m', 'factor' => 1e3],
        'vpcm' => ['name' => 'Volts per centimeter', 'symbol' => 'V/cm', 'factor' => 100],
        'kvpcm' => ['name' => 'Kilovolts per centimeter', 'symbol' => 'kV/cm', 'factor' => 1e5],
        'mvpm' => ['name' => 'Megavolts per meter', 'symbol' => 'MV/m', 'factor' => 1e6],
    ],

    // Base: m³/s.
    'flow' => [
        'm3s' => ['name' => 'Cubic meters per second', 'symbol' => 'm³/s', 'factor' => 1],
        'm3h' => ['name' => 'Cubic meters per hour', 'symbol' => 'm³/h', 'factor' => 1 / 3600],
        'ls' => ['name' => 'Liters per second', 'symbol' => 'L/s', 'factor' => 1e-3],
        'lmin' => ['name' => 'Liters per minute', 'symbol' => 'L/min', 'factor' => 1e-3 / 60],
        'gpm' => ['name' => 'US gallons per minute', 'symbol' => 'gpm', 'factor' => 231 * 0.0254 ** 3 / 60],
        'cfm' => ['name' => 'Cubic feet per minute', 'symbol' => 'cfm', 'factor' => 0.3048 ** 3 / 60],
        'cfs' => ['name' => 'Cubic feet per second', 'symbol' => 'ft³/s', 'factor' => 0.3048 ** 3],
    ],

    // Base: kg/s.
    'mass_flow' => [
        'kgs' => ['name' => 'Kilograms per second', 'symbol' => 'kg/s', 'factor' => 1],
        'gs' => ['name' => 'Grams per second', 'symbol' => 'g/s', 'factor' => 1e-3],
        'kgmin' => ['name' => 'Kilograms per minute', 'symbol' => 'kg/min', 'factor' => 1 / 60],
        'kgh' => ['name' => 'Kilograms per hour', 'symbol' => 'kg/h', 'factor' => 1 / 3600],
        'lbs' => ['name' => 'Pounds per second', 'symbol' => 'lb/s', 'factor' => 0.45359237],
        'lbmin' => ['name' => 'Pounds per minute', 'symbol' => 'lb/min', 'factor' => 0.45359237 / 60],
        'lbh' => ['name' => 'Pounds per hour', 'symbol' => 'lb/h', 'factor' => 0.45359237 / 3600],
    ],

    // Base: Pa·s.
    'viscosity' => [
        'pas' => ['name' => 'Pascal seconds', 'symbol' => 'Pa·s', 'factor' => 1],
        'mpas' => ['name' => 'Millipascal seconds', 'symbol' => 'mPa·s', 'factor' => 1e-3],
        'cp' => ['name' => 'Centipoise', 'symbol' => 'cP', 'factor' => 1e-3],
        'p' => ['name' => 'Poise', 'symbol' => 'P', 'factor' => 0.1],
        'lbfts' => ['name' => 'Pound per foot second', 'symbol' => 'lb/(ft·s)', 'factor' => 0.45359237 / 0.3048],
    ],

    // Base: m²/s.
    'kinematic_viscosity' => [
        'm2s' => ['name' => 'Square meters per second', 'symbol' => 'm²/s', 'factor' => 1],
        'mm2s' => ['name' => 'Square millimeters per second', 'symbol' => 'mm²/s', 'factor' => 1e-6],
        'cst' => ['name' => 'Centistokes', 'symbol' => 'cSt', 'factor' => 1e-6],
        'st' => ['name' => 'Stokes', 'symbol' => 'St', 'factor' => 1e-4],
        'ft2s' => ['name' => 'Square feet per second', 'symbol' => 'ft²/s', 'factor' => 0.3048 ** 2],
    ],

    // Base: kg·m².
    'moment_of_inertia' => [
        'kgm2' => ['name' => 'Kilogram square meters', 'symbol' => 'kg·m²', 'factor' => 1],
        'gcm2' => ['name' => 'Gram square centimeters', 'symbol' => 'g·cm²', 'factor' => 1e-7],
        'kgcm2' => ['name' => 'Kilogram square centimeters', 'symbol' => 'kg·cm²', 'factor' => 1e-4],
        'lbft2' => ['name' => 'Pound square feet', 'symbol' => 'lb·ft²', 'factor' => 0.45359237 * 0.3048 ** 2],
        'lbin2' => ['name' => 'Pound square inches', 'symbol' => 'lb·in²', 'factor' => 0.45359237 * 0.0254 ** 2],
    ],

    // Base: m⁴ (second moment of area).
    'area_moment' => [
        'm4' => ['name' => 'Meters to the fourth', 'symbol' => 'm⁴', 'factor' => 1],
        'cm4' => ['name' => 'Centimeters to the fourth', 'symbol' => 'cm⁴', 'factor' => 1e-8],
        'mm4' => ['name' => 'Millimeters to the fourth', 'symbol' => 'mm⁴', 'factor' => 1e-12],
        'in4' => ['name' => 'Inches to the fourth', 'symbol' => 'in⁴', 'factor' => 0.0254 ** 4],
        'ft4' => ['name' => 'Feet to the fourth', 'symbol' => 'ft⁴', 'factor' => 0.3048 ** 4],
    ],

    // Base: kelvin (a difference, so no offsets).
    'temperature_difference' => [
        'k' => ['name' => 'Kelvins', 'symbol' => 'K', 'factor' => 1],
        // A step of 1 °C equals 1 K, so this is the same unit under its everyday name.
        'c' => ['name' => 'Degrees Celsius', 'symbol' => '°C', 'factor' => 1, 'alias' => true],
        'f' => ['name' => 'Degrees Fahrenheit', 'symbol' => '°F', 'factor' => 5 / 9],
        'r' => ['name' => 'Rankine', 'symbol' => '°R', 'factor' => 5 / 9],
    ],

    // Base: lux. 1 fc = 1 lm/ft².
    'illuminance' => [
        'lx' => ['name' => 'Lux', 'symbol' => 'lx', 'factor' => 1],
        'fc' => ['name' => 'Foot-candles', 'symbol' => 'fc', 'factor' => 1 / 0.3048 ** 2],
        'phot' => ['name' => 'Phot', 'symbol' => 'ph', 'factor' => 1e4],
        'klx' => ['name' => 'Kilolux', 'symbol' => 'klx', 'factor' => 1e3],
    ],

    // Base: W/(m·K). 1 BTU/(h·ft·°F) uses the IT BTU.
    'thermal_conductivity' => [
        'wmk' => ['name' => 'Watts per meter kelvin', 'symbol' => 'W/(m·K)', 'factor' => 1],
        'btuhftf' => ['name' => 'BTU per hour foot °F', 'symbol' => 'BTU/(h·ft·°F)', 'factor' => 1055.05585262 / 3600 / 0.3048 / (5 / 9)],
        'calscmc' => ['name' => 'Calories per second centimeter °C', 'symbol' => 'cal/(s·cm·°C)', 'factor' => 418.4],
        'mwmk' => ['name' => 'Milliwatts per meter kelvin', 'symbol' => 'mW/(m·K)', 'factor' => 1e-3],
    ],

    // Base: J/(kg·K).
    'specific_heat' => [
        'jkgk' => ['name' => 'Joules per kilogram kelvin', 'symbol' => 'J/(kg·K)', 'factor' => 1],
        'kjkgk' => ['name' => 'Kilojoules per kilogram kelvin', 'symbol' => 'kJ/(kg·K)', 'factor' => 1000],
        'jgk' => ['name' => 'Joules per gram kelvin', 'symbol' => 'J/(g·K)', 'factor' => 1000],
        'calgc' => ['name' => 'Calories per gram °C', 'symbol' => 'cal/(g·°C)', 'factor' => 4184],
        'btulbf' => ['name' => 'BTU per pound °F', 'symbol' => 'BTU/(lb·°F)', 'factor' => 1055.05585262 / 0.45359237 / (5 / 9)],
    ],

    // Base: W/(m²·K).
    'heat_transfer_coefficient' => [
        'wm2k' => ['name' => 'Watts per square meter kelvin', 'symbol' => 'W/(m²·K)', 'factor' => 1],
        'kwm2k' => ['name' => 'Kilowatts per square meter kelvin', 'symbol' => 'kW/(m²·K)', 'factor' => 1000],
        'btuhft2f' => ['name' => 'BTU per hour square foot °F', 'symbol' => 'BTU/(h·ft²·°F)', 'factor' => 1055.05585262 / 3600 / 0.3048 ** 2 / (5 / 9)],
    ],

    // Base: W/m² (irradiance, intensity, heat flux).
    'intensity' => [
        'wm2' => ['name' => 'Watts per square meter', 'symbol' => 'W/m²', 'factor' => 1],
        'kwm2' => ['name' => 'Kilowatts per square meter', 'symbol' => 'kW/m²', 'factor' => 1e3],
        'mwcm2' => ['name' => 'Milliwatts per square centimeter', 'symbol' => 'mW/cm²', 'factor' => 10],
        'wcm2' => ['name' => 'Watts per square centimeter', 'symbol' => 'W/cm²', 'factor' => 1e4],
        'btuhft2' => ['name' => 'BTU per hour square foot', 'symbol' => 'BTU/(h·ft²)', 'factor' => 1055.05585262 / 3600 / 0.3048 ** 2],
    ],

    // Base: Ω·m.
    'resistivity' => [
        'ohmm' => ['name' => 'Ohm meters', 'symbol' => 'Ω·m', 'factor' => 1],
        'ohmcm' => ['name' => 'Ohm centimeters', 'symbol' => 'Ω·cm', 'factor' => 0.01],
        'uohmcm' => ['name' => 'Microhm centimeters', 'symbol' => 'µΩ·cm', 'factor' => 1e-8],
        'nohmm' => ['name' => 'Nanohm meters', 'symbol' => 'nΩ·m', 'factor' => 1e-9],
        'ohmmm2m' => ['name' => 'Ohm square millimeters per meter', 'symbol' => 'Ω·mm²/m', 'factor' => 1e-6],
    ],

    // Base: hertz.
    'frequency_hz' => [
        'hz' => ['name' => 'Hertz', 'symbol' => 'Hz', 'factor' => 1],
        'khz' => ['name' => 'Kilohertz', 'symbol' => 'kHz', 'factor' => 1e3],
        'mhz' => ['name' => 'Megahertz', 'symbol' => 'MHz', 'factor' => 1e6],
        'ghz' => ['name' => 'Gigahertz', 'symbol' => 'GHz', 'factor' => 1e9],
        'thz' => ['name' => 'Terahertz', 'symbol' => 'THz', 'factor' => 1e12],
        'mhz_milli' => ['name' => 'Millihertz', 'symbol' => 'mHz', 'factor' => 1e-3],
        'rpm' => ['name' => 'Revolutions per minute', 'symbol' => 'rpm', 'factor' => 1 / 60],
    ],

    // Base: kilogram. Atomic mass constant and electron mass: CODATA 2018.
    'particle_mass' => [
        'kg' => ['name' => 'Kilograms', 'symbol' => 'kg', 'factor' => 1],
        'g' => ['name' => 'Grams', 'symbol' => 'g', 'factor' => 1e-3],
        'u' => ['name' => 'Atomic mass units (Da)', 'symbol' => 'u', 'factor' => 1.66053906660e-27],
        'me' => ['name' => 'Electron masses', 'symbol' => 'mₑ', 'factor' => 9.1093837015e-31],
        'mevc2' => ['name' => 'MeV/c²', 'symbol' => 'MeV/c²', 'factor' => 1.602176634e-13 / 299792458 ** 2],
    ],

    // Base: kilogram. Solar mass from the IAU 2015 nominal GM☉ ÷ G (CODATA 2018); Earth and
    // Jupiter from NASA/JPL GM ÷ G; Moon from NASA Moon Fact Sheet.
    'astro_mass' => [
        'kg' => ['name' => 'Kilograms', 'symbol' => 'kg', 'factor' => 1],
        't' => ['name' => 'Tonnes', 'symbol' => 't', 'factor' => 1000],
        'mmoon' => ['name' => 'Moon masses', 'symbol' => 'M☾', 'factor' => 7.342e22],
        'mearth' => ['name' => 'Earth masses', 'symbol' => 'M⊕', 'factor' => 5.9722e24],
        'mjup' => ['name' => 'Jupiter masses', 'symbol' => 'M♃', 'factor' => 1.89813e27],
        'msun' => ['name' => 'Solar masses', 'symbol' => 'M☉', 'factor' => 1.32712440018e20 / 6.6743e-11],
    ],

    // Base: joule. 1 eV = 1.602176634e-19 J exactly (SI 2019).
    'particle_energy' => [
        'ev' => ['name' => 'Electronvolts', 'symbol' => 'eV', 'factor' => 1.602176634e-19],
        'mev_milli' => ['name' => 'Millielectronvolts', 'symbol' => 'meV', 'factor' => 1.602176634e-22],
        'kev' => ['name' => 'Kiloelectronvolts', 'symbol' => 'keV', 'factor' => 1.602176634e-16],
        'mev' => ['name' => 'Megaelectronvolts', 'symbol' => 'MeV', 'factor' => 1.602176634e-13],
        'gev' => ['name' => 'Gigaelectronvolts', 'symbol' => 'GeV', 'factor' => 1.602176634e-10],
        'j' => ['name' => 'Joules', 'symbol' => 'J', 'factor' => 1],
        'zj' => ['name' => 'Zeptojoules', 'symbol' => 'zJ', 'factor' => 1e-21],
    ],

    // Base: second (for short times in circuits and optics).
    'short_time' => [
        's' => ['name' => 'Seconds', 'symbol' => 's', 'factor' => 1],
        'ms' => ['name' => 'Milliseconds', 'symbol' => 'ms', 'factor' => 1e-3],
        'us' => ['name' => 'Microseconds', 'symbol' => 'µs', 'factor' => 1e-6],
        'ns' => ['name' => 'Nanoseconds', 'symbol' => 'ns', 'factor' => 1e-9],
        'ps' => ['name' => 'Picoseconds', 'symbol' => 'ps', 'factor' => 1e-12],
        'min' => ['name' => 'Minutes', 'symbol' => 'min', 'factor' => 60],
        'h' => ['name' => 'Hours', 'symbol' => 'h', 'factor' => 3600],
    ],

];
