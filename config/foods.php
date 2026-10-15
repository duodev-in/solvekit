<?php

/*
|--------------------------------------------------------------------------
| Food energy and macronutrients
|--------------------------------------------------------------------------
|
| Per 100 g, from USDA FoodData Central (SR Legacy). Energy in kcal; carbs,
| protein and fat in grams.
|
*/

return [
    'grains' => ['label' => 'Grains and starches', 'items' => [
        'rice' => ['name' => 'White rice, cooked', 'kcal' => 130, 'carbs' => 28.2, 'protein' => 2.7, 'fat' => 0.3],
        'pasta' => ['name' => 'Pasta, cooked', 'kcal' => 158, 'carbs' => 30.9, 'protein' => 5.8, 'fat' => 0.9],
        'bread' => ['name' => 'White bread', 'kcal' => 266, 'carbs' => 49.4, 'protein' => 7.6, 'fat' => 3.3],
        'oats' => ['name' => 'Rolled oats, dry', 'kcal' => 389, 'carbs' => 66.3, 'protein' => 16.9, 'fat' => 6.9],
        'potato' => ['name' => 'Potato, boiled', 'kcal' => 87, 'carbs' => 20.1, 'protein' => 1.9, 'fat' => 0.1],
    ]],
    'protein' => ['label' => 'Meat, fish and eggs', 'items' => [
        'chicken' => ['name' => 'Chicken breast, roasted', 'kcal' => 165, 'carbs' => 0, 'protein' => 31, 'fat' => 3.6],
        'salmon' => ['name' => 'Salmon, cooked', 'kcal' => 206, 'carbs' => 0, 'protein' => 22.1, 'fat' => 12.4],
        'egg' => ['name' => 'Egg, whole', 'kcal' => 143, 'carbs' => 0.7, 'protein' => 12.6, 'fat' => 9.5],
    ]],
    'dairy' => ['label' => 'Dairy', 'items' => [
        'milk' => ['name' => 'Whole milk', 'kcal' => 61, 'carbs' => 4.8, 'protein' => 3.2, 'fat' => 3.3],
        'yogurt' => ['name' => 'Plain yogurt, whole milk', 'kcal' => 61, 'carbs' => 4.7, 'protein' => 3.5, 'fat' => 3.3],
        'greek_yogurt' => ['name' => 'Greek yogurt, nonfat', 'kcal' => 59, 'carbs' => 3.6, 'protein' => 10.2, 'fat' => 0.4],
        'cheddar' => ['name' => 'Cheddar cheese', 'kcal' => 403, 'carbs' => 1.3, 'protein' => 24.9, 'fat' => 33.1],
        'butter' => ['name' => 'Butter', 'kcal' => 717, 'carbs' => 0.1, 'protein' => 0.9, 'fat' => 81.1],
    ]],
    'produce' => ['label' => 'Fruit and vegetables', 'items' => [
        'apple' => ['name' => 'Apple', 'kcal' => 52, 'carbs' => 13.8, 'protein' => 0.3, 'fat' => 0.2],
        'banana' => ['name' => 'Banana', 'kcal' => 89, 'carbs' => 22.8, 'protein' => 1.1, 'fat' => 0.3],
        'avocado' => ['name' => 'Avocado', 'kcal' => 160, 'carbs' => 8.5, 'protein' => 2, 'fat' => 14.7],
        'broccoli' => ['name' => 'Broccoli, raw', 'kcal' => 34, 'carbs' => 6.6, 'protein' => 2.8, 'fat' => 0.4],
    ]],
    'other' => ['label' => 'Fats, nuts and sweets', 'items' => [
        'olive_oil' => ['name' => 'Olive oil', 'kcal' => 884, 'carbs' => 0, 'protein' => 0, 'fat' => 100],
        'almonds' => ['name' => 'Almonds', 'kcal' => 579, 'carbs' => 21.6, 'protein' => 21.2, 'fat' => 49.9],
        'peanut_butter' => ['name' => 'Peanut butter', 'kcal' => 588, 'carbs' => 20, 'protein' => 25, 'fat' => 50],
        'sugar' => ['name' => 'Sugar', 'kcal' => 387, 'carbs' => 100, 'protein' => 0, 'fat' => 0],
        'dark_chocolate' => ['name' => 'Dark chocolate, 70 to 85%', 'kcal' => 598, 'carbs' => 45.9, 'protein' => 7.8, 'fat' => 42.6],
    ]],
];
