<?php

/*
|--------------------------------------------------------------------------
| Biology & Nature calculators
|--------------------------------------------------------------------------
|
| Same shape as config/conversion.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name biology.{category}.{tool}
|   view       biology.{category}.{tool with underscores}
|
*/

$categories = [
    [
        'slug' => 'gardening-and-crops',
        'title' => 'Gardening & Crops',
        'description' => 'Soil, mulch, seed, fertilizer, spacing and crop calculators for gardens and fields',
        'tools' => [
            ['slug' => 'mulch-calculator', 'title' => 'Mulch Calculator', 'description' => 'Mulch volume and bags for a bed'],
            ['slug' => 'soil-calculator', 'title' => 'Soil Calculator', 'description' => 'Topsoil volume, bags and tons'],
            ['slug' => 'compost-calculator', 'title' => 'Compost Calculator', 'description' => 'Compost needed for an area'],
            ['slug' => 'raised-bed-soil-calculator', 'title' => 'Raised Bed Soil Calculator', 'description' => 'Soil and mix for raised beds'],
            ['slug' => 'potting-soil-calculator', 'title' => 'Potting Soil Calculator', 'description' => 'Potting mix for containers'],
            ['slug' => 'pine-straw-calculator', 'title' => 'Pine Straw Calculator', 'description' => 'Bales of pine straw'],
            ['slug' => 'sod-calculator', 'title' => 'Sod Calculator', 'description' => 'Sod pieces and pallets'],
            ['slug' => 'grass-seed-calculator', 'title' => 'Grass Seed Calculator', 'description' => 'Seed for a new lawn or overseeding'],
            ['slug' => 'plant-spacing-calculator', 'title' => 'Plant Spacing Calculator', 'description' => 'Plants for an area by spacing'],
            ['slug' => 'plant-population-calculator', 'title' => 'Plant Population Calculator', 'description' => 'Plants per acre from row spacing'],
            ['slug' => 'bulb-spacing-calculator', 'title' => 'Bulb Spacing Calculator', 'description' => 'Bulbs needed for a bed'],
            ['slug' => 'vegetable-seed-calculator', 'title' => 'Vegetable Seed Calculator', 'description' => 'Seeds to sow for a vegetable bed'],
            ['slug' => 'vegetable-yield-calculator', 'title' => 'Vegetable Yield Calculator', 'description' => 'Expected harvest by crop'],
            ['slug' => 'germination-rate-calculator', 'title' => 'Germination Rate Calculator', 'description' => 'Germination percentage and seeds to sow'],
            ['slug' => 'fertilizer-calculator', 'title' => 'Fertilizer Calculator', 'description' => 'Fertilizer from N-P-K and target rate'],
            ['slug' => 'water-soluble-fertilizer-calculator', 'title' => 'Water Soluble Fertilizer Calculator', 'description' => 'Fertilizer for a target ppm'],
            ['slug' => 'lime-calculator', 'title' => 'Lime Calculator', 'description' => 'Lime to raise soil pH'],
            ['slug' => 'lawn-mowing-cost-calculator', 'title' => 'Lawn Mowing Cost Calculator', 'description' => 'Mowing cost per season'],
            ['slug' => 'acres-per-hour-calculator', 'title' => 'Acres Per Hour Calculator', 'description' => 'Field capacity of an implement'],
            ['slug' => 'corn-yield-calculator', 'title' => 'Corn Yield Calculator', 'description' => 'Bushels per acre from ear counts'],
            ['slug' => 'grain-conversion-calculator', 'title' => 'Grain Conversion Calculator', 'description' => 'Bushels to weight by crop'],
            ['slug' => 'gdu-calculator', 'title' => 'GDU Calculator', 'description' => 'Growing degree units'],
            ['slug' => 'daily-light-integral-calculator', 'title' => 'Daily Light Integral Calculator', 'description' => 'DLI from PPFD and day length'],
            ['slug' => 'vpd-calculator', 'title' => 'VPD Calculator', 'description' => 'Vapor pressure deficit for growing'],
            ['slug' => 'co2-grow-room-calculator', 'title' => 'CO₂ Grow Room Calculator', 'description' => 'CO₂ to enrich a grow room'],
            ['slug' => 'water-potential-calculator', 'title' => 'Water Potential Calculator', 'description' => 'Solute and pressure potential'],
            ['slug' => 'rainwater-harvesting-calculator', 'title' => 'Rainwater Harvesting Calculator', 'description' => 'Water collected from a roof'],
        ],
    ],
    [
        'slug' => 'trees-and-forestry',
        'title' => 'Trees & Forestry',
        'description' => 'Tree size, age, value, timber and carbon calculators',
        'tools' => [
            ['slug' => 'tree-height-calculator', 'title' => 'Tree Height Calculator', 'description' => 'Height by angle, stick or shadow'],
            ['slug' => 'tree-diameter-calculator', 'title' => 'Tree Diameter Calculator', 'description' => 'Diameter from circumference'],
            ['slug' => 'basal-area-calculator', 'title' => 'Basal Area Calculator', 'description' => 'Basal area per tree and per acre'],
            ['slug' => 'tree-age-calculator', 'title' => 'Tree Age Calculator', 'description' => 'Age from trunk size and species'],
            ['slug' => 'tree-spacing-calculator', 'title' => 'Tree Spacing Calculator', 'description' => 'Trees per acre by spacing'],
            ['slug' => 'tree-value-calculator', 'title' => 'Tree Value Calculator', 'description' => 'Appraised value by the trunk formula'],
            ['slug' => 'firewood-cord-calculator', 'title' => 'Firewood Cord Calculator', 'description' => 'Cords in a woodpile'],
            ['slug' => 'tree-carbon-calculator', 'title' => 'Tree Carbon Sequestration Calculator', 'description' => 'CO₂ stored in a tree'],
            ['slug' => 'tree-leaves-calculator', 'title' => 'Tree Leaves Calculator', 'description' => 'Estimated leaves on a tree'],
        ],
    ],
    [
        'slug' => 'water-and-wastewater',
        'title' => 'Water & Wastewater',
        'description' => 'Activated sludge and treatment plant calculations',
        'tools' => [
            ['slug' => 'mlvss-calculator', 'title' => 'MLVSS Calculator', 'description' => 'Mixed liquor volatile suspended solids'],
            ['slug' => 'wastewater-calculator', 'title' => 'Wastewater Calculator', 'description' => 'F/M ratio, sludge age, SVI and more'],
        ],
    ],
    [
        'slug' => 'laboratory',
        'title' => 'Laboratory',
        'description' => 'Solutions, dilutions, cell counts, absorbance, buffers, PCR and molecular weights',
        'tools' => [
            ['slug' => 'cell-dilution-calculator', 'title' => 'Cell Dilution Calculator', 'description' => 'Cell suspension and medium for seeding'],
            ['slug' => 'centrifuge-rpm-to-rcf-calculator', 'title' => 'Centrifuge RPM to RCF Calculator', 'description' => 'RPM to × g and back'],
            ['slug' => 'hemocytometer-calculator', 'title' => 'Hemocytometer Cell Count Calculator', 'description' => 'Cells per mL and viability'],
            ['slug' => 'od600-calculator', 'title' => 'OD600 to Cell Concentration Calculator', 'description' => 'Cells per mL from OD600'],
            ['slug' => 'oligo-resuspension-calculator', 'title' => 'Oligo Resuspension Calculator', 'description' => 'Buffer to dissolve a primer'],
            ['slug' => 'dna-concentration-calculator', 'title' => 'DNA Concentration Calculator', 'description' => 'µg/mL and purity from A260'],
            ['slug' => 'ligation-calculator', 'title' => 'Ligation Calculator', 'description' => 'Insert ng for a molar ratio'],
            ['slug' => 'protein-concentration-calculator', 'title' => 'Protein Concentration Calculator', 'description' => 'mg/mL from A280'],
            ['slug' => 'generation-time-calculator', 'title' => 'Generation Time Calculator', 'description' => 'Bacterial generation time'],
            ['slug' => 'cell-doubling-time-calculator', 'title' => 'Cell Doubling Time Calculator', 'description' => 'Population doubling time'],
            ['slug' => 'log-reduction-calculator', 'title' => 'Log Reduction Calculator', 'description' => 'Log reduction and percent kill'],
            ['slug' => 'annealing-temperature-calculator', 'title' => 'Annealing Temperature Calculator', 'description' => 'Primer Tm and PCR annealing temperature'],
            ['slug' => 'protein-molecular-weight-calculator', 'title' => 'Protein Molecular Weight Calculator', 'description' => 'kDa and ε280 from a sequence'],
            ['slug' => 'dna-rna-molecular-weight-calculator', 'title' => 'DNA and RNA Molecular Weight Calculator', 'description' => 'g/mol of DNA or RNA'],
        ],
    ],
    [
        'slug' => 'genetics',
        'title' => 'Genetics',
        'description' => 'Punnett squares, Hardy–Weinberg, chi-square, blood types and sequence tools',
        'tools' => [
            ['slug' => 'punnett-square-calculator', 'title' => 'Punnett Square Calculator', 'description' => 'Monohybrid cross and ratios'],
            ['slug' => 'dihybrid-cross-calculator', 'title' => 'Dihybrid Cross Calculator', 'description' => 'Two-gene Punnett square'],
            ['slug' => 'trihybrid-cross-calculator', 'title' => 'Trihybrid Cross Calculator', 'description' => 'Three-gene Punnett square'],
            ['slug' => 'allele-frequency-calculator', 'title' => 'Allele Frequency Calculator', 'description' => 'p and q from genotype counts'],
            ['slug' => 'hardy-weinberg-calculator', 'title' => 'Hardy–Weinberg Equilibrium Calculator', 'description' => 'p², 2pq, q² and carriers'],
            ['slug' => 'chi-square-genetics-calculator', 'title' => 'Chi-Square Test for Genetics', 'description' => 'Observed counts vs expected ratio'],
            ['slug' => 'recombination-frequency-calculator', 'title' => 'Recombination Frequency Calculator', 'description' => 'Recombinants and map distance'],
            ['slug' => 'blood-type-calculator', 'title' => 'Blood Type Calculator', 'description' => 'Possible blood types of a child'],
            ['slug' => 'mutation-frequency-calculator', 'title' => 'Mutation Frequency Calculator', 'description' => 'Mutants per viable cell'],
            ['slug' => 'mutation-rate-calculator', 'title' => 'Mutation Rate Calculator', 'description' => 'Fluctuation test p0 method'],
            ['slug' => 'qpcr-efficiency-calculator', 'title' => 'qPCR Efficiency Calculator', 'description' => 'Efficiency from standard-curve slope'],
            ['slug' => 'dna-copy-number-calculator', 'title' => 'DNA Copy Number Calculator', 'description' => 'Copies from mass and length'],
            ['slug' => 'dna-to-mrna-converter', 'title' => 'DNA to mRNA Converter', 'description' => 'Transcribe DNA to mRNA'],
            ['slug' => 'dna-to-protein-translation-calculator', 'title' => 'DNA to Protein Translation Calculator', 'description' => 'Translate in six frames'],
            ['slug' => 'reverse-complement-calculator', 'title' => 'Reverse Complement Calculator', 'description' => 'Reverse complement of a sequence'],
            ['slug' => 'gc-content-calculator', 'title' => 'GC Content Calculator', 'description' => 'GC% and base counts'],
        ],
    ],
    [
        'slug' => 'animal-pregnancy',
        'title' => 'Animal Pregnancy',
        'description' => 'Due dates and pregnancy timelines for pets and farm animals',
        'tools' => [
            ['slug' => 'dog-pregnancy-calculator', 'title' => 'Dog Pregnancy Calculator', 'description' => 'Whelping date and timeline'],
            ['slug' => 'cat-pregnancy-calculator', 'title' => 'Cat Pregnancy Calculator', 'description' => 'Kittening date and timeline'],
            ['slug' => 'cow-gestation-calculator', 'title' => 'Cow Gestation Calculator', 'description' => 'Calving date and timeline'],
            ['slug' => 'goat-gestation-calculator', 'title' => 'Goat Gestation Calculator', 'description' => 'Kidding date and timeline'],
            ['slug' => 'sheep-gestation-calculator', 'title' => 'Sheep Gestation Calculator', 'description' => 'Lambing date and timeline'],
            ['slug' => 'swine-gestation-calculator', 'title' => 'Swine Gestation Calculator', 'description' => 'Farrowing date and timeline'],
            ['slug' => 'mare-gestation-calculator', 'title' => 'Mare Gestation Calculator', 'description' => 'Foaling date and timeline'],
            ['slug' => 'llama-alpaca-gestation-calculator', 'title' => 'Llama and Alpaca Gestation Calculator', 'description' => 'Cria due date and timeline'],
            ['slug' => 'rabbit-gestation-calculator', 'title' => 'Rabbit Gestation Calculator', 'description' => 'Kindling date and nest box day'],
            ['slug' => 'guinea-pig-pregnancy-calculator', 'title' => 'Guinea Pig Pregnancy Calculator', 'description' => 'Due date and timeline'],
            ['slug' => 'animal-gestation-calculator', 'title' => 'Animal Gestation Calculator', 'description' => 'Due dates for 13 species'],
        ],
    ],
    [
        'slug' => 'other-animals',
        'title' => 'Pets & Other Animals',
        'description' => 'Small pets, birds, aquariums, poultry and horses',
        'tools' => [
            ['slug' => 'bird-age-calculator', 'title' => 'Bird Age Calculator', 'description' => 'Bird age in human years by species'],
            ['slug' => 'hamster-age-calculator', 'title' => 'Hamster Age Calculator', 'description' => 'Hamster age in human years'],
            ['slug' => 'guinea-pig-age-calculator', 'title' => 'Guinea Pig Years to Human Years Calculator', 'description' => 'Guinea pig years to human years'],
            ['slug' => 'cricket-chirp-thermometer', 'title' => 'Crickets Chirping Thermometer', 'description' => 'Temperature from cricket chirps'],
            ['slug' => 'dry-matter-calculator', 'title' => 'Dry Matter Calculator', 'description' => 'Compare pet foods on a dry-matter basis'],
            ['slug' => 'horse-weight-calculator', 'title' => 'Horse Weight Calculator', 'description' => 'Weight from girth and length'],
            ['slug' => 'rabbit-cage-size-calculator', 'title' => 'Rabbit Cage Size Calculator', 'description' => 'Check an enclosure against RWAF'],
            ['slug' => 'rat-cage-calculator', 'title' => 'Rat Cage Calculator', 'description' => 'Rats that fit a cage'],
            ['slug' => 'turtle-tank-size-calculator', 'title' => 'Turtle Tank Size Calculator', 'description' => 'Tank gallons for turtles'],
            ['slug' => 'aquarium-volume-calculator', 'title' => 'Aquarium Volume Calculator', 'description' => 'Gallons and liters by tank shape'],
            ['slug' => 'chicken-coop-size-calculator', 'title' => 'Chicken Coop Size Calculator', 'description' => 'Coop, run, nests and roosts'],
            ['slug' => 'pet-sitter-rates-calculator', 'title' => 'Pet Sitter Rates Calculator', 'description' => 'Cost per visit, day and week'],
        ],
    ],
    [
        'slug' => 'livestock',
        'title' => 'Livestock',
        'description' => 'Weights, gains, feed, grazing, storage and fencing',
        'tools' => [
            ['slug' => 'cattle-weight-calculator', 'title' => 'Cattle Weight Calculator', 'description' => 'Weight from a tape measure'],
            ['slug' => 'average-daily-gain-calculator', 'title' => 'Average Daily Gain Calculator', 'description' => 'ADG and days to target'],
            ['slug' => 'feed-conversion-ratio-calculator', 'title' => 'Feed Conversion Ratio Calculator', 'description' => 'FCR and cost of gain'],
            ['slug' => 'animal-mortality-rate-calculator', 'title' => 'Animal Mortality Rate Calculator', 'description' => 'Mortality, survival and yearly rate'],
            ['slug' => 'cattle-per-acre-calculator', 'title' => 'Cattle per Acre Calculator', 'description' => 'Stocking rate from forage'],
            ['slug' => 'animal-unit-month-calculator', 'title' => 'Animal Unit Month Calculator', 'description' => 'AUMs and forage needed'],
            ['slug' => 'hay-requirement-calculator', 'title' => 'Hay Requirement Calculator', 'description' => 'Bales and tons for winter'],
            ['slug' => 'grain-bin-calculator', 'title' => 'Grain Bin Calculator', 'description' => 'Bushels and tons in a bin'],
            ['slug' => 'livestock-fence-cost-calculator', 'title' => 'Livestock Fence Cost Calculator', 'description' => 'Wire, posts, gates and labour'],
        ],
    ],
    [
        'slug' => 'dogs',
        'title' => 'Dogs',
        'description' => 'Age, weight, food, water, crates, heat cycles and everyday dog care',
        'tools' => [
            ['slug' => 'dog-age-calculator', 'title' => 'Dog Age Calculator', 'description' => 'Dog years to human years by size'],
            ['slug' => 'dog-ideal-weight-calculator', 'title' => 'Dog Ideal Weight Calculator (Dog BMI)', 'description' => 'Ideal weight from body condition score'],
            ['slug' => 'dog-nutrition-calculator', 'title' => 'Dog Nutrition Calculator', 'description' => 'Daily calories for your dog'],
            ['slug' => 'dog-food-calculator', 'title' => 'Dog Food Calculator', 'description' => 'Grams and cups per day'],
            ['slug' => 'raw-dog-food-calculator', 'title' => 'Raw Dog Food Calculator', 'description' => 'Raw food amount and split'],
            ['slug' => 'dog-water-intake-calculator', 'title' => 'Dog Water Intake Calculator', 'description' => 'Daily water need'],
            ['slug' => 'dog-crate-size-calculator', 'title' => 'Dog Crate Size Calculator', 'description' => 'Crate size from length and height'],
            ['slug' => 'dog-harness-size-calculator', 'title' => 'Dog Harness Size Calculator', 'description' => 'Harness size from chest girth'],
            ['slug' => 'dog-heat-cycle-calculator', 'title' => 'Dog Heat Cycle Calculator', 'description' => 'Next heat and fertile days'],
            ['slug' => 'dog-life-expectancy-calculator', 'title' => 'Dog Life Expectancy Calculator', 'description' => 'Lifespan by breed or size'],
            ['slug' => 'dog-size-calculator', 'title' => 'Dog Size Calculator', 'description' => 'Puppy adult weight estimate'],
            ['slug' => 'dog-quality-of-life-calculator', 'title' => 'Dog Quality of Life Calculator', 'description' => 'HHHHHMM quality-of-life score'],
            ['slug' => 'cost-of-owning-a-dog-calculator', 'title' => 'Cost of Owning a Dog Calculator', 'description' => 'Monthly, yearly and lifetime cost'],
        ],
    ],
    [
        'slug' => 'cats',
        'title' => 'Cats',
        'description' => 'Age, body fat, calories, food, water and everyday cat care',
        'tools' => [
            ['slug' => 'cat-age-calculator', 'title' => 'Cat Age Calculator', 'description' => 'Cat years to human years'],
            ['slug' => 'cat-bmi-calculator', 'title' => 'Cat BMI Calculator', 'description' => 'Body fat from two measurements'],
            ['slug' => 'cat-calorie-calculator', 'title' => 'Cat Calorie Calculator', 'description' => 'Daily calories for your cat'],
            ['slug' => 'how-big-will-my-cat-get-calculator', 'title' => 'How Big Will My Cat Get Calculator', 'description' => 'Kitten adult weight estimate'],
            ['slug' => 'cat-quality-of-life-calculator', 'title' => 'Cat Quality of Life Calculator', 'description' => 'HHHHHMM quality-of-life score'],
            ['slug' => 'cat-water-intake-calculator', 'title' => 'Cat Water Intake Calculator', 'description' => 'Water from food and drinking'],
            ['slug' => 'cat-food-calculator', 'title' => 'Cat Food Calculator', 'description' => 'Cans and cups per day'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "biology.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "biology.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
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
