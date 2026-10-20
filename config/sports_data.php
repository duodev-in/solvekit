<?php

/*
|--------------------------------------------------------------------------
| Sports reference data
|--------------------------------------------------------------------------
|
| Read by the Sports section tools (resources/js/calc/tools/sp-*.js) through
| the page's `data` config. Each block names its source.
|
*/

return [

    /*
    | MET values (metabolic equivalents) from the Compendium of Physical Activities
    | (Ainsworth et al., Med Sci Sports Exerc 2011; 43(8):1575–81), with the activity
    | code. Energy per minute = MET × 3.5 × body mass (kg) ÷ 200 kcal.
    */
    'mets' => [
        'run_5' => ['name' => 'Running, 5 mph (8.0 km/h)', 'met' => 8.3, 'code' => '12030'],
        'run_6' => ['name' => 'Running, 6 mph (9.7 km/h)', 'met' => 9.8, 'code' => '12050'],
        'run_7' => ['name' => 'Running, 7 mph (11.3 km/h)', 'met' => 11.0, 'code' => '12070'],
        'run_8' => ['name' => 'Running, 8 mph (12.9 km/h)', 'met' => 11.8, 'code' => '12090'],
        'run_10' => ['name' => 'Running, 10 mph (16.1 km/h)', 'met' => 14.5, 'code' => '12120'],
        'bike_10' => ['name' => 'Cycling, leisure, under 10 mph', 'met' => 4.0, 'code' => '01010'],
        'bike_12' => ['name' => 'Cycling, 10–11.9 mph, light', 'met' => 6.8, 'code' => '01040'],
        'bike_14' => ['name' => 'Cycling, 12–13.9 mph, moderate', 'met' => 8.0, 'code' => '01050'],
        'bike_16' => ['name' => 'Cycling, 14–15.9 mph, vigorous', 'met' => 10.0, 'code' => '01060'],
        'bike_20' => ['name' => 'Cycling, 16–19 mph, racing', 'met' => 12.0, 'code' => '01065'],
        'bike_fast' => ['name' => 'Cycling, over 20 mph, racing', 'met' => 15.8, 'code' => '01070'],
        'swim_free_light' => ['name' => 'Swimming, freestyle, light or moderate effort', 'met' => 5.8, 'code' => '18240'],
        'swim_free_fast' => ['name' => 'Swimming, freestyle, fast and vigorous', 'met' => 9.8, 'code' => '18230'],
        'swim_back' => ['name' => 'Swimming, backstroke, general', 'met' => 4.8, 'code' => '18250'],
        'swim_breast' => ['name' => 'Swimming, breaststroke, general', 'met' => 5.3, 'code' => '18265'],
        'swim_fly' => ['name' => 'Swimming, butterfly, general', 'met' => 13.8, 'code' => '18270'],
        'swim_leisure' => ['name' => 'Swimming, leisurely, not laps', 'met' => 6.0, 'code' => '18310'],
        'elliptical' => ['name' => 'Elliptical trainer, moderate effort', 'met' => 5.0, 'code' => '02048'],
        'rope_slow' => ['name' => 'Rope jumping, slow (under 100 skips/min)', 'met' => 8.8, 'code' => '15552'],
        'rope_moderate' => ['name' => 'Rope jumping, moderate (100–120 skips/min)', 'met' => 11.8, 'code' => '15551'],
        'rope_fast' => ['name' => 'Rope jumping, fast (120–160 skips/min)', 'met' => 12.3, 'code' => '15550'],
        'calisthenics_vig' => ['name' => 'Calisthenics, vigorous (burpees, push-ups, jumping jacks)', 'met' => 8.0, 'code' => '02020'],
        'stairs_slow' => ['name' => 'Stair climbing, slow pace', 'met' => 4.0, 'code' => '17133'],
        'stairs_fast' => ['name' => 'Stair climbing, fast pace', 'met' => 8.8, 'code' => '17134'],
        'stair_machine' => ['name' => 'Stair-treadmill ergometer, general', 'met' => 9.0, 'code' => '02065'],
        'shovel_moderate' => ['name' => 'Shovelling snow by hand, moderate effort', 'met' => 5.3, 'code' => '05030'],
        'shovel_vigorous' => ['name' => 'Shovelling snow by hand, vigorous effort', 'met' => 7.5, 'code' => '05031'],
        'row_light' => ['name' => 'Rowing machine, light effort', 'met' => 4.8, 'code' => '02071'],
        'row_moderate' => ['name' => 'Rowing machine, moderate effort', 'met' => 7.0, 'code' => '02072'],
        'row_vigorous' => ['name' => 'Rowing machine, vigorous effort', 'met' => 8.5, 'code' => '02073'],
        'yoga_hatha' => ['name' => 'Yoga, hatha', 'met' => 2.5, 'code' => '02150'],
        'yoga_power' => ['name' => 'Yoga, power', 'met' => 4.0, 'code' => '02160'],
        'pilates' => ['name' => 'Pilates, general', 'met' => 3.0, 'code' => '02105'],
        'weights_light' => ['name' => 'Weight lifting, light or moderate effort', 'met' => 3.5, 'code' => '02054'],
        'weights_vigorous' => ['name' => 'Weight lifting, vigorous effort (power lifting, body building)', 'met' => 6.0, 'code' => '02052'],
        'soccer_casual' => ['name' => 'Football (soccer), casual', 'met' => 7.0, 'code' => '15610'],
        'soccer_comp' => ['name' => 'Football (soccer), competitive', 'met' => 10.0, 'code' => '15605'],
        'hiking' => ['name' => 'Hiking, cross country', 'met' => 6.0, 'code' => '17080'],
        'backpacking' => ['name' => 'Backpacking, general', 'met' => 7.0, 'code' => '17010'],
        'standing' => ['name' => 'Standing quietly', 'met' => 1.3, 'code' => '07040'],
        'sitting' => ['name' => 'Sitting quietly', 'met' => 1.3, 'code' => '07021'],
    ],

    /*
    | World Athletics combined-events scoring: points = INT(A × (B − T)^C) for running
    | events (T in seconds) and INT(A × (M − B)^C) for jumps (M in cm) and throws (M in m).
    | Source: IAAF Scoring Tables for Combined Events (2001 edition, still current).
    */
    'combined_events' => [
        'heptathlon' => [
            '200m' => ['name' => '200 m', 'type' => 'track', 'A' => 4.99087, 'B' => 42.5, 'C' => 1.81],
            '800m' => ['name' => '800 m', 'type' => 'track', 'A' => 0.11193, 'B' => 254, 'C' => 1.88],
            '100mh' => ['name' => '100 m hurdles', 'type' => 'track', 'A' => 9.23076, 'B' => 26.7, 'C' => 1.835],
            'hj' => ['name' => 'High jump', 'type' => 'jump', 'A' => 1.84523, 'B' => 75, 'C' => 1.348],
            'lj' => ['name' => 'Long jump', 'type' => 'jump', 'A' => 0.188807, 'B' => 210, 'C' => 1.41],
            'sp' => ['name' => 'Shot put', 'type' => 'throw', 'A' => 56.0211, 'B' => 1.5, 'C' => 1.05],
            'jt' => ['name' => 'Javelin', 'type' => 'throw', 'A' => 15.9803, 'B' => 3.8, 'C' => 1.04],
        ],
        'decathlon' => [
            '100m' => ['name' => '100 m', 'type' => 'track', 'A' => 25.4347, 'B' => 18, 'C' => 1.81],
            'lj' => ['name' => 'Long jump', 'type' => 'jump', 'A' => 0.14354, 'B' => 220, 'C' => 1.4],
            'sp' => ['name' => 'Shot put', 'type' => 'throw', 'A' => 51.39, 'B' => 1.5, 'C' => 1.05],
            'hj' => ['name' => 'High jump', 'type' => 'jump', 'A' => 0.8465, 'B' => 75, 'C' => 1.42],
            '400m' => ['name' => '400 m', 'type' => 'track', 'A' => 1.53775, 'B' => 82, 'C' => 1.81],
            '110mh' => ['name' => '110 m hurdles', 'type' => 'track', 'A' => 5.74352, 'B' => 28.5, 'C' => 1.92],
            'dt' => ['name' => 'Discus', 'type' => 'throw', 'A' => 12.91, 'B' => 4, 'C' => 1.1],
            'pv' => ['name' => 'Pole vault', 'type' => 'jump', 'A' => 0.2797, 'B' => 100, 'C' => 1.35],
            'jt' => ['name' => 'Javelin', 'type' => 'throw', 'A' => 10.14, 'B' => 7, 'C' => 1.08],
            '1500m' => ['name' => '1500 m', 'type' => 'track', 'A' => 0.03768, 'B' => 480, 'C' => 1.85],
        ],
    ],

    /*
    | Powerlifting scores. Wilks (Robert Wilks, original 1990s coefficients): 500 ÷ poly(bw).
    | DOTS (Tim Konertz, 2019): 500 ÷ (a·bw⁴ + b·bw³ + c·bw² + d·bw + e). IPF GL points
    | (IPF Goodlift formula, 2020): 100 ÷ (A − B·e^(−C·bw)). Body weight in kg.
    */
    'strength' => [
        'wilks' => [
            'male' => [-216.0475144, 16.2606339, -0.002388645, -0.00113732, 7.01863e-6, -1.291e-8],
            'female' => [594.31747775582, -27.23842536447, 0.82112226871, -0.00930733913, 4.731582e-5, -9.054e-8],
        ],
        'dots' => [
            'male' => [-0.000001093, 0.0007391293, -0.1918759221, 24.0900756, -307.75076],
            'female' => [-0.0000010706, 0.0005158568, -0.1126655495, 13.6175032, -57.96288],
        ],
        'ipf_gl' => [
            'classic_powerlifting' => ['name' => 'Classic (raw) powerlifting', 'male' => [1199.72839, 1025.18162, 0.00921], 'female' => [610.32796, 1045.59282, 0.03048]],
            'equipped_powerlifting' => ['name' => 'Equipped powerlifting', 'male' => [1236.25115, 1449.21864, 0.01644], 'female' => [758.63878, 949.31382, 0.02435]],
            'classic_bench' => ['name' => 'Classic bench press', 'male' => [320.98041, 281.40258, 0.01008], 'female' => [142.40398, 442.52671, 0.04724]],
            'equipped_bench' => ['name' => 'Equipped bench press', 'male' => [381.22073, 733.79378, 0.02398], 'female' => [221.82209, 357.00377, 0.02937]],
        ],
    ],

    /*
    | Tyre rolling circumference (mm) for bike computers, typical values from the CatEye
    | and Wahoo tyre-size charts. Real circumference varies with pressure and brand; measure
    | a roll-out for best accuracy.
    */
    'wheels' => [
        '700x23' => ['name' => '700 × 23c', 'mm' => 2096],
        '700x25' => ['name' => '700 × 25c', 'mm' => 2105],
        '700x28' => ['name' => '700 × 28c', 'mm' => 2136],
        '700x32' => ['name' => '700 × 32c', 'mm' => 2155],
        '700x38' => ['name' => '700 × 38c', 'mm' => 2180],
        '26x1.95' => ['name' => '26 × 1.95', 'mm' => 2050],
        '26x2.1' => ['name' => '26 × 2.1', 'mm' => 2068],
        '27.5x2.1' => ['name' => '27.5 × 2.1', 'mm' => 2148],
        '29x2.1' => ['name' => '29 × 2.1', 'mm' => 2288],
        '29x2.3' => ['name' => '29 × 2.3', 'mm' => 2326],
        '20x1.75' => ['name' => '20 × 1.75', 'mm' => 1515],
    ],

];
