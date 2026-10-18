<?php

/*
|--------------------------------------------------------------------------
| Construction reference data
|--------------------------------------------------------------------------
|
| Published tables used by the Construction calculators, transcribed once
| from the sources named above each set. Generated; do not edit by hand.
|
*/

return [
    // Bulk materials in kg/m³, loose (as delivered or dumped) and bank (in place before digging).
    // Source: Caterpillar Performance Handbook, "Approximate material characteristics" table, also
    // published as Cat's Earthwork Volumes Reference Tables. Moisture and grading change these, so
    // every calculator lets you replace the density with your supplier's figure. Swell = bank ÷ loose − 1.
    'bulk' => [
        'gravel_dry' => [
            'name' => 'Gravel, dry',
            'loose' => 1510,
            'bank' => 1690,
        ],
        'gravel_dry_6_50' => [
            'name' => 'Gravel, dry (6–50 mm, ¼–2 in)',
            'loose' => 1690,
            'bank' => 1900,
        ],
        'gravel_wet_6_50' => [
            'name' => 'Gravel, wet (6–50 mm, ¼–2 in)',
            'loose' => 2020,
            'bank' => 2260,
        ],
        'gravel_pitrun' => [
            'name' => 'Gravel, pit-run',
            'loose' => 1930,
            'bank' => 2170,
        ],
        'sand_dry' => [
            'name' => 'Sand, dry, loose',
            'loose' => 1420,
            'bank' => 1600,
        ],
        'sand_damp' => [
            'name' => 'Sand, damp',
            'loose' => 1690,
            'bank' => 1900,
        ],
        'sand_wet' => [
            'name' => 'Sand, wet',
            'loose' => 1840,
            'bank' => 2080,
        ],
        'sand_gravel_dry' => [
            'name' => 'Sand and gravel, dry',
            'loose' => 1720,
            'bank' => 1930,
        ],
        'sand_gravel_wet' => [
            'name' => 'Sand and gravel, wet',
            'loose' => 2020,
            'bank' => 2230,
        ],
        'sand_clay' => [
            'name' => 'Sand and clay, loose',
            'loose' => 1600,
            'bank' => 2020,
        ],
        'stone_crushed' => [
            'name' => 'Stone, crushed',
            'loose' => 1600,
            'bank' => 2670,
        ],
        'limestone_broken' => [
            'name' => 'Limestone, broken or crushed',
            'loose' => 1540,
            'bank' => 2610,
        ],
        'granite_broken' => [
            'name' => 'Granite, broken',
            'loose' => 1660,
            'bank' => 2730,
        ],
        'basalt_broken' => [
            'name' => 'Basalt, broken',
            'loose' => 1960,
            'bank' => 2970,
        ],
        'sandstone_broken' => [
            'name' => 'Sandstone, broken',
            'loose' => 1510,
            'bank' => 2520,
        ],
        'traprock_broken' => [
            'name' => 'Traprock, broken',
            'loose' => 1750,
            'bank' => 2610,
        ],
        'slag_broken' => [
            'name' => 'Slag, broken',
            'loose' => 1750,
            'bank' => 2940,
        ],
        'clay_natural' => [
            'name' => 'Clay, natural bed',
            'loose' => 1660,
            'bank' => 2020,
        ],
        'clay_dry' => [
            'name' => 'Clay, dry',
            'loose' => 1480,
            'bank' => 1840,
        ],
        'clay_wet' => [
            'name' => 'Clay, wet',
            'loose' => 1660,
            'bank' => 2080,
        ],
        'clay_gravel_dry' => [
            'name' => 'Clay and gravel, dry',
            'loose' => 1420,
            'bank' => 1660,
        ],
        'clay_gravel_wet' => [
            'name' => 'Clay and gravel, wet',
            'loose' => 1540,
            'bank' => 1840,
        ],
        'earth_dry' => [
            'name' => 'Earth, dry, packed',
            'loose' => 1510,
            'bank' => 1900,
        ],
        'earth_wet' => [
            'name' => 'Earth, wet, excavated',
            'loose' => 1600,
            'bank' => 2020,
        ],
        'loam' => [
            'name' => 'Loam',
            'loose' => 1250,
            'bank' => 1540,
        ],
        'topsoil' => [
            'name' => 'Topsoil',
            'loose' => 950,
            'bank' => 1370,
        ],
        'rock_earth_75' => [
            'name' => 'Decomposed rock, 75% rock / 25% earth',
            'loose' => 1960,
            'bank' => 2790,
        ],
        'rock_earth_50' => [
            'name' => 'Decomposed rock, 50% rock / 50% earth',
            'loose' => 1720,
            'bank' => 2280,
        ],
        'rock_earth_25' => [
            'name' => 'Decomposed rock, 25% rock / 75% earth',
            'loose' => 1570,
            'bank' => 1960,
        ],
        'cinders' => [
            'name' => 'Cinders',
            'loose' => 560,
            'bank' => 860,
        ],
        'caliche' => [
            'name' => 'Caliche',
            'loose' => 1250,
            'bank' => 2260,
        ],
    ],

    // Landscape and paving products, each mapped to the Caterpillar bulk row it is measured as.
    // Asphalt: hot-mix compacted in place, 110 lb per square yard per inch (Asphalt Institute rule) = 2350 kg/m³.
    'products' => [
        'gravel' => [
            'name' => 'Gravel (¼–2 in)',
            'bulk' => 'gravel_dry_6_50',
        ],
        'pea_gravel' => [
            'name' => 'Pea gravel',
            'bulk' => 'gravel_dry',
        ],
        'river_rock' => [
            'name' => 'River rock',
            'bulk' => 'gravel_dry_6_50',
        ],
        'crushed_stone' => [
            'name' => 'Crushed stone (#57, #411, base)',
            'bulk' => 'stone_crushed',
        ],
        'limestone' => [
            'name' => 'Crushed limestone',
            'bulk' => 'limestone_broken',
        ],
        'granite' => [
            'name' => 'Crushed granite',
            'bulk' => 'granite_broken',
        ],
        'lava_rock' => [
            'name' => 'Lava rock (cinders)',
            'bulk' => 'cinders',
        ],
        'sand' => [
            'name' => 'Sand, dry',
            'bulk' => 'sand_dry',
        ],
        'sand_damp' => [
            'name' => 'Sand, damp',
            'bulk' => 'sand_damp',
        ],
        'topsoil' => [
            'name' => 'Topsoil',
            'bulk' => 'topsoil',
        ],
        'fill_dirt' => [
            'name' => 'Fill dirt (earth, dry)',
            'bulk' => 'earth_dry',
        ],
    ],

    // Compacted hot-mix asphalt, kg/m³ (Asphalt Institute: 110 lb/yd² per inch of depth).
    'asphalt_density' => 2350,

    // Solid stone, lb/ft³: ASCE 7 commentary table "Minimum densities for design loads from materials"
    // (masonry, ashlar; slate). Converted to kg/m³ with 1 lb/ft³ = 16.018 463 kg/m³.
    'stone' => [
        'granite' => [
            'name' => 'Granite',
            'pcf' => 165,
            'density' => 2643.0,
        ],
        'limestone_crystalline' => [
            'name' => 'Limestone, crystalline',
            'pcf' => 165,
            'density' => 2643.0,
        ],
        'limestone_oolitic' => [
            'name' => 'Limestone, oolitic',
            'pcf' => 135,
            'density' => 2162.5,
        ],
        'marble' => [
            'name' => 'Marble',
            'pcf' => 173,
            'density' => 2771.2,
        ],
        'sandstone' => [
            'name' => 'Sandstone, bluestone',
            'pcf' => 144,
            'density' => 2306.7,
        ],
        'slate' => [
            'name' => 'Slate',
            'pcf' => 172,
            'density' => 2755.2,
        ],
    ],

    // Concrete unit weights, lb/ft³: ASCE 7 commentary table "Minimum densities for design loads from materials".
    'concrete' => [
        'reinforced_stone' => [
            'name' => 'Reinforced, stone aggregate (normal weight)',
            'pcf' => 150,
        ],
        'plain_stone' => [
            'name' => 'Plain, stone aggregate',
            'pcf' => 144,
        ],
        'reinforced_slag' => [
            'name' => 'Reinforced, slag aggregate',
            'pcf' => 138,
        ],
        'plain_slag' => [
            'name' => 'Plain, slag aggregate',
            'pcf' => 132,
        ],
        'reinforced_cinder' => [
            'name' => 'Reinforced, cinder aggregate',
            'pcf' => 111,
        ],
        'plain_cinder' => [
            'name' => 'Plain, cinder aggregate',
            'pcf' => 108,
        ],
        'expanded_slag' => [
            'name' => 'Plain, expanded slag aggregate (lightweight)',
            'pcf' => 100,
        ],
        'haydite' => [
            'name' => 'Plain, expanded clay or shale (lightweight)',
            'pcf' => 90,
        ],
    ],

    // Metal densities, g/cm³, from the standard or association named on each row.
    'metals' => [
        'steel' => [
            'name' => 'Carbon steel (A36, 1018, mild)',
            'density' => 7.85,
            'source' => 'ASTM A6 / EN 10025: 490 lb/ft³',
        ],
        'stainless_304' => [
            'name' => 'Stainless steel 304',
            'density' => 7.9,
            'source' => 'EN 10088-1 (1.4301)',
        ],
        'stainless_316' => [
            'name' => 'Stainless steel 316',
            'density' => 8.0,
            'source' => 'EN 10088-1 (1.4401)',
        ],
        'stainless_430' => [
            'name' => 'Stainless steel 430',
            'density' => 7.7,
            'source' => 'EN 10088-1 (1.4016)',
        ],
        'cast_iron_gray' => [
            'name' => 'Gray cast iron',
            'density' => 7.15,
            'source' => 'ASTM A48 class 30, typical',
        ],
        'ductile_iron' => [
            'name' => 'Ductile iron',
            'density' => 7.1,
            'source' => 'ASTM A536, typical',
        ],
        'al_1100' => [
            'name' => 'Aluminum 1100',
            'density' => 2.71,
            'source' => 'Aluminum Association',
        ],
        'al_2024' => [
            'name' => 'Aluminum 2024',
            'density' => 2.78,
            'source' => 'Aluminum Association',
        ],
        'al_3003' => [
            'name' => 'Aluminum 3003',
            'density' => 2.73,
            'source' => 'Aluminum Association',
        ],
        'al_5052' => [
            'name' => 'Aluminum 5052',
            'density' => 2.68,
            'source' => 'Aluminum Association',
        ],
        'al_6061' => [
            'name' => 'Aluminum 6061',
            'density' => 2.7,
            'source' => 'Aluminum Association',
        ],
        'al_6063' => [
            'name' => 'Aluminum 6063',
            'density' => 2.7,
            'source' => 'Aluminum Association',
        ],
        'al_7075' => [
            'name' => 'Aluminum 7075',
            'density' => 2.81,
            'source' => 'Aluminum Association',
        ],
        'copper' => [
            'name' => 'Copper C11000',
            'density' => 8.89,
            'source' => 'Copper Development Association',
        ],
        'brass_260' => [
            'name' => 'Brass C26000 (cartridge)',
            'density' => 8.53,
            'source' => 'Copper Development Association',
        ],
        'brass_360' => [
            'name' => 'Brass C36000 (free-cutting)',
            'density' => 8.49,
            'source' => 'Copper Development Association',
        ],
        'bronze_510' => [
            'name' => 'Phosphor bronze C51000',
            'density' => 8.86,
            'source' => 'Copper Development Association',
        ],
        'bronze_954' => [
            'name' => 'Aluminum bronze C95400',
            'density' => 7.45,
            'source' => 'Copper Development Association',
        ],
        'titanium_2' => [
            'name' => 'Titanium grade 2',
            'density' => 4.51,
            'source' => 'ASTM B265, typical',
        ],
        'titanium_5' => [
            'name' => 'Titanium Ti-6Al-4V (grade 5)',
            'density' => 4.43,
            'source' => 'ASTM B265, typical',
        ],
        'lead' => [
            'name' => 'Lead',
            'density' => 11.34,
            'source' => 'CRC Handbook',
        ],
        'zinc' => [
            'name' => 'Zinc',
            'density' => 7.13,
            'source' => 'CRC Handbook',
        ],
        'nickel' => [
            'name' => 'Nickel',
            'density' => 8.9,
            'source' => 'CRC Handbook',
        ],
        'tin' => [
            'name' => 'Tin',
            'density' => 7.29,
            'source' => 'CRC Handbook',
        ],
        'magnesium' => [
            'name' => 'Magnesium',
            'density' => 1.74,
            'source' => 'CRC Handbook',
        ],
        'silver' => [
            'name' => 'Silver',
            'density' => 10.5,
            'source' => 'CRC Handbook',
        ],
        'gold' => [
            'name' => 'Gold',
            'density' => 19.3,
            'source' => 'CRC Handbook',
        ],
        'tungsten' => [
            'name' => 'Tungsten',
            'density' => 19.3,
            'source' => 'CRC Handbook',
        ],
    ],

    // Glass densities, g/cm³: soda-lime float EN 572-1 (2.5); borosilicate SCHOTT BOROFLOAT 33 data sheet (2.23);
    // fused silica Corning HPFS 7980 data sheet (2.20). Laminated glass adds the interlayer (PVB about 1.07).
    'glass' => [
        'soda_lime' => [
            'name' => 'Float glass (soda-lime, clear, tempered or low-iron)',
            'density' => 2.5,
        ],
        'borosilicate' => [
            'name' => 'Borosilicate (BOROFLOAT 33, Pyrex type)',
            'density' => 2.23,
        ],
        'fused_silica' => [
            'name' => 'Fused silica (quartz glass)',
            'density' => 2.2,
        ],
    ],

    // Wood species: USDA Forest Products Laboratory, Wood Handbook (FPL-GTR-282, 2021).
    // sg_green and sg_12 are specific gravity on oven-dry weight and volume green or at 12% moisture,
    // e_12 the modulus of elasticity at 12% moisture in MPa (Table 5-3a). mc_green is the mean of the
    // heartwood and sapwood green moisture content in % (Table 4-1), where the handbook lists it.
    // Density at moisture M: ρ = 1000 × G × (1 + M/100) kg/m³ (Wood Handbook chapter 4).
    'wood' => [
        'douglas_fir' => [
            'name' => 'Douglas-fir, coast',
            'kind' => 'softwood',
            'sg_green' => 0.45,
            'sg_12' => 0.48,
            'e_12' => 13400,
            'mc_green' => 76,
        ],
        'southern_pine_loblolly' => [
            'name' => 'Southern pine, loblolly',
            'kind' => 'softwood',
            'sg_green' => 0.47,
            'sg_12' => 0.51,
            'e_12' => 12300,
            'mc_green' => 72,
        ],
        'southern_pine_longleaf' => [
            'name' => 'Southern pine, longleaf',
            'kind' => 'softwood',
            'sg_green' => 0.54,
            'sg_12' => 0.59,
            'e_12' => 13700,
            'mc_green' => 68,
        ],
        'southern_pine_shortleaf' => [
            'name' => 'Southern pine, shortleaf',
            'kind' => 'softwood',
            'sg_green' => 0.47,
            'sg_12' => 0.51,
            'e_12' => 12100,
            'mc_green' => 77,
        ],
        'southern_pine_slash' => [
            'name' => 'Southern pine, slash',
            'kind' => 'softwood',
            'sg_green' => 0.54,
            'sg_12' => 0.59,
            'e_12' => 13700,
        ],
        'ponderosa_pine' => [
            'name' => 'Ponderosa pine',
            'kind' => 'softwood',
            'sg_green' => 0.38,
            'sg_12' => 0.4,
            'e_12' => 8900,
            'mc_green' => 94,
        ],
        'eastern_white_pine' => [
            'name' => 'Eastern white pine',
            'kind' => 'softwood',
            'sg_green' => 0.34,
            'sg_12' => 0.35,
            'e_12' => 8500,
        ],
        'lodgepole_pine' => [
            'name' => 'Lodgepole pine',
            'kind' => 'softwood',
            'sg_green' => 0.38,
            'sg_12' => 0.41,
            'e_12' => 9200,
            'mc_green' => 80,
        ],
        'red_pine' => [
            'name' => 'Red pine',
            'kind' => 'softwood',
            'sg_green' => 0.41,
            'sg_12' => 0.46,
            'e_12' => 11200,
            'mc_green' => 83,
        ],
        'sugar_pine' => [
            'name' => 'Sugar pine',
            'kind' => 'softwood',
            'sg_green' => 0.34,
            'sg_12' => 0.36,
            'e_12' => 8200,
            'mc_green' => 158,
        ],
        'western_hemlock' => [
            'name' => 'Western hemlock',
            'kind' => 'softwood',
            'sg_green' => 0.42,
            'sg_12' => 0.45,
            'e_12' => 11300,
            'mc_green' => 128,
        ],
        'eastern_hemlock' => [
            'name' => 'Eastern hemlock',
            'kind' => 'softwood',
            'sg_green' => 0.38,
            'sg_12' => 0.4,
            'e_12' => 8300,
            'mc_green' => 108,
        ],
        'western_larch' => [
            'name' => 'Western larch',
            'kind' => 'softwood',
            'sg_green' => 0.48,
            'sg_12' => 0.52,
            'e_12' => 12900,
            'mc_green' => 86,
        ],
        'white_fir' => [
            'name' => 'White fir',
            'kind' => 'softwood',
            'sg_green' => 0.37,
            'sg_12' => 0.39,
            'e_12' => 10300,
            'mc_green' => 129,
        ],
        'balsam_fir' => [
            'name' => 'Balsam fir',
            'kind' => 'softwood',
            'sg_green' => 0.33,
            'sg_12' => 0.35,
            'e_12' => 10000,
            'mc_green' => 130,
        ],
        'grand_fir' => [
            'name' => 'Grand fir',
            'kind' => 'softwood',
            'sg_green' => 0.35,
            'sg_12' => 0.37,
            'e_12' => 10800,
            'mc_green' => 114,
        ],
        'engelmann_spruce' => [
            'name' => 'Engelmann spruce',
            'kind' => 'softwood',
            'sg_green' => 0.33,
            'sg_12' => 0.35,
            'e_12' => 8900,
            'mc_green' => 112,
        ],
        'sitka_spruce' => [
            'name' => 'Sitka spruce',
            'kind' => 'softwood',
            'sg_green' => 0.37,
            'sg_12' => 0.4,
            'e_12' => 10800,
            'mc_green' => 92,
        ],
        'black_spruce' => [
            'name' => 'Black spruce',
            'kind' => 'softwood',
            'sg_green' => 0.38,
            'sg_12' => 0.42,
            'e_12' => 11100,
            'mc_green' => 82,
        ],
        'white_spruce' => [
            'name' => 'White spruce',
            'kind' => 'softwood',
            'sg_green' => 0.33,
            'sg_12' => 0.36,
            'e_12' => 9600,
        ],
        'western_redcedar' => [
            'name' => 'Western redcedar',
            'kind' => 'softwood',
            'sg_green' => 0.31,
            'sg_12' => 0.32,
            'e_12' => 7700,
            'mc_green' => 154,
        ],
        'eastern_redcedar' => [
            'name' => 'Eastern redcedar',
            'kind' => 'softwood',
            'sg_green' => 0.44,
            'sg_12' => 0.47,
            'e_12' => 6100,
        ],
        'incense_cedar' => [
            'name' => 'Incense-cedar',
            'kind' => 'softwood',
            'sg_green' => 0.35,
            'sg_12' => 0.37,
            'e_12' => 7200,
            'mc_green' => 126,
        ],
        'redwood_old' => [
            'name' => 'Redwood, old-growth',
            'kind' => 'softwood',
            'sg_green' => 0.38,
            'sg_12' => 0.4,
            'e_12' => 9200,
            'mc_green' => 148,
        ],
        'redwood_young' => [
            'name' => 'Redwood, young-growth',
            'kind' => 'softwood',
            'sg_green' => 0.34,
            'sg_12' => 0.35,
            'e_12' => 7600,
        ],
        'baldcypress' => [
            'name' => 'Baldcypress',
            'kind' => 'softwood',
            'sg_green' => 0.42,
            'sg_12' => 0.46,
            'e_12' => 9900,
            'mc_green' => 146,
        ],
        'tamarack' => [
            'name' => 'Tamarack',
            'kind' => 'softwood',
            'sg_green' => 0.49,
            'sg_12' => 0.53,
            'e_12' => 11300,
        ],
        'white_oak' => [
            'name' => 'White oak',
            'kind' => 'hardwood',
            'sg_green' => 0.6,
            'sg_12' => 0.68,
            'e_12' => 12300,
            'mc_green' => 71,
        ],
        'northern_red_oak' => [
            'name' => 'Northern red oak',
            'kind' => 'hardwood',
            'sg_green' => 0.56,
            'sg_12' => 0.63,
            'e_12' => 12500,
            'mc_green' => 74,
        ],
        'southern_red_oak' => [
            'name' => 'Southern red oak',
            'kind' => 'hardwood',
            'sg_green' => 0.52,
            'sg_12' => 0.59,
            'e_12' => 10300,
            'mc_green' => 79,
        ],
        'live_oak' => [
            'name' => 'Live oak',
            'kind' => 'hardwood',
            'sg_green' => 0.8,
            'sg_12' => 0.88,
            'e_12' => 13700,
        ],
        'sugar_maple' => [
            'name' => 'Sugar maple (hard maple)',
            'kind' => 'hardwood',
            'sg_green' => 0.56,
            'sg_12' => 0.63,
            'e_12' => 12600,
            'mc_green' => 68,
        ],
        'red_maple' => [
            'name' => 'Red maple (soft maple)',
            'kind' => 'hardwood',
            'sg_green' => 0.49,
            'sg_12' => 0.54,
            'e_12' => 11300,
        ],
        'silver_maple' => [
            'name' => 'Silver maple',
            'kind' => 'hardwood',
            'sg_green' => 0.44,
            'sg_12' => 0.47,
            'e_12' => 7900,
            'mc_green' => 78,
        ],
        'white_ash' => [
            'name' => 'White ash',
            'kind' => 'hardwood',
            'sg_green' => 0.55,
            'sg_12' => 0.6,
            'e_12' => 12000,
            'mc_green' => 45,
        ],
        'green_ash' => [
            'name' => 'Green ash',
            'kind' => 'hardwood',
            'sg_green' => 0.53,
            'sg_12' => 0.56,
            'e_12' => 11400,
        ],
        'yellow_birch' => [
            'name' => 'Yellow birch',
            'kind' => 'hardwood',
            'sg_green' => 0.55,
            'sg_12' => 0.62,
            'e_12' => 13900,
            'mc_green' => 73,
        ],
        'paper_birch' => [
            'name' => 'Paper birch',
            'kind' => 'hardwood',
            'sg_green' => 0.48,
            'sg_12' => 0.55,
            'e_12' => 11000,
            'mc_green' => 80,
        ],
        'american_beech' => [
            'name' => 'American beech',
            'kind' => 'hardwood',
            'sg_green' => 0.56,
            'sg_12' => 0.64,
            'e_12' => 11900,
            'mc_green' => 64,
        ],
        'black_cherry' => [
            'name' => 'Black cherry',
            'kind' => 'hardwood',
            'sg_green' => 0.47,
            'sg_12' => 0.5,
            'e_12' => 10300,
        ],
        'black_walnut' => [
            'name' => 'Black walnut',
            'kind' => 'hardwood',
            'sg_green' => 0.51,
            'sg_12' => 0.55,
            'e_12' => 11600,
            'mc_green' => 82,
        ],
        'shagbark_hickory' => [
            'name' => 'Shagbark hickory',
            'kind' => 'hardwood',
            'sg_green' => 0.64,
            'sg_12' => 0.72,
            'e_12' => 14900,
        ],
        'pecan' => [
            'name' => 'Pecan',
            'kind' => 'hardwood',
            'sg_green' => 0.6,
            'sg_12' => 0.66,
            'e_12' => 11900,
        ],
        'black_locust' => [
            'name' => 'Black locust',
            'kind' => 'hardwood',
            'sg_green' => 0.66,
            'sg_12' => 0.69,
            'e_12' => 14100,
        ],
        'yellow_poplar' => [
            'name' => 'Yellow-poplar (tulip poplar)',
            'kind' => 'hardwood',
            'sg_green' => 0.4,
            'sg_12' => 0.42,
            'e_12' => 10900,
            'mc_green' => 94,
        ],
        'quaking_aspen' => [
            'name' => 'Quaking aspen',
            'kind' => 'hardwood',
            'sg_green' => 0.35,
            'sg_12' => 0.38,
            'e_12' => 8100,
            'mc_green' => 104,
        ],
        'eastern_cottonwood' => [
            'name' => 'Eastern cottonwood',
            'kind' => 'hardwood',
            'sg_green' => 0.37,
            'sg_12' => 0.4,
            'e_12' => 9400,
            'mc_green' => 154,
        ],
        'american_basswood' => [
            'name' => 'American basswood',
            'kind' => 'hardwood',
            'sg_green' => 0.32,
            'sg_12' => 0.37,
            'e_12' => 10100,
            'mc_green' => 107,
        ],
        'american_elm' => [
            'name' => 'American elm',
            'kind' => 'hardwood',
            'sg_green' => 0.46,
            'sg_12' => 0.5,
            'e_12' => 9200,
            'mc_green' => 94,
        ],
        'hackberry' => [
            'name' => 'Hackberry',
            'kind' => 'hardwood',
            'sg_green' => 0.49,
            'sg_12' => 0.53,
            'e_12' => 8200,
            'mc_green' => 63,
        ],
        'sweetgum' => [
            'name' => 'Sweetgum',
            'kind' => 'hardwood',
            'sg_green' => 0.46,
            'sg_12' => 0.52,
            'e_12' => 11300,
            'mc_green' => 108,
        ],
        'sycamore' => [
            'name' => 'American sycamore',
            'kind' => 'hardwood',
            'sg_green' => 0.46,
            'sg_12' => 0.49,
            'e_12' => 9800,
            'mc_green' => 122,
        ],
        'black_tupelo' => [
            'name' => 'Black tupelo (blackgum)',
            'kind' => 'hardwood',
            'sg_green' => 0.46,
            'sg_12' => 0.5,
            'e_12' => 8300,
            'mc_green' => 101,
        ],
        'red_alder' => [
            'name' => 'Red alder',
            'kind' => 'hardwood',
            'sg_green' => 0.37,
            'sg_12' => 0.41,
            'e_12' => 9500,
            'mc_green' => 97,
        ],
    ],

    // Dressed (actual) sizes of softwood lumber, inches, dry: American Softwood Lumber Standard PS 20
    // (boards and dimension lumber). Timbers 5 in and thicker are dressed green to ½ in under nominal.
    'lumber_dressed' => [
        1 => 0.75,
        2 => 1.5,
        3 => 2.5,
        4 => 3.5,
        5 => 4.5,
        6 => 5.5,
        7 => 6.5,
        8 => 7.25,
        9 => 8.25,
        10 => 9.25,
        11 => 10.25,
        12 => 11.25,
        14 => 13.25,
        16 => 15.25,
    ],

    // Steel pipe, inches: ASME B36.10M outside diameters and wall thicknesses for schedules 10, STD, 40,
    // XS, 80, 160 and XXS (null where the schedule is not made in that size).
    'pipe' => [
        'schedules' => [
            '10' => 'Sch 10',
            'std' => 'STD',
            '40' => 'Sch 40',
            'xs' => 'XS (extra strong)',
            '80' => 'Sch 80',
            '160' => 'Sch 160',
            'xxs' => 'XXS',
        ],
        'sizes' => [
            '1/8' => [
                'od' => 0.405,
                'wall' => [
                    '10' => 0.049,
                    'std' => 0.068,
                    '40' => 0.068,
                    'xs' => 0.095,
                    '80' => 0.095,
                    '160' => null,
                    'xxs' => null,
                ],
            ],
            '1/4' => [
                'od' => 0.54,
                'wall' => [
                    '10' => 0.065,
                    'std' => 0.088,
                    '40' => 0.088,
                    'xs' => 0.119,
                    '80' => 0.119,
                    '160' => null,
                    'xxs' => null,
                ],
            ],
            '3/8' => [
                'od' => 0.675,
                'wall' => [
                    '10' => 0.065,
                    'std' => 0.091,
                    '40' => 0.091,
                    'xs' => 0.126,
                    '80' => 0.126,
                    '160' => null,
                    'xxs' => null,
                ],
            ],
            '1/2' => [
                'od' => 0.84,
                'wall' => [
                    '10' => 0.083,
                    'std' => 0.109,
                    '40' => 0.109,
                    'xs' => 0.147,
                    '80' => 0.147,
                    '160' => 0.188,
                    'xxs' => 0.294,
                ],
            ],
            '3/4' => [
                'od' => 1.05,
                'wall' => [
                    '10' => 0.083,
                    'std' => 0.113,
                    '40' => 0.113,
                    'xs' => 0.154,
                    '80' => 0.154,
                    '160' => 0.219,
                    'xxs' => 0.308,
                ],
            ],
            '1' => [
                'od' => 1.315,
                'wall' => [
                    '10' => 0.109,
                    'std' => 0.133,
                    '40' => 0.133,
                    'xs' => 0.179,
                    '80' => 0.179,
                    '160' => 0.25,
                    'xxs' => 0.358,
                ],
            ],
            '1-1/4' => [
                'od' => 1.66,
                'wall' => [
                    '10' => 0.109,
                    'std' => 0.14,
                    '40' => 0.14,
                    'xs' => 0.191,
                    '80' => 0.191,
                    '160' => 0.25,
                    'xxs' => 0.382,
                ],
            ],
            '1-1/2' => [
                'od' => 1.9,
                'wall' => [
                    '10' => 0.109,
                    'std' => 0.145,
                    '40' => 0.145,
                    'xs' => 0.2,
                    '80' => 0.2,
                    '160' => 0.281,
                    'xxs' => 0.4,
                ],
            ],
            '2' => [
                'od' => 2.375,
                'wall' => [
                    '10' => 0.109,
                    'std' => 0.154,
                    '40' => 0.154,
                    'xs' => 0.218,
                    '80' => 0.218,
                    '160' => 0.344,
                    'xxs' => 0.436,
                ],
            ],
            '2-1/2' => [
                'od' => 2.875,
                'wall' => [
                    '10' => 0.12,
                    'std' => 0.203,
                    '40' => 0.203,
                    'xs' => 0.276,
                    '80' => 0.276,
                    '160' => 0.375,
                    'xxs' => 0.552,
                ],
            ],
            '3' => [
                'od' => 3.5,
                'wall' => [
                    '10' => 0.12,
                    'std' => 0.216,
                    '40' => 0.216,
                    'xs' => 0.3,
                    '80' => 0.3,
                    '160' => 0.438,
                    'xxs' => 0.6,
                ],
            ],
            '3-1/2' => [
                'od' => 4.0,
                'wall' => [
                    '10' => 0.12,
                    'std' => 0.226,
                    '40' => 0.226,
                    'xs' => 0.318,
                    '80' => 0.318,
                    '160' => null,
                    'xxs' => 0.636,
                ],
            ],
            '4' => [
                'od' => 4.5,
                'wall' => [
                    '10' => 0.12,
                    'std' => 0.237,
                    '40' => 0.237,
                    'xs' => 0.337,
                    '80' => 0.337,
                    '160' => 0.531,
                    'xxs' => 0.674,
                ],
            ],
            '5' => [
                'od' => 5.563,
                'wall' => [
                    '10' => 0.134,
                    'std' => 0.258,
                    '40' => 0.258,
                    'xs' => 0.375,
                    '80' => 0.375,
                    '160' => 0.625,
                    'xxs' => 0.75,
                ],
            ],
            '6' => [
                'od' => 6.625,
                'wall' => [
                    '10' => 0.134,
                    'std' => 0.28,
                    '40' => 0.28,
                    'xs' => 0.432,
                    '80' => 0.432,
                    '160' => 0.719,
                    'xxs' => 0.864,
                ],
            ],
            '8' => [
                'od' => 8.625,
                'wall' => [
                    '10' => 0.148,
                    'std' => 0.322,
                    '40' => 0.322,
                    'xs' => 0.5,
                    '80' => 0.5,
                    '160' => 0.906,
                    'xxs' => 0.875,
                ],
            ],
            '10' => [
                'od' => 10.75,
                'wall' => [
                    '10' => 0.165,
                    'std' => 0.365,
                    '40' => 0.365,
                    'xs' => 0.5,
                    '80' => 0.594,
                    '160' => 1.125,
                    'xxs' => 1.0,
                ],
            ],
            '12' => [
                'od' => 12.75,
                'wall' => [
                    '10' => 0.18,
                    'std' => 0.375,
                    '40' => 0.406,
                    'xs' => 0.5,
                    '80' => 0.688,
                    '160' => 1.312,
                    'xxs' => 1.0,
                ],
            ],
            '14' => [
                'od' => 14.0,
                'wall' => [
                    '10' => 0.25,
                    'std' => 0.375,
                    '40' => 0.438,
                    'xs' => 0.5,
                    '80' => 0.75,
                    '160' => 1.406,
                    'xxs' => null,
                ],
            ],
            '16' => [
                'od' => 16.0,
                'wall' => [
                    '10' => 0.25,
                    'std' => 0.375,
                    '40' => 0.5,
                    'xs' => 0.5,
                    '80' => 0.844,
                    '160' => 1.594,
                    'xxs' => null,
                ],
            ],
            '18' => [
                'od' => 18.0,
                'wall' => [
                    '10' => 0.25,
                    'std' => 0.375,
                    '40' => 0.562,
                    'xs' => 0.5,
                    '80' => 0.938,
                    '160' => 1.781,
                    'xxs' => null,
                ],
            ],
            '20' => [
                'od' => 20.0,
                'wall' => [
                    '10' => 0.25,
                    'std' => 0.375,
                    '40' => 0.594,
                    'xs' => 0.5,
                    '80' => 1.031,
                    '160' => 1.969,
                    'xxs' => null,
                ],
            ],
            '24' => [
                'od' => 24.0,
                'wall' => [
                    '10' => 0.25,
                    'std' => 0.375,
                    '40' => 0.688,
                    'xs' => 0.5,
                    '80' => 1.219,
                    '160' => 2.344,
                    'xxs' => null,
                ],
            ],
        ],
    ],

    // Reinforcing bars. US: ASTM A615/A706 bar designations, nominal diameter (in), area (in²), weight (lb/ft).
    // Metric: EN 10080 nominal diameter (mm) and mass (kg/m).
    'rebar' => [
        'us' => [
            '#3' => [
                'diameter' => 0.375,
                'area' => 0.11,
                'weight' => 0.376,
            ],
            '#4' => [
                'diameter' => 0.5,
                'area' => 0.2,
                'weight' => 0.668,
            ],
            '#5' => [
                'diameter' => 0.625,
                'area' => 0.31,
                'weight' => 1.043,
            ],
            '#6' => [
                'diameter' => 0.75,
                'area' => 0.44,
                'weight' => 1.502,
            ],
            '#7' => [
                'diameter' => 0.875,
                'area' => 0.6,
                'weight' => 2.044,
            ],
            '#8' => [
                'diameter' => 1.0,
                'area' => 0.79,
                'weight' => 2.67,
            ],
            '#9' => [
                'diameter' => 1.128,
                'area' => 1.0,
                'weight' => 3.4,
            ],
            '#10' => [
                'diameter' => 1.27,
                'area' => 1.27,
                'weight' => 4.303,
            ],
            '#11' => [
                'diameter' => 1.41,
                'area' => 1.56,
                'weight' => 5.313,
            ],
            '#14' => [
                'diameter' => 1.693,
                'area' => 2.25,
                'weight' => 7.65,
            ],
            '#18' => [
                'diameter' => 2.257,
                'area' => 4.0,
                'weight' => 13.6,
            ],
        ],
        'metric' => [
            '6 mm' => [
                'diameter' => 6,
                'mass' => 0.222,
            ],
            '8 mm' => [
                'diameter' => 8,
                'mass' => 0.395,
            ],
            '10 mm' => [
                'diameter' => 10,
                'mass' => 0.617,
            ],
            '12 mm' => [
                'diameter' => 12,
                'mass' => 0.888,
            ],
            '14 mm' => [
                'diameter' => 14,
                'mass' => 1.21,
            ],
            '16 mm' => [
                'diameter' => 16,
                'mass' => 1.58,
            ],
            '20 mm' => [
                'diameter' => 20,
                'mass' => 2.47,
            ],
            '25 mm' => [
                'diameter' => 25,
                'mass' => 3.85,
            ],
            '28 mm' => [
                'diameter' => 28,
                'mass' => 4.83,
            ],
            '32 mm' => [
                'diameter' => 32,
                'mass' => 6.31,
            ],
            '40 mm' => [
                'diameter' => 40,
                'mass' => 9.86,
            ],
            '50 mm' => [
                'diameter' => 50,
                'mass' => 15.4,
            ],
        ],
    ],

    // Conductors (NFPA 70, National Electrical Code): circular mils and DC resistance at 75 °C in Ω per 1000 ft
    // for stranded uncoated copper and aluminum (Chapter 9 Table 8); ampacity at 60/75/90 °C, not more than
    // three current-carrying conductors, 30 °C ambient (Table 310.16); approximate area in in² of THHN/THWN-2,
    // THW and XHHW conductors (Chapter 9 Table 5). 14 AWG aluminum is not listed in Table 310.16.
    'wires' => [
        '14' => [
            'label' => '14 AWG',
            'cmil' => 4110,
            'r_cu' => 3.14,
            'r_al' => 5.17,
            'amp_cu' => [15, 20, 25],
            'amp_al' => null,
            'area' => [
                'thhn' => 0.0097,
                'thw' => 0.0139,
                'xhhw' => 0.0139,
            ],
        ],
        '12' => [
            'label' => '12 AWG',
            'cmil' => 6530,
            'r_cu' => 1.98,
            'r_al' => 3.25,
            'amp_cu' => [20, 25, 30],
            'amp_al' => [15, 20, 25],
            'area' => [
                'thhn' => 0.0133,
                'thw' => 0.0181,
                'xhhw' => 0.0181,
            ],
        ],
        '10' => [
            'label' => '10 AWG',
            'cmil' => 10380,
            'r_cu' => 1.24,
            'r_al' => 2.04,
            'amp_cu' => [30, 35, 40],
            'amp_al' => [25, 30, 35],
            'area' => [
                'thhn' => 0.0211,
                'thw' => 0.0243,
                'xhhw' => 0.0243,
            ],
        ],
        '8' => [
            'label' => '8 AWG',
            'cmil' => 16510,
            'r_cu' => 0.778,
            'r_al' => 1.28,
            'amp_cu' => [40, 50, 55],
            'amp_al' => [35, 40, 45],
            'area' => [
                'thhn' => 0.0366,
                'thw' => 0.0437,
                'xhhw' => 0.0437,
            ],
        ],
        '6' => [
            'label' => '6 AWG',
            'cmil' => 26240,
            'r_cu' => 0.491,
            'r_al' => 0.808,
            'amp_cu' => [55, 65, 75],
            'amp_al' => [40, 50, 55],
            'area' => [
                'thhn' => 0.0507,
                'thw' => 0.0726,
                'xhhw' => 0.059,
            ],
        ],
        '4' => [
            'label' => '4 AWG',
            'cmil' => 41740,
            'r_cu' => 0.308,
            'r_al' => 0.508,
            'amp_cu' => [70, 85, 95],
            'amp_al' => [55, 65, 75],
            'area' => [
                'thhn' => 0.0824,
                'thw' => 0.0973,
                'xhhw' => 0.0814,
            ],
        ],
        '3' => [
            'label' => '3 AWG',
            'cmil' => 52620,
            'r_cu' => 0.245,
            'r_al' => 0.403,
            'amp_cu' => [85, 100, 115],
            'amp_al' => [65, 75, 85],
            'area' => [
                'thhn' => 0.0973,
                'thw' => 0.1134,
                'xhhw' => 0.0962,
            ],
        ],
        '2' => [
            'label' => '2 AWG',
            'cmil' => 66360,
            'r_cu' => 0.194,
            'r_al' => 0.319,
            'amp_cu' => [95, 115, 130],
            'amp_al' => [75, 90, 100],
            'area' => [
                'thhn' => 0.1158,
                'thw' => 0.1333,
                'xhhw' => 0.1146,
            ],
        ],
        '1' => [
            'label' => '1 AWG',
            'cmil' => 83690,
            'r_cu' => 0.154,
            'r_al' => 0.253,
            'amp_cu' => [110, 130, 145],
            'amp_al' => [85, 100, 115],
            'area' => [
                'thhn' => 0.1562,
                'thw' => 0.1901,
                'xhhw' => 0.1534,
            ],
        ],
        '1/0' => [
            'label' => '1/0 AWG',
            'cmil' => 105600,
            'r_cu' => 0.122,
            'r_al' => 0.201,
            'amp_cu' => [125, 150, 170],
            'amp_al' => [100, 120, 135],
            'area' => [
                'thhn' => 0.1855,
                'thw' => 0.2223,
                'xhhw' => 0.1825,
            ],
        ],
        '2/0' => [
            'label' => '2/0 AWG',
            'cmil' => 133100,
            'r_cu' => 0.0967,
            'r_al' => 0.159,
            'amp_cu' => [145, 175, 195],
            'amp_al' => [115, 135, 150],
            'area' => [
                'thhn' => 0.2223,
                'thw' => 0.2624,
                'xhhw' => 0.219,
            ],
        ],
        '3/0' => [
            'label' => '3/0 AWG',
            'cmil' => 167800,
            'r_cu' => 0.0766,
            'r_al' => 0.126,
            'amp_cu' => [165, 200, 225],
            'amp_al' => [130, 155, 175],
            'area' => [
                'thhn' => 0.2679,
                'thw' => 0.3117,
                'xhhw' => 0.2642,
            ],
        ],
        '4/0' => [
            'label' => '4/0 AWG',
            'cmil' => 211600,
            'r_cu' => 0.0608,
            'r_al' => 0.1,
            'amp_cu' => [195, 230, 260],
            'amp_al' => [150, 180, 205],
            'area' => [
                'thhn' => 0.3237,
                'thw' => 0.3718,
                'xhhw' => 0.3197,
            ],
        ],
        '250' => [
            'label' => '250 kcmil',
            'cmil' => 250000,
            'r_cu' => 0.0515,
            'r_al' => 0.0847,
            'amp_cu' => [215, 255, 290],
            'amp_al' => [170, 205, 230],
            'area' => [
                'thhn' => 0.397,
                'thw' => 0.4596,
                'xhhw' => 0.3904,
            ],
        ],
        '300' => [
            'label' => '300 kcmil',
            'cmil' => 300000,
            'r_cu' => 0.0429,
            'r_al' => 0.0707,
            'amp_cu' => [240, 285, 320],
            'amp_al' => [195, 230, 260],
            'area' => [
                'thhn' => 0.4608,
                'thw' => 0.5281,
                'xhhw' => 0.4536,
            ],
        ],
        '350' => [
            'label' => '350 kcmil',
            'cmil' => 350000,
            'r_cu' => 0.0367,
            'r_al' => 0.0605,
            'amp_cu' => [260, 310, 350],
            'amp_al' => [210, 250, 280],
            'area' => [
                'thhn' => 0.5242,
                'thw' => 0.5958,
                'xhhw' => 0.5166,
            ],
        ],
        '400' => [
            'label' => '400 kcmil',
            'cmil' => 400000,
            'r_cu' => 0.0321,
            'r_al' => 0.0529,
            'amp_cu' => [280, 335, 380],
            'amp_al' => [225, 270, 305],
            'area' => [
                'thhn' => 0.5863,
                'thw' => 0.6619,
                'xhhw' => 0.5782,
            ],
        ],
        '500' => [
            'label' => '500 kcmil',
            'cmil' => 500000,
            'r_cu' => 0.0258,
            'r_al' => 0.0424,
            'amp_cu' => [320, 380, 430],
            'amp_al' => [260, 310, 350],
            'area' => [
                'thhn' => 0.7073,
                'thw' => 0.7901,
                'xhhw' => 0.7072,
            ],
        ],
        '600' => [
            'label' => '600 kcmil',
            'cmil' => 600000,
            'r_cu' => 0.0214,
            'r_al' => 0.0353,
            'amp_cu' => [350, 420, 475],
            'amp_al' => [285, 340, 385],
            'area' => [
                'thhn' => 0.8676,
                'thw' => 0.9729,
                'xhhw' => 0.8495,
            ],
        ],
        '750' => [
            'label' => '750 kcmil',
            'cmil' => 750000,
            'r_cu' => 0.0171,
            'r_al' => 0.0282,
            'amp_cu' => [400, 475, 535],
            'amp_al' => [320, 385, 435],
            'area' => [
                'thhn' => 1.0496,
                'thw' => 1.1652,
                'xhhw' => 1.0496,
            ],
        ],
        '1000' => [
            'label' => '1000 kcmil',
            'cmil' => 1000000,
            'r_cu' => 0.0129,
            'r_al' => 0.0212,
            'amp_cu' => [455, 545, 615],
            'amp_al' => [375, 445, 500],
            'area' => [
                'thhn' => 1.3478,
                'thw' => 1.4784,
                'xhhw' => 1.3561,
            ],
        ],
    ],

    // Raceway total internal area, in² (100%), NEC Chapter 9 Table 4. Allowed fill (Chapter 9 Table 1):
    // 53% for one conductor, 31% for two, 40% for more than two.
    'conduits' => [
        'emt' => [
            'name' => 'EMT (electrical metallic tubing)',
            'sizes' => [
                '1/2' => 0.304,
                '3/4' => 0.533,
                '1' => 0.864,
                '1-1/4' => 1.496,
                '1-1/2' => 2.036,
                '2' => 3.356,
                '2-1/2' => 5.858,
                '3' => 8.846,
                '3-1/2' => 11.545,
                '4' => 14.753,
            ],
        ],
        'rmc' => [
            'name' => 'RMC (rigid metal conduit)',
            'sizes' => [
                '1/2' => 0.314,
                '3/4' => 0.549,
                '1' => 0.887,
                '1-1/4' => 1.526,
                '1-1/2' => 2.071,
                '2' => 3.408,
                '2-1/2' => 4.866,
                '3' => 7.499,
                '3-1/2' => 10.01,
                '4' => 12.882,
                '5' => 20.212,
                '6' => 29.158,
            ],
        ],
        'pvc40' => [
            'name' => 'PVC Schedule 40',
            'sizes' => [
                '1/2' => 0.285,
                '3/4' => 0.508,
                '1' => 0.832,
                '1-1/4' => 1.453,
                '1-1/2' => 1.986,
                '2' => 3.291,
                '2-1/2' => 4.695,
                '3' => 7.268,
                '3-1/2' => 9.737,
                '4' => 12.554,
                '5' => 19.761,
                '6' => 28.567,
            ],
        ],
        'pvc80' => [
            'name' => 'PVC Schedule 80',
            'sizes' => [
                '1/2' => 0.217,
                '3/4' => 0.409,
                '1' => 0.688,
                '1-1/4' => 1.237,
                '1-1/2' => 1.711,
                '2' => 2.874,
                '2-1/2' => 4.119,
                '3' => 6.442,
                '3-1/2' => 8.688,
                '4' => 11.258,
                '5' => 17.855,
                '6' => 25.598,
            ],
        ],
    ],

    // Box fill, NEC 314.16. Volume allowance per conductor in in³ (Table 314.16(B)(1)), and standard metal
    // boxes with their volumes in in³ (Table 314.16(A)).
    'box_fill' => [
        'allowance' => [
            '18' => 1.5,
            '16' => 1.75,
            '14' => 2.0,
            '12' => 2.25,
            '10' => 2.5,
            '8' => 3.0,
            '6' => 5.0,
        ],
        'boxes' => [
            'round_4_114' => ['4 × 1¼ in round or octagonal', 12.5],
            'round_4_112' => ['4 × 1½ in round or octagonal', 15.5],
            'round_4_218' => ['4 × 2⅛ in round or octagonal', 21.5],
            'square_4_114' => ['4 × 1¼ in square', 18.0],
            'square_4_112' => ['4 × 1½ in square', 21.0],
            'square_4_218' => ['4 × 2⅛ in square', 30.3],
            'square_41116_114' => ['4¹¹⁄₁₆ × 1¼ in square', 25.5],
            'square_41116_112' => ['4¹¹⁄₁₆ × 1½ in square', 29.5],
            'square_41116_218' => ['4¹¹⁄₁₆ × 2⅛ in square', 42.0],
            'device_3_2_112' => ['3 × 2 × 1½ in device', 7.5],
            'device_3_2_2' => ['3 × 2 × 2 in device', 10.0],
            'device_3_2_214' => ['3 × 2 × 2¼ in device', 10.5],
            'device_3_2_212' => ['3 × 2 × 2½ in device', 12.5],
            'device_3_2_234' => ['3 × 2 × 2¾ in device', 14.0],
            'device_3_2_312' => ['3 × 2 × 3½ in device', 18.0],
            'device_4_218_112' => ['4 × 2⅛ × 1½ in device', 10.3],
            'device_4_218_178' => ['4 × 2⅛ × 1⅞ in device', 13.0],
            'device_4_218_218' => ['4 × 2⅛ × 2⅛ in device', 14.5],
            'masonry_334_2_212' => ['3¾ × 2 × 2½ in masonry box', 14.0],
            'masonry_334_2_312' => ['3¾ × 2 × 3½ in masonry box', 21.0],
        ],
    ],

    // Bolt strength. SAE J429 grades (inch): proof and minimum tensile strength in psi by diameter range (in).
    // ISO 898-1 property classes (metric): proof stress and minimum tensile strength in MPa; class 8.8 is
    // higher above M16.
    'bolt_grades' => [
        'sae' => [
            'grade_2_small' => [
                'name' => 'SAE grade 2 (¼–¾ in)',
                'min' => 0.25,
                'max' => 0.75,
                'proof' => 55000,
                'tensile' => 74000,
            ],
            'grade_2_large' => [
                'name' => 'SAE grade 2 (⅞–1½ in)',
                'min' => 0.875,
                'max' => 1.5,
                'proof' => 33000,
                'tensile' => 60000,
            ],
            'grade_5_small' => [
                'name' => 'SAE grade 5 (¼–1 in)',
                'min' => 0.25,
                'max' => 1.0,
                'proof' => 85000,
                'tensile' => 120000,
            ],
            'grade_5_large' => [
                'name' => 'SAE grade 5 (1⅛–1½ in)',
                'min' => 1.125,
                'max' => 1.5,
                'proof' => 74000,
                'tensile' => 105000,
            ],
            'grade_8' => [
                'name' => 'SAE grade 8 (¼–1½ in)',
                'min' => 0.25,
                'max' => 1.5,
                'proof' => 120000,
                'tensile' => 150000,
            ],
        ],
        'iso' => [
            '4.6' => [
                'proof' => 225,
                'tensile' => 400,
            ],
            '4.8' => [
                'proof' => 310,
                'tensile' => 420,
            ],
            '5.8' => [
                'proof' => 380,
                'tensile' => 520,
            ],
            '8.8' => [
                'proof' => 580,
                'tensile' => 800,
                'proof_large' => 600,
                'tensile_large' => 830,
            ],
            '9.8' => [
                'proof' => 650,
                'tensile' => 900,
            ],
            '10.9' => [
                'proof' => 830,
                'tensile' => 1040,
            ],
            '12.9' => [
                'proof' => 970,
                'tensile' => 1220,
            ],
        ],
    ],

    // Unified inch screw threads (ASME B1.1): major diameter (in) and threads per inch for UNC and UNF.
    // Tap drills for about 75% thread and clearance drills (close and free fit) from the Little Machine Shop
    // tap drill and clearance chart.
    'threads_inch' => [
        '#0' => [
            'major' => 0.06,
            'unc' => null,
            'unf' => 80,
            'tap_drill' => [
                'drill' => '3/64',
                'diameter' => 0.0469,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '52',
                    'diameter' => 0.0635,
                ],
                'free' => [
                    'drill' => '50',
                    'diameter' => 0.07,
                ],
            ],
        ],
        '#1' => [
            'major' => 0.073,
            'unc' => 64,
            'unf' => 72,
            'tap_drill' => [
                'drill' => '53',
                'diameter' => 0.0595,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '48',
                    'diameter' => 0.076,
                ],
                'free' => [
                    'drill' => '46',
                    'diameter' => 0.081,
                ],
            ],
        ],
        '#2' => [
            'major' => 0.086,
            'unc' => 56,
            'unf' => 64,
            'tap_drill' => [
                'drill' => '50',
                'diameter' => 0.07,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '43',
                    'diameter' => 0.089,
                ],
                'free' => [
                    'drill' => '41',
                    'diameter' => 0.096,
                ],
            ],
        ],
        '#3' => [
            'major' => 0.099,
            'unc' => 48,
            'unf' => 56,
            'tap_drill' => [
                'drill' => '47',
                'diameter' => 0.0785,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '37',
                    'diameter' => 0.104,
                ],
                'free' => [
                    'drill' => '35',
                    'diameter' => 0.11,
                ],
            ],
        ],
        '#4' => [
            'major' => 0.112,
            'unc' => 40,
            'unf' => 48,
            'tap_drill' => [
                'drill' => '43',
                'diameter' => 0.089,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '32',
                    'diameter' => 0.116,
                ],
                'free' => [
                    'drill' => '30',
                    'diameter' => 0.1285,
                ],
            ],
        ],
        '#5' => [
            'major' => 0.125,
            'unc' => 40,
            'unf' => 44,
            'tap_drill' => [
                'drill' => '38',
                'diameter' => 0.1015,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '30',
                    'diameter' => 0.1285,
                ],
                'free' => [
                    'drill' => '29',
                    'diameter' => 0.136,
                ],
            ],
        ],
        '#6' => [
            'major' => 0.138,
            'unc' => 32,
            'unf' => 40,
            'tap_drill' => [
                'drill' => '36',
                'diameter' => 0.1065,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '27',
                    'diameter' => 0.144,
                ],
                'free' => [
                    'drill' => '25',
                    'diameter' => 0.1495,
                ],
            ],
        ],
        '#8' => [
            'major' => 0.164,
            'unc' => 32,
            'unf' => 36,
            'tap_drill' => [
                'drill' => '29',
                'diameter' => 0.136,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '18',
                    'diameter' => 0.1695,
                ],
                'free' => [
                    'drill' => '16',
                    'diameter' => 0.177,
                ],
            ],
        ],
        '#10' => [
            'major' => 0.19,
            'unc' => 24,
            'unf' => 32,
            'tap_drill' => [
                'drill' => '25',
                'diameter' => 0.1495,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '9',
                    'diameter' => 0.196,
                ],
                'free' => [
                    'drill' => '7',
                    'diameter' => 0.201,
                ],
            ],
        ],
        '#12' => [
            'major' => 0.216,
            'unc' => 24,
            'unf' => 28,
            'tap_drill' => [
                'drill' => '16',
                'diameter' => 0.177,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '2',
                    'diameter' => 0.221,
                ],
                'free' => [
                    'drill' => '1',
                    'diameter' => 0.228,
                ],
            ],
        ],
        '1/4' => [
            'major' => 0.25,
            'unc' => 20,
            'unf' => 28,
            'tap_drill' => [
                'drill' => '7',
                'diameter' => 0.201,
            ],
            'clearance' => [
                'close' => [
                    'drill' => 'F',
                    'diameter' => 0.257,
                ],
                'free' => [
                    'drill' => 'H',
                    'diameter' => 0.266,
                ],
            ],
        ],
        '5/16' => [
            'major' => 0.3125,
            'unc' => 18,
            'unf' => 24,
            'tap_drill' => [
                'drill' => 'F',
                'diameter' => 0.257,
            ],
            'clearance' => [
                'close' => [
                    'drill' => 'P',
                    'diameter' => 0.323,
                ],
                'free' => [
                    'drill' => 'Q',
                    'diameter' => 0.332,
                ],
            ],
        ],
        '3/8' => [
            'major' => 0.375,
            'unc' => 16,
            'unf' => 24,
            'tap_drill' => [
                'drill' => '5/16',
                'diameter' => 0.3125,
            ],
            'clearance' => [
                'close' => [
                    'drill' => 'W',
                    'diameter' => 0.386,
                ],
                'free' => [
                    'drill' => 'X',
                    'diameter' => 0.397,
                ],
            ],
        ],
        '7/16' => [
            'major' => 0.4375,
            'unc' => 14,
            'unf' => 20,
            'tap_drill' => [
                'drill' => 'U',
                'diameter' => 0.368,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '29/64',
                    'diameter' => 0.4531,
                ],
                'free' => [
                    'drill' => '15/32',
                    'diameter' => 0.4687,
                ],
            ],
        ],
        '1/2' => [
            'major' => 0.5,
            'unc' => 13,
            'unf' => 20,
            'tap_drill' => [
                'drill' => '27/64',
                'diameter' => 0.4219,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '33/64',
                    'diameter' => 0.5156,
                ],
                'free' => [
                    'drill' => '17/32',
                    'diameter' => 0.5312,
                ],
            ],
        ],
        '9/16' => [
            'major' => 0.5625,
            'unc' => 12,
            'unf' => 18,
            'tap_drill' => [
                'drill' => '31/64',
                'diameter' => 0.4844,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '37/64',
                    'diameter' => 0.5781,
                ],
                'free' => [
                    'drill' => '19/32',
                    'diameter' => 0.5938,
                ],
            ],
        ],
        '5/8' => [
            'major' => 0.625,
            'unc' => 11,
            'unf' => 18,
            'tap_drill' => [
                'drill' => '17/32',
                'diameter' => 0.5312,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '41/64',
                    'diameter' => 0.6406,
                ],
                'free' => [
                    'drill' => '21/32',
                    'diameter' => 0.6562,
                ],
            ],
        ],
        '3/4' => [
            'major' => 0.75,
            'unc' => 10,
            'unf' => 16,
            'tap_drill' => [
                'drill' => '21/32',
                'diameter' => 0.6562,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '49/64',
                    'diameter' => 0.7656,
                ],
                'free' => [
                    'drill' => '25/32',
                    'diameter' => 0.7812,
                ],
            ],
        ],
        '7/8' => [
            'major' => 0.875,
            'unc' => 9,
            'unf' => 14,
            'tap_drill' => [
                'drill' => '49/64',
                'diameter' => 0.7656,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '57/64',
                    'diameter' => 0.8906,
                ],
                'free' => [
                    'drill' => '29/32',
                    'diameter' => 0.9062,
                ],
            ],
        ],
        '1' => [
            'major' => 1.0,
            'unc' => 8,
            'unf' => 12,
            'tap_drill' => [
                'drill' => '7/8',
                'diameter' => 0.875,
            ],
            'clearance' => [
                'close' => [
                    'drill' => '1-1/64',
                    'diameter' => 1.0156,
                ],
                'free' => [
                    'drill' => '1-1/32',
                    'diameter' => 1.0313,
                ],
            ],
        ],
        '1-1/8' => [
            'major' => 1.125,
            'unc' => 7,
            'unf' => 12,
        ],
        '1-1/4' => [
            'major' => 1.25,
            'unc' => 7,
            'unf' => 12,
        ],
        '1-3/8' => [
            'major' => 1.375,
            'unc' => 6,
            'unf' => 12,
        ],
        '1-1/2' => [
            'major' => 1.5,
            'unc' => 6,
            'unf' => 12,
        ],
        '1-3/4' => [
            'major' => 1.75,
            'unc' => 5,
            'unf' => null,
        ],
        '2' => [
            'major' => 2.0,
            'unc' => 4.5,
            'unf' => null,
        ],
    ],

    // ISO metric screw threads (ISO 261/262): nominal diameter and coarse and preferred fine pitch in mm.
    // Clearance holes in mm for the fine, medium and coarse series of ISO 273.
    'threads_metric' => [
        'M1' => [
            'major' => 1,
            'coarse' => 0.25,
            'fine' => 0.2,
            'clearance' => [
                'fine' => 1.1,
                'medium' => 1.2,
                'coarse' => 1.3,
            ],
        ],
        'M1.2' => [
            'major' => 1.2,
            'coarse' => 0.25,
            'fine' => 0.2,
            'clearance' => [
                'fine' => 1.3,
                'medium' => 1.4,
                'coarse' => 1.5,
            ],
        ],
        'M1.4' => [
            'major' => 1.4,
            'coarse' => 0.3,
            'fine' => 0.2,
            'clearance' => [
                'fine' => 1.5,
                'medium' => 1.6,
                'coarse' => 1.8,
            ],
        ],
        'M1.6' => [
            'major' => 1.6,
            'coarse' => 0.35,
            'fine' => 0.2,
            'clearance' => [
                'fine' => 1.7,
                'medium' => 1.8,
                'coarse' => 2.0,
            ],
        ],
        'M2' => [
            'major' => 2,
            'coarse' => 0.4,
            'fine' => 0.25,
            'clearance' => [
                'fine' => 2.2,
                'medium' => 2.4,
                'coarse' => 2.6,
            ],
        ],
        'M2.5' => [
            'major' => 2.5,
            'coarse' => 0.45,
            'fine' => 0.35,
            'clearance' => [
                'fine' => 2.7,
                'medium' => 2.9,
                'coarse' => 3.1,
            ],
        ],
        'M3' => [
            'major' => 3,
            'coarse' => 0.5,
            'fine' => 0.35,
            'clearance' => [
                'fine' => 3.2,
                'medium' => 3.4,
                'coarse' => 3.6,
            ],
        ],
        'M3.5' => [
            'major' => 3.5,
            'coarse' => 0.6,
            'fine' => 0.35,
            'clearance' => [
                'fine' => 3.7,
                'medium' => 3.9,
                'coarse' => 4.2,
            ],
        ],
        'M4' => [
            'major' => 4,
            'coarse' => 0.7,
            'fine' => 0.5,
            'clearance' => [
                'fine' => 4.3,
                'medium' => 4.5,
                'coarse' => 4.8,
            ],
        ],
        'M5' => [
            'major' => 5,
            'coarse' => 0.8,
            'fine' => 0.5,
            'clearance' => [
                'fine' => 5.3,
                'medium' => 5.5,
                'coarse' => 5.8,
            ],
        ],
        'M6' => [
            'major' => 6,
            'coarse' => 1.0,
            'fine' => 0.75,
            'clearance' => [
                'fine' => 6.4,
                'medium' => 6.6,
                'coarse' => 7.0,
            ],
        ],
        'M8' => [
            'major' => 8,
            'coarse' => 1.25,
            'fine' => 1.0,
            'clearance' => [
                'fine' => 8.4,
                'medium' => 9.0,
                'coarse' => 10.0,
            ],
        ],
        'M10' => [
            'major' => 10,
            'coarse' => 1.5,
            'fine' => 1.25,
            'clearance' => [
                'fine' => 10.5,
                'medium' => 11.0,
                'coarse' => 12.0,
            ],
        ],
        'M12' => [
            'major' => 12,
            'coarse' => 1.75,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 13.0,
                'medium' => 13.5,
                'coarse' => 14.5,
            ],
        ],
        'M14' => [
            'major' => 14,
            'coarse' => 2.0,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 15.0,
                'medium' => 15.5,
                'coarse' => 16.5,
            ],
        ],
        'M16' => [
            'major' => 16,
            'coarse' => 2.0,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 17.0,
                'medium' => 17.5,
                'coarse' => 18.5,
            ],
        ],
        'M18' => [
            'major' => 18,
            'coarse' => 2.5,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 19.0,
                'medium' => 20.0,
                'coarse' => 21.0,
            ],
        ],
        'M20' => [
            'major' => 20,
            'coarse' => 2.5,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 21.0,
                'medium' => 22.0,
                'coarse' => 24.0,
            ],
        ],
        'M22' => [
            'major' => 22,
            'coarse' => 2.5,
            'fine' => 1.5,
            'clearance' => [
                'fine' => 23.0,
                'medium' => 24.0,
                'coarse' => 26.0,
            ],
        ],
        'M24' => [
            'major' => 24,
            'coarse' => 3.0,
            'fine' => 2.0,
            'clearance' => [
                'fine' => 25.0,
                'medium' => 26.0,
                'coarse' => 28.0,
            ],
        ],
        'M27' => [
            'major' => 27,
            'coarse' => 3.0,
            'fine' => 2.0,
            'clearance' => [
                'fine' => 28.0,
                'medium' => 30.0,
                'coarse' => 32.0,
            ],
        ],
        'M30' => [
            'major' => 30,
            'coarse' => 3.5,
            'fine' => 2.0,
            'clearance' => [
                'fine' => 31.0,
                'medium' => 33.0,
                'coarse' => 35.0,
            ],
        ],
        'M33' => [
            'major' => 33,
            'coarse' => 3.5,
            'fine' => 2.0,
            'clearance' => [
                'fine' => 34.0,
                'medium' => 36.0,
                'coarse' => 38.0,
            ],
        ],
        'M36' => [
            'major' => 36,
            'coarse' => 4.0,
            'fine' => 3.0,
            'clearance' => [
                'fine' => 37.0,
                'medium' => 39.0,
                'coarse' => 42.0,
            ],
        ],
        'M39' => [
            'major' => 39,
            'coarse' => 4.0,
            'fine' => 3.0,
            'clearance' => [
                'fine' => 40.0,
                'medium' => 42.0,
                'coarse' => 45.0,
            ],
        ],
        'M42' => [
            'major' => 42,
            'coarse' => 4.5,
            'fine' => 3.0,
            'clearance' => [
                'fine' => 43.0,
                'medium' => 45.0,
                'coarse' => 48.0,
            ],
        ],
    ],

    // Insulation R-value per inch (ft²·°F·h/Btu per inch), typical ranges from the PNNL Building America
    // Solution Center table "Typical R-values and vapor retarder classifications of common insulation materials".
    'insulation' => [
        'fiberglass' => [
            'name' => 'Fiberglass batt or board',
            'low' => 2.5,
            'high' => 4.0,
        ],
        'mineral_wool' => [
            'name' => 'Mineral wool board',
            'low' => 3.0,
            'high' => 4.0,
        ],
        'eps' => [
            'name' => 'Expanded polystyrene (EPS)',
            'low' => 3.8,
            'high' => 4.4,
        ],
        'xps' => [
            'name' => 'Extruded polystyrene (XPS)',
            'low' => 5.0,
            'high' => 5.0,
        ],
        'polyiso' => [
            'name' => 'Polyisocyanurate board',
            'low' => 6.0,
            'high' => 6.0,
        ],
        'spf_closed' => [
            'name' => 'Closed-cell spray foam (high density)',
            'low' => 6.0,
            'high' => 6.0,
        ],
    ],

    // Aluminum alloy typical shear strength, psi (Aluminum Association, Aluminum Standards and Data).
    // Steels use 80% of the specified minimum tensile strength, a common press-tool convention.
    'shear' => [
        'mild_steel' => [
            'name' => 'Mild steel A36 (0.8 × 58 ksi)',
            'psi' => 46400,
        ],
        'steel_1018' => [
            'name' => 'Cold-rolled steel 1018 (0.8 × 63.8 ksi)',
            'psi' => 51000,
        ],
        'stainless_304' => [
            'name' => 'Stainless 304 annealed (0.8 × 75 ksi)',
            'psi' => 60000,
        ],
        'al_1100_h14' => [
            'name' => 'Aluminum 1100-H14',
            'psi' => 11000,
        ],
        'al_3003_h14' => [
            'name' => 'Aluminum 3003-H14',
            'psi' => 14000,
        ],
        'al_5052_h32' => [
            'name' => 'Aluminum 5052-H32',
            'psi' => 20000,
        ],
        'al_6061_t6' => [
            'name' => 'Aluminum 6061-T6',
            'psi' => 30000,
        ],
    ],

    // Premixed concrete and mortar bag yields as printed on US bags (ft³ per bag), and cement bag sizes.
    'bags' => [
        'concrete' => [
            '80' => 0.6,
            '60' => 0.45,
            '50' => 0.375,
            '40' => 0.3,
        ],
        'cement' => [
            'us_94' => [
                'name' => 'US portland cement, 94 lb (1 ft³)',
                'kg' => 42.638,
                'ft3' => 1.0,
            ],
            'kg_50' => [
                'name' => '50 kg bag (0.0347 m³)',
                'kg' => 50.0,
                'ft3' => 1.2253,
            ],
            'kg_25' => [
                'name' => '25 kg bag',
                'kg' => 25.0,
                'ft3' => 0.6127,
            ],
        ],
    ],

    // Mortar proportions by volume, ASTM C270 proportion specification: portland cement : hydrated lime,
    // with sand at 3 times the cementitious volume (the specification allows 2¼ to 3 times).
    'mortar' => [
        'm' => [
            'name' => 'Type M',
            'cement' => 1,
            'lime' => 0.25,
        ],
        's' => [
            'name' => 'Type S',
            'cement' => 1,
            'lime' => 0.5,
        ],
        'n' => [
            'name' => 'Type N',
            'cement' => 1,
            'lime' => 1.0,
        ],
        'o' => [
            'name' => 'Type O',
            'cement' => 1,
            'lime' => 2.0,
        ],
    ],

    // Masonry units, actual size in inches as [length, height, width]: Brick Industry Association Technical
    // Note 10 (brick) and ASTM C90 standard 16 × 8 in hollow concrete masonry units (actual 15⅝ × 7⅝ in).
    'units' => [
        'modular' => [
            'name' => 'Modular brick',
            'size' => [7.625, 2.25, 3.625],
        ],
        'standard' => [
            'name' => 'Standard (non-modular) brick',
            'size' => [8.0, 2.25, 3.625],
        ],
        'engineer_modular' => [
            'name' => 'Engineer modular brick',
            'size' => [7.625, 2.8125, 3.625],
        ],
        'closure_modular' => [
            'name' => 'Closure modular brick',
            'size' => [7.625, 3.625, 3.625],
        ],
        'norman' => [
            'name' => 'Norman brick',
            'size' => [11.625, 2.25, 3.625],
        ],
        'roman' => [
            'name' => 'Roman brick',
            'size' => [11.625, 1.625, 3.625],
        ],
        'utility' => [
            'name' => 'Utility brick',
            'size' => [11.625, 3.625, 3.625],
        ],
        'queen' => [
            'name' => 'Queen brick',
            'size' => [8.0, 2.75, 3.0],
        ],
        'king' => [
            'name' => 'King brick',
            'size' => [9.625, 2.625, 3.0],
        ],
        'cmu_6' => [
            'name' => '6 in concrete block',
            'size' => [15.625, 7.625, 5.625],
            'hollow' => true,
        ],
        'cmu_8' => [
            'name' => '8 in concrete block',
            'size' => [15.625, 7.625, 7.625],
            'hollow' => true,
        ],
        'cmu_10' => [
            'name' => '10 in concrete block',
            'size' => [15.625, 7.625, 9.625],
            'hollow' => true,
        ],
        'cmu_12' => [
            'name' => '12 in concrete block',
            'size' => [15.625, 7.625, 11.625],
            'hollow' => true,
        ],
    ],

    // Thin-set mortar coverage per 50 lb bag in ft² by square-notch trowel: Custom Building Products technical
    // data sheets (VersaBond TDS-119, CustomBlend TDS-191, MultiSet TDS-192).
    'trowels' => [
        '1/4x1/4' => [
            'name' => '¼ × ¼ in square notch',
            'min' => 85,
            'max' => 95,
        ],
        '1/4x3/8' => [
            'name' => '¼ × ⅜ in square notch',
            'min' => 60,
            'max' => 67,
        ],
    ],
];
