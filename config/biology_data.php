<?php

/*
|--------------------------------------------------------------------------
| Reference data for Biology & Nature calculators
|--------------------------------------------------------------------------
|
| Typical values from US university extension guides and forestry
| references. Garden and tree figures vary with variety, soil and climate,
| so the calculators label results based on them as estimates.
|
*/

return [

    // Seeding rate in lb per 1,000 ft²: new lawn and overseeding (extension turfgrass guides).
    'grass_seed' => [
        'kentucky_bluegrass' => ['name' => 'Kentucky bluegrass', 'new' => 2.5, 'overseed' => 1.5],
        'tall_fescue' => ['name' => 'Tall fescue', 'new' => 8, 'overseed' => 4],
        'perennial_ryegrass' => ['name' => 'Perennial ryegrass', 'new' => 8, 'overseed' => 4],
        'fine_fescue' => ['name' => 'Fine fescue', 'new' => 4.5, 'overseed' => 2.5],
        'bermuda' => ['name' => 'Bermudagrass (hulled)', 'new' => 1.5, 'overseed' => 1],
        'zoysia' => ['name' => 'Zoysiagrass', 'new' => 1.5, 'overseed' => 1],
        'centipede' => ['name' => 'Centipedegrass', 'new' => 0.5, 'overseed' => 0.25],
    ],

    // Spacing between bulbs and planting depth, in inches.
    'bulbs' => [
        'tulip' => ['name' => 'Tulip', 'spacing' => 5, 'depth' => 8],
        'daffodil' => ['name' => 'Daffodil', 'spacing' => 6, 'depth' => 6],
        'crocus' => ['name' => 'Crocus', 'spacing' => 3, 'depth' => 4],
        'hyacinth' => ['name' => 'Hyacinth', 'spacing' => 6, 'depth' => 6],
        'allium' => ['name' => 'Allium (large)', 'spacing' => 8, 'depth' => 8],
        'iris' => ['name' => 'Iris (bulbous)', 'spacing' => 4, 'depth' => 4],
        'lily' => ['name' => 'Lily', 'spacing' => 10, 'depth' => 7],
        'gladiolus' => ['name' => 'Gladiolus', 'spacing' => 6, 'depth' => 5],
    ],

    // In-row and between-row spacing (inches), seeds per spot, and yield in lb per 10 ft of row.
    'vegetables' => [
        'bean_bush' => ['name' => 'Beans (bush)', 'spacing' => 3, 'row' => 18, 'seeds' => 1, 'yield' => 6],
        'beet' => ['name' => 'Beets', 'spacing' => 3, 'row' => 12, 'seeds' => 2, 'yield' => 10],
        'broccoli' => ['name' => 'Broccoli', 'spacing' => 18, 'row' => 30, 'seeds' => 3, 'yield' => 7],
        'cabbage' => ['name' => 'Cabbage', 'spacing' => 18, 'row' => 30, 'seeds' => 3, 'yield' => 15],
        'carrot' => ['name' => 'Carrots', 'spacing' => 2, 'row' => 12, 'seeds' => 3, 'yield' => 10],
        'corn' => ['name' => 'Sweet corn', 'spacing' => 10, 'row' => 30, 'seeds' => 2, 'yield' => 10],
        'cucumber' => ['name' => 'Cucumbers', 'spacing' => 12, 'row' => 48, 'seeds' => 3, 'yield' => 12],
        'lettuce' => ['name' => 'Lettuce (leaf)', 'spacing' => 8, 'row' => 12, 'seeds' => 3, 'yield' => 5],
        'onion' => ['name' => 'Onions', 'spacing' => 4, 'row' => 12, 'seeds' => 1, 'yield' => 10],
        'pea' => ['name' => 'Peas', 'spacing' => 2, 'row' => 24, 'seeds' => 1, 'yield' => 2],
        'pepper' => ['name' => 'Peppers', 'spacing' => 18, 'row' => 24, 'seeds' => 1, 'yield' => 6],
        'potato' => ['name' => 'Potatoes', 'spacing' => 12, 'row' => 30, 'seeds' => 1, 'yield' => 10],
        'spinach' => ['name' => 'Spinach', 'spacing' => 4, 'row' => 12, 'seeds' => 2, 'yield' => 4],
        'squash' => ['name' => 'Summer squash', 'spacing' => 24, 'row' => 48, 'seeds' => 3, 'yield' => 20],
        'tomato' => ['name' => 'Tomatoes', 'spacing' => 24, 'row' => 48, 'seeds' => 1, 'yield' => 15],
    ],

    // Standard test weights in lb per bushel (USDA).
    'grain_test_weights' => [
        'corn' => ['name' => 'Corn (shelled)', 'lb' => 56],
        'soybeans' => ['name' => 'Soybeans', 'lb' => 60],
        'wheat' => ['name' => 'Wheat', 'lb' => 60],
        'barley' => ['name' => 'Barley', 'lb' => 48],
        'oats' => ['name' => 'Oats', 'lb' => 32],
        'sorghum' => ['name' => 'Sorghum', 'lb' => 56],
        'rye' => ['name' => 'Rye', 'lb' => 56],
        'canola' => ['name' => 'Canola', 'lb' => 50],
        'rice' => ['name' => 'Rice (rough)', 'lb' => 45],
    ],

    // Tree age growth factors: years per inch of trunk diameter (ISA / arboretum tables).
    'tree_growth_factors' => [
        'silver_maple' => ['name' => 'Silver maple', 'factor' => 3.0],
        'red_maple' => ['name' => 'Red maple', 'factor' => 4.5],
        'sugar_maple' => ['name' => 'Sugar maple', 'factor' => 5.5],
        'norway_maple' => ['name' => 'Norway maple', 'factor' => 4.5],
        'red_oak' => ['name' => 'Red oak', 'factor' => 4.0],
        'white_oak' => ['name' => 'White oak', 'factor' => 5.0],
        'pin_oak' => ['name' => 'Pin oak', 'factor' => 3.0],
        'american_elm' => ['name' => 'American elm', 'factor' => 4.0],
        'white_birch' => ['name' => 'White birch', 'factor' => 5.0],
        'american_beech' => ['name' => 'American beech', 'factor' => 6.0],
        'white_ash' => ['name' => 'White ash', 'factor' => 5.0],
        'black_walnut' => ['name' => 'Black walnut', 'factor' => 4.5],
        'black_cherry' => ['name' => 'Black cherry', 'factor' => 5.0],
        'shagbark_hickory' => ['name' => 'Shagbark hickory', 'factor' => 7.5],
        'basswood' => ['name' => 'Basswood', 'factor' => 3.0],
        'cottonwood' => ['name' => 'Cottonwood', 'factor' => 2.0],
        'aspen' => ['name' => 'Aspen', 'factor' => 2.0],
        'dogwood' => ['name' => 'Dogwood', 'factor' => 7.0],
        'redbud' => ['name' => 'Redbud', 'factor' => 7.0],
        'white_pine' => ['name' => 'White pine', 'factor' => 5.0],
        'scotch_pine' => ['name' => 'Scotch pine', 'factor' => 3.5],
    ],

    // Lime (ground limestone) in lb per 1,000 ft² to raise pH by one unit, by soil texture.
    'lime_per_ph_unit' => [
        'sandy' => ['name' => 'Sandy', 'lb' => 30],
        'loam' => ['name' => 'Loam', 'lb' => 50],
        'clay' => ['name' => 'Clay', 'lb' => 70],
    ],

    // Common biological buffers: pKa at 25 °C (phosphate is pKa2). CRC Handbook / Good et al. (1966).
    'buffers' => [
        'acetate' => ['name' => 'Acetate', 'pka' => 4.76],
        'mes' => ['name' => 'MES', 'pka' => 6.15],
        'bicarbonate' => ['name' => 'Bicarbonate', 'pka' => 6.35],
        'pipes' => ['name' => 'PIPES', 'pka' => 6.76],
        'mops' => ['name' => 'MOPS', 'pka' => 7.20],
        'phosphate' => ['name' => 'Phosphate', 'pka' => 7.21],
        'hepes' => ['name' => 'HEPES', 'pka' => 7.48],
        'tris' => ['name' => 'Tris', 'pka' => 8.07],
        'ammonium' => ['name' => 'Ammonium', 'pka' => 9.25],
    ],

    /*
    | Gestation in days from breeding: average, normal range and typical milestones [day, text].
    | Merck Veterinary Manual and breed-society guidance; individual animals vary.
    */
    'gestation' => [
        'dog' => ['name' => 'Dog', 'event' => 'Whelping', 'days' => 63, 'min' => 58, 'max' => 68, 'ovulation' => ['days' => 63, 'min' => 62, 'max' => 64], 'milestones' => [
            [25, 'Ultrasound can confirm pregnancy (days 25 to 30)'],
            [28, 'A vet may feel puppies by palpation (days 28 to 35)'],
            [45, 'X-ray can count puppies (from about day 45)'],
            [56, 'Set up the whelping box; take rectal temperature twice a day'],
        ]],
        'cat' => ['name' => 'Cat', 'event' => 'Kittening', 'days' => 65, 'min' => 61, 'max' => 72, 'milestones' => [
            [15, 'Nipples turn pink and enlarge (pinking up)'],
            [20, 'Ultrasound can confirm pregnancy (from about day 20)'],
            [24, 'A vet may feel kittens by palpation (days 17 to 25)'],
            [45, 'X-ray can count kittens (from about day 45)'],
            [56, 'Provide a quiet, warm nesting box'],
        ]],
        'cow' => ['name' => 'Cow', 'event' => 'Calving', 'days' => 283, 'min' => 279, 'max' => 287, 'milestones' => [
            [30, 'Ultrasound can confirm pregnancy (from about day 28)'],
            [40, 'A vet can confirm by rectal palpation (from about day 35)'],
            [223, 'Dry off dairy cows, about 60 days before calving'],
            [270, 'Move to a clean calving area and watch for signs'],
        ]],
        'goat' => ['name' => 'Goat', 'event' => 'Kidding', 'days' => 150, 'min' => 145, 'max' => 155, 'milestones' => [
            [35, 'Ultrasound can confirm pregnancy (days 30 to 45)'],
            [108, 'Last 6 weeks: kids grow fastest, so feed quality matters most'],
            [140, 'Prepare a clean, dry kidding pen'],
        ]],
        'sheep' => ['name' => 'Sheep', 'event' => 'Lambing', 'days' => 147, 'min' => 142, 'max' => 152, 'milestones' => [
            [45, 'Ultrasound scanning can count lambs (days 45 to 90)'],
            [105, 'Last 6 weeks: lambs grow fastest, so raise feed quality'],
            [140, 'Prepare lambing pens'],
        ]],
        'pig' => ['name' => 'Pig', 'event' => 'Farrowing', 'days' => 114, 'min' => 111, 'max' => 117, 'milestones' => [
            [21, 'No return to heat suggests pregnancy (days 18 to 24)'],
            [28, 'Ultrasound can confirm pregnancy (days 24 to 35)'],
            [109, 'Move the sow to a clean farrowing pen'],
        ]],
        'horse' => ['name' => 'Horse', 'event' => 'Foaling', 'days' => 340, 'min' => 320, 'max' => 370, 'milestones' => [
            [14, 'Ultrasound can confirm pregnancy and check for twins (days 14 to 16)'],
            [28, 'Heartbeat visible on ultrasound (days 25 to 30)'],
            [310, 'Udder often starts to fill (2 to 4 weeks before)'],
            [320, 'Prepare a clean foaling stall'],
        ]],
        'llama' => ['name' => 'Llama', 'event' => 'Birth', 'days' => 350, 'min' => 335, 'max' => 360, 'milestones' => [
            [14, 'Spit-off test: a pregnant female rejects the male'],
            [30, 'Ultrasound can confirm pregnancy (from about day 30)'],
            [330, 'Prepare for birth; most crias are born in the morning'],
        ]],
        'alpaca' => ['name' => 'Alpaca', 'event' => 'Birth', 'days' => 345, 'min' => 335, 'max' => 360, 'milestones' => [
            [14, 'Spit-off test: a pregnant female rejects the male'],
            [30, 'Ultrasound can confirm pregnancy (from about day 30)'],
            [325, 'Prepare for birth; most crias are born in the morning'],
        ]],
        'rabbit' => ['name' => 'Rabbit', 'event' => 'Kindling', 'days' => 31, 'min' => 28, 'max' => 35, 'milestones' => [
            [12, 'Kits can be felt by gentle palpation (days 10 to 14)'],
            [28, 'Put in the nest box with bedding'],
        ]],
        'guinea_pig' => ['name' => 'Guinea pig', 'event' => 'Birth', 'days' => 68, 'min' => 59, 'max' => 72, 'milestones' => [
            [21, 'Ultrasound can confirm pregnancy (from about 3 weeks)'],
            [45, 'Belly widens and pups can be felt moving'],
            [60, 'Keep handling to a minimum and the cage quiet'],
        ]],
        'hamster' => ['name' => 'Hamster (Syrian)', 'event' => 'Birth', 'days' => 16, 'min' => 15, 'max' => 18, 'milestones' => [
            [10, 'Belly starts to swell'],
            [13, 'Clean the cage and add extra nesting material; then leave her alone'],
        ]],
        'ferret' => ['name' => 'Ferret', 'event' => 'Kitting', 'days' => 42, 'min' => 41, 'max' => 43, 'milestones' => [
            [14, 'A vet may feel kits by palpation (from about day 14)'],
            [35, 'Provide a nest box with soft bedding'],
        ]],
    ],

    // Typical lifespans in years, for human-equivalent ages (approximate).
    'bird_lifespans' => [
        'budgerigar' => ['name' => 'Budgerigar', 'years' => 8, 'range' => '5–10'],
        'cockatiel' => ['name' => 'Cockatiel', 'years' => 15, 'range' => '10–20'],
        'lovebird' => ['name' => 'Lovebird', 'years' => 12, 'range' => '10–15'],
        'canary' => ['name' => 'Canary', 'years' => 10, 'range' => '8–12'],
        'finch' => ['name' => 'Zebra finch', 'years' => 6, 'range' => '5–9'],
        'conure' => ['name' => 'Conure', 'years' => 20, 'range' => '15–30'],
        'parrotlet' => ['name' => 'Parrotlet', 'years' => 18, 'range' => '15–20'],
        'african_grey' => ['name' => 'African grey', 'years' => 45, 'range' => '40–60'],
        'amazon' => ['name' => 'Amazon parrot', 'years' => 45, 'range' => '30–60'],
        'cockatoo' => ['name' => 'Cockatoo', 'years' => 50, 'range' => '40–70'],
        'macaw' => ['name' => 'Macaw', 'years' => 50, 'range' => '35–60'],
        'dove' => ['name' => 'Dove or pigeon', 'years' => 12, 'range' => '10–15'],
        'chicken' => ['name' => 'Chicken', 'years' => 8, 'range' => '5–10'],
        'duck' => ['name' => 'Duck', 'years' => 10, 'range' => '8–12'],
    ],

    'hamster_lifespans' => [
        'syrian' => ['name' => 'Syrian', 'years' => 2.5, 'range' => '2–3'],
        'campbell' => ['name' => 'Campbell\'s dwarf', 'years' => 2, 'range' => '1.5–2'],
        'winter_white' => ['name' => 'Winter white dwarf', 'years' => 2, 'range' => '1.5–2'],
        'roborovski' => ['name' => 'Roborovski', 'years' => 3, 'range' => '3–3.5'],
        'chinese' => ['name' => 'Chinese', 'years' => 2.5, 'range' => '2–3'],
    ],

    // Typical breed lifespans in years from AKC breed profiles.
    'dog_breeds' => [
        'labrador' => ['name' => 'Labrador Retriever', 'range' => [11, 14]],
        'german_shepherd' => ['name' => 'German Shepherd', 'range' => [7, 10]],
        'golden' => ['name' => 'Golden Retriever', 'range' => [10, 12]],
        'french_bulldog' => ['name' => 'French Bulldog', 'range' => [10, 12]],
        'bulldog' => ['name' => 'Bulldog', 'range' => [8, 10]],
        'poodle' => ['name' => 'Poodle (Standard)', 'range' => [10, 18]],
        'beagle' => ['name' => 'Beagle', 'range' => [10, 15]],
        'rottweiler' => ['name' => 'Rottweiler', 'range' => [9, 10]],
        'dachshund' => ['name' => 'Dachshund', 'range' => [12, 16]],
        'yorkshire' => ['name' => 'Yorkshire Terrier', 'range' => [11, 15]],
        'boxer' => ['name' => 'Boxer', 'range' => [10, 12]],
        'chihuahua' => ['name' => 'Chihuahua', 'range' => [14, 16]],
        'great_dane' => ['name' => 'Great Dane', 'range' => [7, 10]],
        'shih_tzu' => ['name' => 'Shih Tzu', 'range' => [10, 18]],
        'husky' => ['name' => 'Siberian Husky', 'range' => [12, 14]],
        'border_collie' => ['name' => 'Border Collie', 'range' => [12, 15]],
        'pug' => ['name' => 'Pug', 'range' => [13, 15]],
        'cavalier' => ['name' => 'Cavalier King Charles Spaniel', 'range' => [12, 15]],
        'bernese' => ['name' => 'Bernese Mountain Dog', 'range' => [7, 10]],
        'pomeranian' => ['name' => 'Pomeranian', 'range' => [12, 16]],
        'boston' => ['name' => 'Boston Terrier', 'range' => [11, 13]],
        'doberman' => ['name' => 'Doberman Pinscher', 'range' => [10, 12]],
        'australian_shepherd' => ['name' => 'Australian Shepherd', 'range' => [12, 15]],
        'cocker' => ['name' => 'Cocker Spaniel', 'range' => [10, 14]],
        'schnauzer' => ['name' => 'Miniature Schnauzer', 'range' => [12, 15]],
        'russell' => ['name' => 'Russell Terrier', 'range' => [12, 14]],
    ],

    'guinea_pig_lifespan' => [
        'guinea_pig' => ['name' => 'Guinea pig', 'years' => 6, 'range' => '5–7'],
    ],

];
