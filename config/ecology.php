<?php

/*
|--------------------------------------------------------------------------
| Ecology calculators
|--------------------------------------------------------------------------
|
| Same shape as config/construction.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name ecology.{category}.{tool}
|   view       ecology.{category}.{tool with underscores}
|
*/

$categories = [
    [
        'slug' => 'eco-footprint',
        'title' => 'Eco Footprint',
        'description' => 'Carbon, water and plastic footprints of food, travel, products and energy',
        'tools' => [
            ['slug' => 'ai-water-footprint-calculator', 'title' => 'AI Water Footprint Calculator', 'description' => 'Water and energy behind AI prompts'],
            ['slug' => 'bag-footprint-calculator', 'title' => 'Bag Footprint Calculator', 'description' => 'Reuses to beat a plastic carrier bag'],
            ['slug' => 'christmas-tree-footprint-calculator', 'title' => 'Christmas Tree Footprint Calculator', 'description' => 'Real or artificial tree'],
            ['slug' => 'covid-19-waste-calculator', 'title' => 'COVID-19 Waste Calculator', 'description' => 'Masks, gloves and wipes thrown away'],
            ['slug' => 'cryptocurrency-footprint-calculator', 'title' => 'Cryptocurrency Footprint Calculator', 'description' => 'Bitcoin network energy and CO₂'],
            ['slug' => 'flight-carbon-footprint-calculator', 'title' => 'Flight Carbon Footprint Calculator', 'description' => 'CO₂e of a flight by airports and class'],
            ['slug' => 'hand-drying-footprint-calculator', 'title' => 'Hand Drying Footprint Calculator', 'description' => 'Hand dryers vs paper towels'],
            ['slug' => 'kaya-identity-calculator', 'title' => 'Kaya Identity Calculator', 'description' => 'CO₂ from population, GDP, energy and carbon'],
            ['slug' => 'meat-footprint-calculator', 'title' => 'Meat Footprint Calculator', 'description' => 'Carbon, land and water of the food you eat'],
            ['slug' => 'plastic-footprint-calculator', 'title' => 'Plastic Footprint Calculator', 'description' => 'Your plastic use per year'],
            ['slug' => 'reduce-your-plastic-calculator', 'title' => 'Reduce Your Plastic Calculator', 'description' => 'Plastic saved by simple swaps'],
            ['slug' => 'vegan-footprint-calculator', 'title' => 'Vegan Footprint Calculator', 'description' => 'Savings from a vegan diet'],
            ['slug' => 'home-energy-carbon-footprint-calculator', 'title' => 'Home Energy Carbon Footprint Calculator', 'description' => 'Electricity, gas, oil and propane'],
            ['slug' => 'car-carbon-footprint-calculator', 'title' => 'Car Carbon Footprint Calculator', 'description' => 'CO₂ from driving'],
        ],
    ],
    [
        'slug' => 'renewable-energy',
        'title' => 'Renewable Energy',
        'description' => 'Solar, wind and hydro power, payback and storage',
        'tools' => [
            ['slug' => 'hydroelectric-power-calculator', 'title' => 'Hydroelectric Power Calculator', 'description' => 'Power from flow and head'],
            ['slug' => 'solar-panel-calculator', 'title' => 'Solar Panel Calculator', 'description' => 'System size for your electricity use'],
            ['slug' => 'solar-panel-wattage-calculator', 'title' => 'Solar Panel Wattage Calculator', 'description' => 'Panel watts from size and efficiency'],
            ['slug' => 'wind-turbine-calculator', 'title' => 'Wind Turbine Calculator', 'description' => 'Wind power and yearly energy'],
            ['slug' => 'wind-turbine-profit-calculator', 'title' => 'Wind Turbine Profit Calculator', 'description' => 'Payback, NPV and cost of energy'],
            ['slug' => 'solar-payback-calculator', 'title' => 'Solar Payback Calculator', 'description' => 'Payback and savings of solar'],
            ['slug' => 'home-battery-calculator', 'title' => 'Home Battery Calculator', 'description' => 'Battery size for backup or self-use'],
        ],
    ],
    [
        'slug' => 'sustainable-living',
        'title' => 'Sustainable Living',
        'description' => 'Everyday choices: transport, water, books and plastics',
        'tools' => [
            ['slug' => 'books-vs-e-books-calculator', 'title' => 'Books vs e-Books Calculator', 'description' => 'Paper books against an e-reader'],
            ['slug' => 'car-vs-bike-calculator', 'title' => 'Car vs. Bike Calculator', 'description' => 'CO₂, money and calories'],
            ['slug' => 'cigarette-butts-cleanup-calculator', 'title' => 'Cigarette Butts Cleanup Calculator', 'description' => 'Plastic and toxins removed'],
            ['slug' => 'drip-faucet-calculator', 'title' => 'Drip Faucet Calculator', 'description' => 'Water lost to a leaking tap'],
            ['slug' => 'global-plastic-policy-calculator', 'title' => 'Global Plastic Policy Calculator', 'description' => 'OECD scenarios to 2060'],
            ['slug' => 'olympic-games-sustainability-calculator', 'title' => 'Olympic Games Sustainability Calculator', 'description' => 'Games footprints and your trip'],
            ['slug' => 'plug-in-hybrid-economy-calculator', 'title' => 'Plug-in Hybrid Economy Calculator', 'description' => 'Electric share, cost and CO₂'],
            ['slug' => 'tap-water-calculator', 'title' => 'Tap Water Calculator', 'description' => 'Tap vs bottled water'],
            ['slug' => 'water-demand-calculator', 'title' => 'Water Demand Calculator', 'description' => 'Community water demand'],
            ['slug' => 'shower-water-and-energy-calculator', 'title' => 'Shower Water and Energy Calculator', 'description' => 'Water, energy and cost per shower'],
            ['slug' => 'ev-vs-gas-car-calculator', 'title' => 'EV vs Gas Car Calculator', 'description' => 'CO₂ and running cost'],
        ],
    ],
    [
        'slug' => 'other',
        'title' => 'Other',
        'description' => 'Ecology models, diversity, air quality and health',
        'tools' => [
            ['slug' => 'carrying-capacity-calculator', 'title' => 'Carrying Capacity Calculator', 'description' => 'K from resources or population counts'],
            ['slug' => 'co2-breathing-emission-calculator', 'title' => 'CO₂ Breathing Emission Calculator', 'description' => 'CO₂ you breathe out'],
            ['slug' => 'fish-mercury-calculator', 'title' => 'Fish Mercury Calculator', 'description' => 'Mercury intake from fish'],
            ['slug' => 'lotka-volterra-calculator', 'title' => 'Lotka-Volterra Calculator', 'description' => 'Predator–prey cycles'],
            ['slug' => 'passive-house-savings-calculator', 'title' => 'Passive House Savings Calculator', 'description' => 'Heating saved by the Passive House standard'],
            ['slug' => 'shannon-diversity-index-calculator', 'title' => 'Shannon Diversity Index Calculator', 'description' => 'H′, evenness and richness'],
            ['slug' => 'smog-calculator', 'title' => 'Smog Calculator', 'description' => 'Air Quality Index from pollutants'],
            ['slug' => 'simpson-diversity-index-calculator', 'title' => 'Simpson\'s Diversity Index Calculator', 'description' => 'D, 1 − D and 1/D'],
            ['slug' => 'population-growth-calculator', 'title' => 'Population Growth Calculator', 'description' => 'Exponential and logistic growth'],
            ['slug' => 'mark-recapture-calculator', 'title' => 'Mark–Recapture Calculator', 'description' => 'Lincoln–Petersen and Chapman estimates'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "ecology.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "ecology.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
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
