<?php

/*
|--------------------------------------------------------------------------
| Substance densities
|--------------------------------------------------------------------------
|
| Typical densities in g/mL (equal to kg/L and t/m³), shared by every
| volume ↔ weight calculator. Liquids are at about 20 °C. Dry ingredients and
| bulk materials are loose bulk densities and vary with packing and moisture,
| so the calculators label results as approximate and accept a custom value.
|
*/

return [

    'liquids' => [
        'label' => 'Liquids',
        'items' => [
            'water' => ['name' => 'Water', 'density' => 0.9982],
            'seawater' => ['name' => 'Seawater', 'density' => 1.025],
            'milk' => ['name' => 'Milk (whole)', 'density' => 1.03],
            'vegetable_oil' => ['name' => 'Vegetable oil', 'density' => 0.92],
            'olive_oil' => ['name' => 'Olive oil', 'density' => 0.91],
            'honey' => ['name' => 'Honey', 'density' => 1.42],
            'maple_syrup' => ['name' => 'Maple syrup', 'density' => 1.33],
            'vinegar' => ['name' => 'Vinegar', 'density' => 1.01],
            'ethanol' => ['name' => 'Ethanol', 'density' => 0.789],
            'gasoline' => ['name' => 'Gasoline', 'density' => 0.74],
            'diesel' => ['name' => 'Diesel', 'density' => 0.85],
            'kerosene' => ['name' => 'Kerosene', 'density' => 0.81],
            'motor_oil' => ['name' => 'Motor oil', 'density' => 0.87],
            'antifreeze' => ['name' => 'Antifreeze (ethylene glycol)', 'density' => 1.113],
            'propane' => ['name' => 'Propane (liquid)', 'density' => 0.493],
            'mercury' => ['name' => 'Mercury', 'density' => 13.534],
        ],
    ],

    'cooking' => [
        'label' => 'Cooking ingredients',
        'items' => [
            'flour' => ['name' => 'All-purpose flour', 'density' => 0.53],
            'sugar' => ['name' => 'Granulated sugar', 'density' => 0.85],
            'brown_sugar' => ['name' => 'Brown sugar (packed)', 'density' => 0.93],
            'powdered_sugar' => ['name' => 'Powdered sugar', 'density' => 0.51],
            'butter' => ['name' => 'Butter', 'density' => 0.959],
            'rice' => ['name' => 'Rice (uncooked)', 'density' => 0.78],
            'oats' => ['name' => 'Rolled oats', 'density' => 0.38],
            'salt' => ['name' => 'Table salt', 'density' => 1.2],
            'cocoa' => ['name' => 'Cocoa powder', 'density' => 0.36],
        ],
    ],

    'construction' => [
        'label' => 'Construction materials',
        'items' => [
            'concrete' => ['name' => 'Concrete', 'density' => 2.4],
            'asphalt' => ['name' => 'Asphalt', 'density' => 2.3],
            'gravel' => ['name' => 'Gravel', 'density' => 1.66],
            'crushed_stone' => ['name' => 'Crushed stone', 'density' => 1.6],
            'sand' => ['name' => 'Sand (dry)', 'density' => 1.6],
            'clay' => ['name' => 'Clay', 'density' => 1.75],
            'topsoil' => ['name' => 'Topsoil', 'density' => 1.2],
            'mulch' => ['name' => 'Wood mulch', 'density' => 0.3],
        ],
    ],

];
