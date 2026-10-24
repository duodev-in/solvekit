<?php

/*
|--------------------------------------------------------------------------
| Technology reference data
|--------------------------------------------------------------------------
|
| Read by the Technology section tools (resources/js/calc/tools/tc-*.js) through
| the page's `data` config. Each block names its source and date; values were
| checked against the source on 2026-10-20.
|
*/

return [

    /*
    | Camera sensor sizes (mm), width × height. Wikipedia "Image sensor format"
    | (accessed 2026-10-20); inch-type sizes are nominal, not standardised.
    */
    'sensors' => [
        'ff' => ['name' => 'Full frame (35 mm)', 'w' => 36, 'h' => 24],
        'mf' => ['name' => 'Medium format 44 × 33', 'w' => 43.8, 'h' => 32.9],
        'apsh' => ['name' => 'APS-H', 'w' => 27.9, 'h' => 18.6],
        'apsc' => ['name' => 'APS-C (Nikon, Sony, Fujifilm)', 'w' => 23.5, 'h' => 15.6],
        'apsc_canon' => ['name' => 'APS-C (Canon)', 'w' => 22.3, 'h' => 14.9],
        'm43' => ['name' => 'Micro Four Thirds', 'w' => 17.3, 'h' => 13.0],
        'one' => ['name' => '1-inch type', 'w' => 13.2, 'h' => 8.8],
        'two_thirds' => ['name' => '2/3-inch type', 'w' => 8.8, 'h' => 6.6],
        'one_17' => ['name' => '1/1.7-inch type', 'w' => 7.6, 'h' => 5.7],
        'one_23' => ['name' => '1/2.3-inch type (compacts, older phones)', 'w' => 6.17, 'h' => 4.55],
    ],

    /*
    | Motion-picture film: frames per foot. 35 mm 4-perf is stated by Kodak
    | ("Essential Reference Guide for Filmmakers", 2011); 3-perf and 16 mm follow from
    | Kodak's perforation pitch; Super 8 and Regular 8 are the standard trade values.
    */
    'film' => [
        '35_4' => ['name' => '35 mm (4-perf)', 'fpf' => 16],
        '35_3' => ['name' => '35 mm (3-perf)', 'fpf' => 21.3333333333],
        '16' => ['name' => '16 mm', 'fpf' => 40],
        'super8' => ['name' => 'Super 8', 'fpf' => 72],
        'r8' => ['name' => 'Regular 8 mm', 'fpf' => 80],
    ],

    /*
    | YouTube recommended SDR upload bitrates (Mbps) for 24–30 fps and 48–60 fps
    | (support.google.com/youtube/answer/1722171) and YouTube Live recommended maximum
    | for H.264 (answer/2853702), both read 2026-10-20.
    */
    'youtube' => [
        '2160' => ['name' => '2160p (4K)', 'std' => 45, 'high' => 68, 'live30' => 42, 'live60' => 50],
        '1440' => ['name' => '1440p (2K)', 'std' => 16, 'high' => 24, 'live30' => 21, 'live60' => 34],
        '1080' => ['name' => '1080p', 'std' => 8, 'high' => 12, 'live30' => 14, 'live60' => 17],
        '720' => ['name' => '720p', 'std' => 5, 'high' => 7.5, 'live30' => 8, 'live60' => 8],
        '480' => ['name' => '480p', 'std' => 2.5, 'high' => 4, 'live30' => 4, 'live60' => 4],
        '360' => ['name' => '360p', 'std' => 1, 'high' => 1.5, 'live30' => 4, 'live60' => 4],
    ],

    /*
    | Guitar string unit weights (lb/in): D'Addario "String Tension Specifications"
    | catalogue supplement. T (lb) = UW × (2 L f)² ÷ 386.4, L in inches, f in Hz.
    */
    'strings' => [
        'pl0095' => ['name' => 'Plain steel .0095', 'uw' => 0.00001999], 'pl010' => ['name' => 'Plain steel .010', 'uw' => 0.00002215], 'pl0105' => ['name' => 'Plain steel .0105', 'uw' => 0.00002442],
        'pl0115' => ['name' => 'Plain steel .0115', 'uw' => 0.00002930], 'pl013' => ['name' => 'Plain steel .013', 'uw' => 0.00003744], 'pl0135' => ['name' => 'Plain steel .0135', 'uw' => 0.00004037],
        'pl015' => ['name' => 'Plain steel .015', 'uw' => 0.00004984], 'pl017' => ['name' => 'Plain steel .017', 'uw' => 0.00006402], 'pl019' => ['name' => 'Plain steel .019', 'uw' => 0.00007997], 'pl020' => ['name' => 'Plain steel .020', 'uw' => 0.00008861],
        'nw018' => ['name' => 'Nickel wound .018', 'uw' => 0.00006215], 'nw026' => ['name' => 'Nickel wound .026', 'uw' => 0.00012671], 'nw028' => ['name' => 'Nickel wound .028', 'uw' => 0.00014666],
        'nw032' => ['name' => 'Nickel wound .032', 'uw' => 0.00019347], 'nw036' => ['name' => 'Nickel wound .036', 'uw' => 0.00023964], 'nw038' => ['name' => 'Nickel wound .038', 'uw' => 0.00026471],
        'nw042' => ['name' => 'Nickel wound .042', 'uw' => 0.00032279], 'nw046' => ['name' => 'Nickel wound .046', 'uw' => 0.00038216], 'nw048' => ['name' => 'Nickel wound .048', 'uw' => 0.00041382],
        'nw052' => ['name' => 'Nickel wound .052', 'uw' => 0.00048109], 'nw054' => ['name' => 'Nickel wound .054', 'uw' => 0.00053838],
        'pb022' => ['name' => 'Phosphor bronze .022', 'uw' => 0.00009876], 'pb025' => ['name' => 'Phosphor bronze .025', 'uw' => 0.00012686], 'pb026' => ['name' => 'Phosphor bronze .026', 'uw' => 0.00013640],
        'pb032' => ['name' => 'Phosphor bronze .032', 'uw' => 0.00021018], 'pb035' => ['name' => 'Phosphor bronze .035', 'uw' => 0.00025365], 'pb036' => ['name' => 'Phosphor bronze .036', 'uw' => 0.00026830],
        'pb042' => ['name' => 'Phosphor bronze .042', 'uw' => 0.00036722], 'pb045' => ['name' => 'Phosphor bronze .045', 'uw' => 0.00041751], 'pb047' => ['name' => 'Phosphor bronze .047', 'uw' => 0.00045289],
        'pb049' => ['name' => 'Phosphor bronze .049', 'uw' => 0.00049151], 'pb053' => ['name' => 'Phosphor bronze .053', 'uw' => 0.00056962], 'pb056' => ['name' => 'Phosphor bronze .056', 'uw' => 0.00063477], 'pb064' => ['name' => 'Phosphor bronze .064', 'uw' => 0.00082780],
        'bw025' => ['name' => '80/20 bronze .025', 'uw' => 0.00012339], 'bw026' => ['name' => '80/20 bronze .026', 'uw' => 0.00013253], 'bw032' => ['name' => '80/20 bronze .032', 'uw' => 0.00020352],
        'bw036' => ['name' => '80/20 bronze .036', 'uw' => 0.00025417], 'bw042' => ['name' => '80/20 bronze .042', 'uw' => 0.00034808], 'bw045' => ['name' => '80/20 bronze .045', 'uw' => 0.00040245],
        'bw047' => ['name' => '80/20 bronze .047', 'uw' => 0.00043634], 'bw053' => ['name' => '80/20 bronze .053', 'uw' => 0.00054852], 'bw056' => ['name' => '80/20 bronze .056', 'uw' => 0.00061132],
    ],

];
