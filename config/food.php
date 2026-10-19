<?php

/*
|--------------------------------------------------------------------------
| Food and cooking calculators
|--------------------------------------------------------------------------
|
| Same shape as config/everyday.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name food.{category}.{tool}
|   view       food.{category}.{tool with underscores}
|
| Generated pages share handlers in resources/js/calc/tools/fd-*.js; ingredient,
| storage and cooking tables live in config/food_data.php with their sources.
|
*/

$categories = [
    [
        'slug' => 'cooking-converters',
        'title' => 'Cooking Converters',
        'description' => 'Cups, grams and spoons, butter, rice, pasta, yeast, oven temperatures and recipe scaling',
        'tools' => [
            ['slug' => 'air-fryer-calculator', 'title' => 'Air Fryer Calculator', 'description' => 'Oven recipe to air fryer temperature and time'],
            ['slug' => 'butter-calculator-how-much-is-a-stick-of-butter', 'title' => 'Butter Calculator - How Much is a Stick of Butter?', 'description' => 'Sticks, cups, spoons and grams'],
            ['slug' => 'cake-pan-converter', 'title' => 'Cake Pan Converter', 'description' => 'Recipe multiplier for a new pan'],
            ['slug' => 'cooking-measurement-converter', 'title' => 'Cooking Measurement Converter', 'description' => 'Cups, spoons, ml and grams by ingredient'],
            ['slug' => 'cups-to-pounds-converter', 'title' => 'Cups to Pounds Converter', 'description' => 'Cups to pounds for 200+ ingredients'],
            ['slug' => 'dry-to-cooked-pasta-converter', 'title' => 'Dry to Cooked Pasta Converter', 'description' => 'Cooked weight, cups and servings'],
            ['slug' => 'fresh-to-dry-herb-conversion-calculator', 'title' => 'Fresh to Dry Herb Conversion Calculator', 'description' => 'Fresh and dried herbs, 3 to 1'],
            ['slug' => 'garlic-clove-to-powder-converter-and-more', 'title' => 'Garlic Clove to Powder Converter & More', 'description' => 'Cloves, minced, powder and salt'],
            ['slug' => 'grams-to-cups-converter', 'title' => 'Grams to Cups Converter', 'description' => 'Grams to cups for 200+ ingredients'],
            ['slug' => 'grams-to-tablespoons-converter', 'title' => 'Grams to Tablespoons Converter', 'description' => 'Grams to tablespoons for 200+ ingredients'],
            ['slug' => 'grams-to-teaspoons-converter', 'title' => 'Grams to Teaspoons Converter', 'description' => 'Grams to teaspoons for 200+ ingredients'],
            ['slug' => 'ml-to-grams-calculator', 'title' => 'ml to Grams Calculator', 'description' => 'ml to grams for 200+ ingredients'],
            ['slug' => 'oil-to-butter-conversion', 'title' => 'Oil to Butter Conversion', 'description' => 'Butter and oil swaps'],
            ['slug' => 'oven-temperature-converter', 'title' => 'Oven Temperature Converter', 'description' => '°F, °C, fan and gas mark'],
            ['slug' => 'pounds-to-cups-converter', 'title' => 'Pounds to Cups Converter', 'description' => 'Pounds to cups for 200+ ingredients'],
            ['slug' => 'recipe-scaler', 'title' => 'Recipe Scaler', 'description' => 'More or fewer servings'],
            ['slug' => 'uncooked-to-cooked-rice-calculator', 'title' => 'Uncooked to Cooked Rice Calculator', 'description' => 'Cooked yield, water and servings'],
            ['slug' => 'yeast-converter', 'title' => 'Yeast Converter', 'description' => 'Fresh, active dry and instant'],
        ],
        'elsewhere' => [
            ['route' => 'chemistry.thermodynamics.boiling-point-at-altitude-calculator', 'title' => 'Boiling Point at Altitude Calculator', 'description' => 'Water boils lower at altitude (Chemistry)'],
            ['route' => 'conversion.utility-and-general-conversion-tools.grams-to-calories-calculator', 'title' => 'Grams to Calories Calculator', 'description' => 'Energy in a portion (Conversion Tools)'],
        ],
    ],
    [
        'slug' => 'desserts-and-baking',
        'title' => 'Desserts and Baking',
        'description' => 'Baker\'s percentages, sourdough, cakes, pancakes, ice cream, chocolate and candy',
        'tools' => [
            ['slug' => 'bakers-percentage-calculator', 'title' => 'Baker\'s Percentage Calculator', 'description' => 'Weights from percentages and back'],
            ['slug' => 'cake-pricing-calculator', 'title' => 'Cake Pricing Calculator', 'description' => 'Price from costs, time and margin'],
            ['slug' => 'cake-serving-calculator', 'title' => 'Cake Serving Calculator', 'description' => 'Party and wedding servings'],
            ['slug' => 'candy-temperature-calculator', 'title' => 'Candy Temperature Calculator', 'description' => 'Sugar stages adjusted for altitude'],
            ['slug' => 'chocolate-calculator', 'title' => 'Chocolate Calculator', 'description' => 'Ganache, tempering and blends'],
            ['slug' => 'donut-calculator', 'title' => 'Donut Calculator', 'description' => 'Dough, flour and frying oil'],
            ['slug' => 'high-altitude-baking-calculator', 'title' => 'High-Altitude Baking Calculator', 'description' => 'Leavening, sugar, liquid and oven'],
            ['slug' => 'pancake-recipe-calculator', 'title' => 'Pancake Recipe Calculator', 'description' => 'Classic pancakes, scaled'],
            ['slug' => 'perfect-ice-cream-calculator', 'title' => 'Perfect Ice Cream Calculator', 'description' => 'Fat, solids, sweetness and softness'],
            ['slug' => 'perfect-pancake-calculator', 'title' => 'Perfect Pancake Calculator', 'description' => 'Pancakes from your batter'],
            ['slug' => 'self-rising-flour-calculator', 'title' => 'Self-rising Flour Calculator', 'description' => 'Flour, baking powder and salt'],
            ['slug' => 'sourdough-calculator', 'title' => 'Sourdough Calculator', 'description' => 'Water, starter, salt and true hydration'],
        ],
    ],
    [
        'slug' => 'pizza',
        'title' => 'Pizza',
        'description' => 'Dough recipes, pizza sizes and value, and how many to order',
        'tools' => [
            ['slug' => 'perfect-pizza-calculator', 'title' => 'Perfect Pizza Calculator', 'description' => 'Dough for any number and size'],
            ['slug' => 'pizza-party-calculator', 'title' => 'Pizza Party Calculator', 'description' => 'How many pizzas to order'],
            ['slug' => 'pizza-size-calculator', 'title' => 'Pizza Size Calculator', 'description' => 'Best value and size comparisons'],
        ],
    ],
    [
        'slug' => 'tea-and-coffee',
        'title' => 'Tea and Coffee',
        'description' => 'Brew ratios, caffeine, cold brew, tea brewing and coffee costs',
        'tools' => [
            ['slug' => 'coffee-calculator', 'title' => 'Coffee Calculator', 'description' => 'Cost a year and caffeine a day'],
            ['slug' => 'coffee-footprint-calculator', 'title' => 'Coffee Footprint Calculator', 'description' => 'CO₂e a year from coffee and milk'],
            ['slug' => 'coffee-kick-calculator', 'title' => 'Coffee Kick Calculator', 'description' => 'Caffeine in your body through the day'],
            ['slug' => 'coffee-ratio-calculator', 'title' => 'Coffee Ratio Calculator', 'description' => 'Coffee and water by brew method'],
            ['slug' => 'coffee-to-water-ratio-calculator', 'title' => 'Coffee to Water Ratio Calculator', 'description' => 'Coffee or water at any ratio'],
            ['slug' => 'cold-brew-ratio-calculator', 'title' => 'Cold Brew Ratio Calculator', 'description' => 'Concentrate or ready to drink'],
            ['slug' => 'healthy-coffee-calculator', 'title' => 'Healthy Coffee Calculator', 'description' => 'Caffeine, calories and added sugar'],
            ['slug' => 'tea-brewing-calculator', 'title' => 'Tea Brewing Calculator', 'description' => 'Leaves, temperature and time'],
        ],
    ],
    [
        'slug' => 'drinks',
        'title' => 'Drinks',
        'description' => 'Alcohol by volume, dilution, priming sugar, sulfites and chilling',
        'tools' => [
            ['slug' => 'abv-calculator-alcohol-by-volume', 'title' => 'ABV Calculator (Alcohol by Volume)', 'description' => 'ABV from gravity or Brix'],
            ['slug' => 'alcohol-dilution-calculator', 'title' => 'Alcohol Dilution Calculator', 'description' => 'Water to reach a target ABV'],
            ['slug' => 'brix-and-specific-gravity-converter', 'title' => 'Brix and Specific Gravity Converter', 'description' => 'Brix, SG and Plato'],
            ['slug' => 'chilled-drink-calculator', 'title' => 'Chilled Drink Calculator', 'description' => 'Time to chill in fridge, freezer or ice'],
            ['slug' => 'priming-sugar-calculator', 'title' => 'Priming Sugar Calculator', 'description' => 'Sugar to carbonate bottles'],
            ['slug' => 'so2-wine-calculator', 'title' => 'SO2 Wine Calculator', 'description' => 'Metabisulfite for a molecular SO₂ target'],
        ],
    ],
    [
        'slug' => 'thanksgiving',
        'title' => 'Thanksgiving',
        'description' => 'Turkey size, thawing and roasting times, holiday quantities and calories',
        'tools' => [
            ['slug' => 'thanksgiving-calculator', 'title' => 'Thanksgiving Calculator', 'description' => 'Shopping amounts for the holiday meal'],
            ['slug' => 'thanksgiving-calories-calculator', 'title' => 'Thanksgiving Calories Calculator', 'description' => 'Calories dish by dish'],
            ['slug' => 'turkey-cooking-time-calculator', 'title' => 'Turkey Cooking Time Calculator', 'description' => 'USDA roasting times and start time'],
            ['slug' => 'turkey-defrost-time-calculator', 'title' => 'Turkey Defrost Time Calculator', 'description' => 'USDA thawing times and start date'],
            ['slug' => 'turkey-size-calculator', 'title' => 'Turkey Size Calculator', 'description' => 'Turkey weight for your guests'],
            ['slug' => 'turkey-thawing-calculator', 'title' => 'Turkey Thawing Calculator', 'description' => 'When to start thawing'],
        ],
    ],
    [
        'slug' => 'party',
        'title' => 'Party',
        'description' => 'Food and drink quantities for parties, barbecues, taco bars and weddings',
        'tools' => [
            ['slug' => 'bbq-grill-size-calculator', 'title' => 'BBQ Grill Size Calculator', 'description' => 'Grill area and batches'],
            ['slug' => 'bbq-party-calculator', 'title' => 'BBQ Party Calculator', 'description' => 'Meat, buns and sides'],
            ['slug' => 'beer-pong-calculator', 'title' => 'Beer Pong Calculator', 'description' => 'Beer and cups for games'],
            ['slug' => 'how-much-ham-per-person-calculator', 'title' => 'How Much Ham per Person Calculator', 'description' => 'Ham weight for your guests'],
            ['slug' => 'party-drink-calculator', 'title' => 'Party Drink Calculator', 'description' => 'Drinks, bottles, ice and cost'],
            ['slug' => 'popcorn-calculator', 'title' => 'Popcorn Calculator', 'description' => 'Kernels, popped volume and calories'],
            ['slug' => 'taco-bar-calculator', 'title' => 'Taco Bar Calculator', 'description' => 'Meat, tortillas and toppings'],
            ['slug' => 'wedding-alcohol-calculator', 'title' => 'Wedding Alcohol Calculator', 'description' => 'Wine, beer, spirits and toast'],
        ],
    ],
    [
        'slug' => 'other',
        'title' => 'Other',
        'description' => 'Food safety temperatures and storage, eggs, steak, brine, curing, rice and nutrition',
        'tools' => [
            ['slug' => 'bacon-curing-calculator', 'title' => 'Bacon Curing Calculator', 'description' => 'Cure #1, salt and sugar within USDA limits'],
            ['slug' => 'bread-spreads-calculator', 'title' => 'Bread Spreads Calculator', 'description' => 'Spread for slices and sandwiches'],
            ['slug' => 'brine-calculator', 'title' => 'Brine Calculator', 'description' => 'Salt and sugar by weight and volume'],
            ['slug' => 'egg-boiling-calculator', 'title' => 'Egg Boiling Calculator', 'description' => 'Soft to hard, by size and altitude'],
            ['slug' => 'food-storage-time-calculator', 'title' => 'Food Storage Time Calculator', 'description' => 'Pantry, fridge and freezer times'],
            ['slug' => 'ham-cooking-time-calculator', 'title' => 'Ham Cooking Time Calculator', 'description' => 'USDA ham times by type and cut'],
            ['slug' => 'how-much-mashed-potatoes-per-person-calculator', 'title' => 'How Much Mashed Potatoes Per Person Calculator', 'description' => 'Potatoes, butter and milk'],
            ['slug' => 'ideal-egg-boiling-calculator', 'title' => 'Ideal Egg Boiling Calculator', 'description' => 'Williams formula for the perfect yolk'],
            ['slug' => 'quarantine-food-calculator-coronavirus', 'title' => 'Quarantine Food Calculator - Coronavirus', 'description' => 'Emergency food and water for your household'],
            ['slug' => 'recipe-cost-calculator', 'title' => 'Recipe Cost Calculator', 'description' => 'Cost per serving in your currency'],
            ['slug' => 'recipe-nutrition-calculator', 'title' => 'Recipe Nutrition Calculator', 'description' => 'Calories and nutrients per serving'],
            ['slug' => 'rice-to-water-ratio-calculator', 'title' => 'Rice to Water Ratio Calculator', 'description' => 'Water, time and yield by rice and method'],
            ['slug' => 'safe-internal-temperature-calculator', 'title' => 'Safe Internal Temperature Calculator', 'description' => 'USDA safe minimum temperatures'],
            ['slug' => 'salad-calories-calculator', 'title' => 'Salad Calories Calculator', 'description' => 'Calories, protein, fat and fibre'],
            ['slug' => 'steak-cook-time-calculator', 'title' => 'Steak Cook Time Calculator', 'description' => 'Minutes a side and target temperature'],
            ['slug' => 'sulfur-calculator', 'title' => 'Sulfur Calculator', 'description' => 'Campden tablets or metabisulfite by ppm'],
            ['slug' => 'water-cooling-calculator', 'title' => 'Water Cooling Calculator', 'description' => 'Cooling time by Newton\'s law'],
        ],
        'elsewhere' => [
            ['route' => 'everyday.home-economics.unit-price-calculator', 'title' => 'Unit Price Calculator', 'description' => 'Compare prices per gram or ounce (Everyday Life)'],
            ['route' => 'everyday.home-economics.grocery-calculator', 'title' => 'Grocery Calculator', 'description' => 'Shopping list totals (Everyday Life)'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "food.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "food.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
        $tool['category_slug'] = $category['slug'];
        $calculators[$tool['key']] = $tool;
    }
    unset($tool);
}
unset($category);

return [
    'categories' => $categories,
    'calculators' => $calculators,
];
