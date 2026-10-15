<?php

/*
|--------------------------------------------------------------------------
| US coin specifications
|--------------------------------------------------------------------------
|
| Face value in dollars, mass in grams and metal composition as mass
| fractions, from US Mint specifications. Used for face and melt values.
|
*/

return [
    'penny' => [
        'face' => 0.01,
        'types' => [
            'zinc' => ['name' => 'Lincoln, 1982 to present (zinc)', 'mass' => 2.5, 'metals' => ['zinc' => 0.975, 'copper' => 0.025]],
            'copper' => ['name' => 'Lincoln, 1962 to 1982 (copper)', 'mass' => 3.11, 'metals' => ['copper' => 0.95, 'zinc' => 0.05]],
            'wheat' => ['name' => 'Wheat, 1909 to 1958', 'mass' => 3.11, 'metals' => ['copper' => 0.95, 'zinc' => 0.05]],
        ],
    ],
    'nickel' => [
        'face' => 0.05,
        'types' => [
            'jefferson' => ['name' => 'Jefferson, 1946 to present', 'mass' => 5.0, 'metals' => ['copper' => 0.75, 'nickel' => 0.25]],
            'wartime' => ['name' => 'Wartime, 1942 to 1945 (35% silver)', 'mass' => 5.0, 'metals' => ['copper' => 0.56, 'silver' => 0.35, 'manganese' => 0.09]],
            'buffalo' => ['name' => 'Buffalo, 1913 to 1938', 'mass' => 5.0, 'metals' => ['copper' => 0.75, 'nickel' => 0.25]],
        ],
    ],
    'dime' => [
        'face' => 0.10,
        'types' => [
            'clad' => ['name' => 'Roosevelt, 1965 to present (clad)', 'mass' => 2.268, 'metals' => ['copper' => 0.9167, 'nickel' => 0.0833]],
            'silver' => ['name' => 'Roosevelt, 1946 to 1964 (90% silver)', 'mass' => 2.5, 'metals' => ['silver' => 0.9, 'copper' => 0.1]],
            'mercury' => ['name' => 'Mercury, 1916 to 1945 (90% silver)', 'mass' => 2.5, 'metals' => ['silver' => 0.9, 'copper' => 0.1]],
        ],
    ],
];
