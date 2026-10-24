<?php

/*
|--------------------------------------------------------------------------
| Other section reference data
|--------------------------------------------------------------------------
|
| Read by the Other section tools (resources/js/calc/tools/ot-*.js) through the
| page's `data` config. Each block names its source and date; values were checked
| against the source on 2026-10-20.
|
*/

return [

    /*
    | NMFC density-based freight classes, 13-subprovision scale of Docket 2025-1
    | (NMFTA, effective 19 July 2025), as published by carriers and 3PLs. min = lowest
    | density (lb/ft³) of the band. The final class depends on the commodity's NMFC item.
    */
    'freight_classes' => [
        ['min' => 50, 'class' => '50'], ['min' => 35, 'class' => '55'], ['min' => 30, 'class' => '60'], ['min' => 22.5, 'class' => '65'], ['min' => 15, 'class' => '70'],
        ['min' => 12, 'class' => '85'], ['min' => 10, 'class' => '92.5'], ['min' => 8, 'class' => '100'], ['min' => 6, 'class' => '125'], ['min' => 4, 'class' => '175'],
        ['min' => 2, 'class' => '250'], ['min' => 1, 'class' => '300'], ['min' => 0, 'class' => '400'],
    ],

    /*
    | Dimensional-weight divisors. FedEx and UPS daily rates 139 in³/lb (UPS retail 166);
    | metric lanes 5,000 cm³/kg; DHL Express 5,000 cm³/kg or 139 in³/lb (dct.dhl.com);
    | USPS 139 in³/lb from 12 July 2026 (39 CFR 111 final rule), applied only to parcels
    | over 1,728 in³. FedEx and UPS round each dimension up to a whole unit (since 18 Aug 2025).
    */
    'dim_divisors' => [
        'fedex_ups' => ['name' => 'FedEx / UPS daily rates (139 in³/lb)', 'in' => 139, 'cm' => 5000, 'threshold' => 0],
        'ups_retail' => ['name' => 'UPS retail rates (166 in³/lb)', 'in' => 166, 'cm' => 6000, 'threshold' => 0],
        'usps' => ['name' => 'USPS (139 in³/lb, parcels over 1 ft³)', 'in' => 139, 'cm' => 5000, 'threshold' => 1728],
        'dhl' => ['name' => 'DHL Express (5,000 cm³/kg)', 'in' => 139, 'cm' => 5000, 'threshold' => 0],
        'air_6000' => ['name' => 'Air freight / some couriers (6,000 cm³/kg)', 'in' => 166, 'cm' => 6000, 'threshold' => 0],
    ],

    /*
    | ISO shipping containers, inside dimensions (mm) and max payload (kg): Hapag-Lloyd
    | equipment pages (2026); individual boxes vary slightly by manufacturer.
    */
    'containers' => [
        '20' => ['name' => '20 ft standard', 'l' => 5900, 'w' => 2352, 'h' => 2395, 'payload' => 28130],
        '40' => ['name' => '40 ft standard', 'l' => 12032, 'w' => 2352, 'h' => 2395, 'payload' => 28750],
        '40hc' => ['name' => '40 ft High Cube', 'l' => 12032, 'w' => 2350, 'h' => 2700, 'payload' => 28600],
    ],

    /*
    | HEC Pakistan fractionalized grading, semester system (Policy Guidelines for the
    | Uniform Semester System, 2019 edition, §13.1): min % → letter, grade-point band
    | (lo–hi). gp is the single point value of each letter from HEC's earlier edition of the
    | guidelines, used when a course is entered by letter. A CGPA maps to the minimum % of its band.
    */
    'hec' => [
        ['min' => 85, 'grade' => 'A', 'gp' => 4.00, 'lo' => 3.67, 'hi' => 4.00], ['min' => 80, 'grade' => 'A-', 'gp' => 3.66, 'lo' => 3.34, 'hi' => 3.66], ['min' => 75, 'grade' => 'B+', 'gp' => 3.33, 'lo' => 3.01, 'hi' => 3.33],
        ['min' => 71, 'grade' => 'B', 'gp' => 3.00, 'lo' => 2.67, 'hi' => 3.00], ['min' => 68, 'grade' => 'B-', 'gp' => 2.66, 'lo' => 2.34, 'hi' => 2.66], ['min' => 64, 'grade' => 'C+', 'gp' => 2.33, 'lo' => 2.01, 'hi' => 2.33],
        ['min' => 61, 'grade' => 'C', 'gp' => 2.00, 'lo' => 1.67, 'hi' => 2.00], ['min' => 58, 'grade' => 'C-', 'gp' => 1.66, 'lo' => 1.31, 'hi' => 1.66], ['min' => 54, 'grade' => 'D+', 'gp' => 1.30, 'lo' => 1.01, 'hi' => 1.30],
        ['min' => 50, 'grade' => 'D', 'gp' => 1.00, 'lo' => 0.10, 'hi' => 1.00], ['min' => 0, 'grade' => 'F', 'gp' => 0, 'lo' => 0, 'hi' => 0],
    ],

    /*
    | IELTS raw score (out of 40) → band. Listening: IELTS Australia/IDP published table;
    | Academic and General Training Reading: tables consistent with the official anchor
    | points on ielts.org (15/23/30/35). All are averages that vary slightly by test version.
    */
    'ielts' => [
        'listening' => [[39, 9], [37, 8.5], [35, 8], [32, 7.5], [30, 7], [26, 6.5], [23, 6], [18, 5.5], [16, 5], [13, 4.5], [11, 4]],
        'academic' => [[39, 9], [37, 8.5], [35, 8], [33, 7.5], [30, 7], [27, 6.5], [23, 6], [19, 5.5], [15, 5], [13, 4.5], [10, 4], [8, 3.5], [6, 3], [4, 2.5]],
        'general' => [[40, 9], [39, 8.5], [37, 8], [36, 7.5], [34, 7], [32, 6.5], [30, 6], [27, 5.5], [23, 5], [19, 4.5], [15, 4], [12, 3.5], [9, 3]],
    ],

    /*
    | Pearson PTE Academic ↔ IELTS Academic overall concordance (pearsonpte.com/the-test/score,
    | research published July 2025): minimum PTE score for each IELTS band.
    */
    'pte_ielts' => [[90, 9.0], [86, 8.5], [79, 8.0], [71, 7.5], [63, 7.0], [55, 6.5], [47, 6.0], [39, 5.5], [31, 5.0], [24, 4.5]],

    /*
    | Rust (Facepunch) building decay: hours for a piece to decay fully once the tool
    | cupboard has none of that material (wiki.facepunch.com/rust/the_tool_cupboard;
    | server defaults decay.duration_*). Values can change with game updates.
    */
    'rust' => [
        'twig' => ['name' => 'Twig', 'hours' => 1], 'wood' => ['name' => 'Wood', 'hours' => 3], 'stone' => ['name' => 'Stone', 'hours' => 5],
        'metal' => ['name' => 'Sheet metal', 'hours' => 8], 'armored' => ['name' => 'Armored (high quality metal)', 'hours' => 12],
    ],

    /*
    | Average streaming payout per stream (USD): Duetti 2024 Music Economics Report (Jan 2025).
    | Blended averages; actual rates depend on country, subscription and contract.
    */
    'royalties' => [
        'amazon' => ['name' => 'Amazon Music', 'rate' => 0.0088], 'apple' => ['name' => 'Apple Music', 'rate' => 0.0062],
        'youtube' => ['name' => 'YouTube (all)', 'rate' => 0.0048], 'spotify' => ['name' => 'Spotify', 'rate' => 0.0030],
    ],

    /*
    | Oxygen cylinder conversion factors (litres per psi): JSOM Special Operations Medical
    | Guide 2023 (D, E, G, H/K) and AAOS Emergency Care, 9th ed. (M). Duration (min) =
    | (gauge psi − safe residual) × factor ÷ flow (L/min).
    */
    'oxygen' => [
        'd' => ['name' => 'D cylinder', 'factor' => 0.16], 'e' => ['name' => 'E cylinder', 'factor' => 0.28], 'm' => ['name' => 'M cylinder', 'factor' => 1.56],
        'g' => ['name' => 'G cylinder', 'factor' => 2.41], 'h' => ['name' => 'H / K cylinder', 'factor' => 3.14],
    ],

    /*
    | D&D 5e encounter building. 2014 rules (Basic Rules 2014, "Building Combat Encounters"):
    | XP thresholds per character [easy, medium, hard, deadly] and monster-count multipliers.
    | 2024 rules (SRD 5.2.1): XP budget per character [low, moderate, high]. Monster XP by
    | challenge rating from SRD 5.1.
    */
    'dnd_2014' => [
        1 => [25, 50, 75, 100], 2 => [50, 100, 150, 200], 3 => [75, 150, 225, 400], 4 => [125, 250, 375, 500], 5 => [250, 500, 750, 1100],
        6 => [300, 600, 900, 1400], 7 => [350, 750, 1100, 1700], 8 => [450, 900, 1400, 2100], 9 => [550, 1100, 1600, 2400], 10 => [600, 1200, 1900, 2800],
        11 => [800, 1600, 2400, 3600], 12 => [1000, 2000, 3000, 4500], 13 => [1100, 2200, 3400, 5100], 14 => [1250, 2500, 3800, 5700], 15 => [1400, 2800, 4300, 6400],
        16 => [1600, 3200, 4800, 7200], 17 => [2000, 3900, 5900, 8800], 18 => [2100, 4200, 6300, 9500], 19 => [2400, 4900, 7300, 10900], 20 => [2800, 5700, 8500, 12700],
    ],
    'dnd_multipliers' => [0.5, 1, 1.5, 2, 2.5, 3, 4, 5],
    'dnd_2024' => [
        1 => [50, 75, 100], 2 => [100, 150, 200], 3 => [150, 225, 400], 4 => [250, 375, 500], 5 => [500, 750, 1100],
        6 => [600, 1000, 1400], 7 => [750, 1300, 1700], 8 => [1000, 1700, 2100], 9 => [1300, 2000, 2600], 10 => [1600, 2300, 3100],
        11 => [1900, 2900, 4100], 12 => [2200, 3700, 4700], 13 => [2600, 4200, 5400], 14 => [2900, 4900, 6200], 15 => [3300, 5400, 7800],
        16 => [3800, 6100, 9800], 17 => [4500, 7200, 11700], 18 => [5000, 8700, 14200], 19 => [5500, 10700, 17200], 20 => [6400, 13200, 22000],
    ],
    'dnd_cr_xp' => [
        '0' => 10, '1/8' => 25, '1/4' => 50, '1/2' => 100, '1' => 200, '2' => 450, '3' => 700, '4' => 1100, '5' => 1800, '6' => 2300, '7' => 2900, '8' => 3900, '9' => 5000, '10' => 5900,
        '11' => 7200, '12' => 8400, '13' => 10000, '14' => 11500, '15' => 13000, '16' => 15000, '17' => 18000, '18' => 20000, '19' => 22000, '20' => 25000,
        '21' => 33000, '22' => 41000, '23' => 50000, '24' => 62000, '25' => 75000, '26' => 90000, '27' => 105000, '28' => 120000, '29' => 135000, '30' => 155000,
    ],

    /*
    | Minimal erythemal dose by Fitzpatrick skin type, mJ/cm² [low, high]: D'Orazio et al.,
    | Int J Mol Sci 2013, Table 1. 1 UV index = 25 mW/m² erythemal irradiance (WHO/WMO
    | Global Solar UV Index guide, 2002).
    */
    'med' => [
        'I' => ['name' => 'Type I (always burns, never tans)', 'lo' => 15, 'hi' => 30], 'II' => ['name' => 'Type II (usually burns, tans little)', 'lo' => 25, 'hi' => 40],
        'III' => ['name' => 'Type III (sometimes burns, tans gradually)', 'lo' => 30, 'hi' => 50], 'IV' => ['name' => 'Type IV (rarely burns, tans well)', 'lo' => 40, 'hi' => 60],
        'V' => ['name' => 'Type V (very rarely burns)', 'lo' => 60, 'hi' => 90], 'VI' => ['name' => 'Type VI (never burns)', 'lo' => 90, 'hi' => 150],
    ],

    /*
    | Snow-to-liquid ratio by surface temperature (°F): NWS Observing Handbook No. 7 (1996)
    | conversion table. NWS describes it as a rough guide; real ratios range 3:1 to 100:1.
    */
    'snow_ratio' => [[28, 10], [20, 15], [15, 20], [10, 30], [0, 40], [-20, 50], [-40, 100]],

    /*
    | Share of New Year's resolvers still keeping their resolution: Norcross & Vangarelli,
    | J Subst Abuse 1988–89 (n = 200); 1-month to 6-month values as cited by Oscarsson et al.,
    | PLoS One 2020. [weeks since 1 January, %]
    */
    'resolutions' => [[0, 100], [1, 77], [4, 55], [13, 43], [26, 40], [104, 19]],

];
