<?php

/*
|--------------------------------------------------------------------------
| Statistics reference data
|--------------------------------------------------------------------------
|
| Read by the Statistics section tools (resources/js/calc/tools/st-*.js) through
| the page's `data` config. Distribution tables (z, t, χ², F) are computed by
| resources/js/calc/statistics/special.js, not stored. Each block names its source.
|
*/

return [

    /*
    | Lottery formats: pick k numbers from 1–n, plus k2 bonus numbers from 1–n2. Jackpot
    | odds computed from these match each operator's published figure (Powerball
    | 1 in 292,201,338; Mega Millions 1 in 290,472,336 since 8 April 2025; EuroMillions and
    | Eurojackpot 1 in 139,838,160; UK Lotto 1 in 45,057,474; Lotto 6/49 1 in 13,983,816).
    */
    'lotteries' => [
        'powerball' => ['name' => 'Powerball (US): 5 of 69 + 1 of 26', 'k' => 5, 'n' => 69, 'k2' => 1, 'n2' => 26, 'source' => 'Multi-State Lottery Association, matrix since October 2015'],
        'mega_millions' => ['name' => 'Mega Millions (US): 5 of 70 + 1 of 24', 'k' => 5, 'n' => 70, 'k2' => 1, 'n2' => 24, 'source' => 'Mega Millions consortium, matrix since 8 April 2025'],
        'euromillions' => ['name' => 'EuroMillions: 5 of 50 + 2 of 12', 'k' => 5, 'n' => 50, 'k2' => 2, 'n2' => 12, 'source' => 'EuroMillions rules, matrix since September 2016'],
        'eurojackpot' => ['name' => 'Eurojackpot: 5 of 50 + 2 of 12', 'k' => 5, 'n' => 50, 'k2' => 2, 'n2' => 12, 'source' => 'Eurojackpot rules, matrix since March 2022'],
        'uk_lotto' => ['name' => 'UK Lotto: 6 of 59', 'k' => 6, 'n' => 59, 'k2' => 0, 'n2' => 0, 'source' => 'The National Lottery (UK), matrix since October 2015; the bonus ball only matters for the 5 + bonus prize'],
        'lotto_649' => ['name' => 'Lotto 6/49 (Canada and others): 6 of 49', 'k' => 6, 'n' => 49, 'k2' => 0, 'n2' => 0, 'source' => 'Interprovincial Lottery Corporation (Canada) 6/49 matrix'],
    ],

    /*
    | Shewhart control-chart constants for subgroup size n (2–25). Computed from the normal
    | distribution: c4 = √(2/(n − 1)) Γ(n/2)/Γ((n − 1)/2); d2 and d3 are the mean and standard
    | deviation of the range of n standard normals (numerical integration); A2 = 3/(d2√n),
    | A3 = 3/(c4√n), D3/D4 = 1 ∓ 3d3/d2, B3/B4 = 1 ∓ 3√(1 − c4²)/c4 (lower limits floored at 0).
    | Agree with ASTM E2587 and Montgomery, Introduction to Statistical Quality Control,
    | Appendix VI, to the printed decimals.
    */
    'control_charts' => [
        2 => ['A2' => 1.8800, 'A3' => 2.6587, 'c4' => 0.7979, 'd2' => 1.1284, 'd3' => 0.8525, 'D3' => 0.0000, 'D4' => 3.2665, 'B3' => 0.0000, 'B4' => 3.2665],
        3 => ['A2' => 1.0233, 'A3' => 1.9544, 'c4' => 0.8862, 'd2' => 1.6926, 'd3' => 0.8884, 'D3' => 0.0000, 'D4' => 2.5746, 'B3' => 0.0000, 'B4' => 2.5682],
        4 => ['A2' => 0.7286, 'A3' => 1.6281, 'c4' => 0.9213, 'd2' => 2.0588, 'd3' => 0.8798, 'D3' => 0.0000, 'D4' => 2.2821, 'B3' => 0.0000, 'B4' => 2.2660],
        5 => ['A2' => 0.5768, 'A3' => 1.4273, 'c4' => 0.9400, 'd2' => 2.3259, 'd3' => 0.8641, 'D3' => 0.0000, 'D4' => 2.1145, 'B3' => 0.0000, 'B4' => 2.0890],
        6 => ['A2' => 0.4832, 'A3' => 1.2871, 'c4' => 0.9515, 'd2' => 2.5344, 'd3' => 0.8480, 'D3' => 0.0000, 'D4' => 2.0038, 'B3' => 0.0304, 'B4' => 1.9696],
        7 => ['A2' => 0.4193, 'A3' => 1.1819, 'c4' => 0.9594, 'd2' => 2.7044, 'd3' => 0.8332, 'D3' => 0.0757, 'D4' => 1.9243, 'B3' => 0.1177, 'B4' => 1.8823],
        8 => ['A2' => 0.3725, 'A3' => 1.0991, 'c4' => 0.9650, 'd2' => 2.8472, 'd3' => 0.8198, 'D3' => 0.1362, 'D4' => 1.8638, 'B3' => 0.1851, 'B4' => 1.8149],
        9 => ['A2' => 0.3367, 'A3' => 1.0317, 'c4' => 0.9693, 'd2' => 2.9700, 'd3' => 0.8078, 'D3' => 0.1840, 'D4' => 1.8160, 'B3' => 0.2391, 'B4' => 1.7609],
        10 => ['A2' => 0.3083, 'A3' => 0.9754, 'c4' => 0.9727, 'd2' => 3.0775, 'd3' => 0.7971, 'D3' => 0.2230, 'D4' => 1.7770, 'B3' => 0.2837, 'B4' => 1.7163],
        11 => ['A2' => 0.2851, 'A3' => 0.9274, 'c4' => 0.9754, 'd2' => 3.1729, 'd3' => 0.7873, 'D3' => 0.2556, 'D4' => 1.7444, 'B3' => 0.3213, 'B4' => 1.6787],
        12 => ['A2' => 0.2658, 'A3' => 0.8859, 'c4' => 0.9776, 'd2' => 3.2585, 'd3' => 0.7785, 'D3' => 0.2833, 'D4' => 1.7167, 'B3' => 0.3535, 'B4' => 1.6465],
        13 => ['A2' => 0.2494, 'A3' => 0.8495, 'c4' => 0.9794, 'd2' => 3.3360, 'd3' => 0.7704, 'D3' => 0.3072, 'D4' => 1.6928, 'B3' => 0.3816, 'B4' => 1.6184],
        14 => ['A2' => 0.2354, 'A3' => 0.8173, 'c4' => 0.9810, 'd2' => 3.4068, 'd3' => 0.7630, 'D3' => 0.3281, 'D4' => 1.6719, 'B3' => 0.4062, 'B4' => 1.5938],
        15 => ['A2' => 0.2231, 'A3' => 0.7885, 'c4' => 0.9823, 'd2' => 3.4718, 'd3' => 0.7562, 'D3' => 0.3466, 'D4' => 1.6534, 'B3' => 0.4282, 'B4' => 1.5718],
        16 => ['A2' => 0.2123, 'A3' => 0.7626, 'c4' => 0.9835, 'd2' => 3.5320, 'd3' => 0.7499, 'D3' => 0.3630, 'D4' => 1.6370, 'B3' => 0.4479, 'B4' => 1.5521],
        17 => ['A2' => 0.2028, 'A3' => 0.7391, 'c4' => 0.9845, 'd2' => 3.5879, 'd3' => 0.7441, 'D3' => 0.3779, 'D4' => 1.6221, 'B3' => 0.4657, 'B4' => 1.5343],
        18 => ['A2' => 0.1943, 'A3' => 0.7176, 'c4' => 0.9854, 'd2' => 3.6401, 'd3' => 0.7386, 'D3' => 0.3913, 'D4' => 1.6087, 'B3' => 0.4818, 'B4' => 1.5182],
        19 => ['A2' => 0.1866, 'A3' => 0.6979, 'c4' => 0.9862, 'd2' => 3.6890, 'd3' => 0.7335, 'D3' => 0.4035, 'D4' => 1.5965, 'B3' => 0.4966, 'B4' => 1.5034],
        20 => ['A2' => 0.1796, 'A3' => 0.6797, 'c4' => 0.9869, 'd2' => 3.7350, 'd3' => 0.7287, 'D3' => 0.4147, 'D4' => 1.5853, 'B3' => 0.5102, 'B4' => 1.4898],
        21 => ['A2' => 0.1733, 'A3' => 0.6629, 'c4' => 0.9876, 'd2' => 3.7783, 'd3' => 0.7242, 'D3' => 0.4250, 'D4' => 1.5750, 'B3' => 0.5228, 'B4' => 1.4772],
        22 => ['A2' => 0.1675, 'A3' => 0.6473, 'c4' => 0.9882, 'd2' => 3.8194, 'd3' => 0.7199, 'D3' => 0.4345, 'D4' => 1.5655, 'B3' => 0.5344, 'B4' => 1.4656],
        23 => ['A2' => 0.1621, 'A3' => 0.6327, 'c4' => 0.9887, 'd2' => 3.8583, 'd3' => 0.7159, 'D3' => 0.4434, 'D4' => 1.5566, 'B3' => 0.5452, 'B4' => 1.4548],
        24 => ['A2' => 0.1572, 'A3' => 0.6191, 'c4' => 0.9892, 'd2' => 3.8953, 'd3' => 0.7121, 'D3' => 0.4516, 'D4' => 1.5484, 'B3' => 0.5553, 'B4' => 1.4447],
        25 => ['A2' => 0.1526, 'A3' => 0.6063, 'c4' => 0.9896, 'd2' => 3.9306, 'd3' => 0.7084, 'D3' => 0.4593, 'D4' => 1.5407, 'B3' => 0.5648, 'B4' => 1.4352],
    ],

    /*
    | Benford first-digit conformity by mean absolute deviation (MAD) between observed and
    | Benford proportions (first-digit test): Mark Nigrini, Benford's Law: Applications for
    | Forensic Accounting, Auditing, and Fraud Detection (Wiley, 2012).
    */
    'benford_mad' => [
        ['max' => 0.006, 'name' => 'Close conformity'],
        ['max' => 0.012, 'name' => 'Acceptable conformity'],
        ['max' => 0.015, 'name' => 'Marginally acceptable conformity'],
        ['max' => null, 'name' => 'Nonconformity'],
    ],

];
