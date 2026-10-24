<?php

/*
|--------------------------------------------------------------------------
| Other calculators
|--------------------------------------------------------------------------
|
| Same shape as config/everyday.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name other.{category}.{tool}
|   view       other.{category}.{tool with underscores}
|
| Generated pages share handlers in resources/js/calc/tools/ot-*.js and the
| shared engines in resources/js/calc/tech/ and statistics/.
|
*/

$categories = [
    [
        'slug' => 'education',
        'title' => 'Education',
        'description' => 'GPA, grades, curves, test scores, school years and attendance',
        'tools' => [
            ['slug' => 'act-score-calculator', 'title' => 'ACT Score Calculator', 'description' => 'Find your ACT composite'],
            ['slug' => 'attendance-percentage-calculator', 'title' => 'Attendance Percentage Calculator', 'description' => 'Track class attendance'],
            ['slug' => 'cgpa-to-percentage-calculator', 'title' => 'CGPA to Percentage Calculator', 'description' => 'Convert CGPA to a percentage'],
            ['slug' => 'classroom-spacing-calculator-coronavirus', 'title' => 'Classroom Spacing Calculator - Coronavirus', 'description' => 'Plan socially distanced seating'],
            ['slug' => 'college-gpa-calculator', 'title' => 'College GPA Calculator', 'description' => 'Find your college GPA'],
            ['slug' => 'final-grade-calculator', 'title' => 'Final Grade Calculator', 'description' => 'Find the score you need on the final'],
            ['slug' => 'gpa-calculator', 'title' => 'GPA Calculator', 'description' => 'Calculate your GPA'],
            ['slug' => 'gpa-calculator-pakistan', 'title' => 'GPA Calculator Pakistan', 'description' => 'Calculate GPA on the HEC scale'],
            ['slug' => 'grade-calculator', 'title' => 'Grade Calculator', 'description' => 'Find your course grade'],
            ['slug' => 'grade-curve-calculator', 'title' => 'Grade Curve Calculator', 'description' => 'Curve test scores'],
            ['slug' => 'graduation-year-calculator', 'title' => 'Graduation Year Calculator', 'description' => 'Find a graduation year'],
            ['slug' => 'gwa-calculator-general-weighted-average', 'title' => 'GWA Calculator – General Weighted Average', 'description' => 'Find your GWA'],
            ['slug' => 'high-school-gpa-calculator', 'title' => 'High School GPA Calculator', 'description' => 'Find your high school GPA'],
            ['slug' => 'ielts-score-calculator', 'title' => 'IELTS Score Calculator', 'description' => 'Find your IELTS overall band'],
            ['slug' => 'impact-factor-calculator', 'title' => 'Impact Factor Calculator', 'description' => 'Find a journal impact factor'],
            ['slug' => 'middle-school-gpa-calculator', 'title' => 'Middle School GPA Calculator', 'description' => 'Find a middle school GPA'],
            ['slug' => 'pte-score-calculator', 'title' => 'PTE Score Calculator', 'description' => 'Convert PTE to IELTS'],
            ['slug' => 'semester-grade-calculator', 'title' => 'Semester Grade Calculator', 'description' => 'Find your semester grade'],
            ['slug' => 'sgpa-to-cgpa-calculator', 'title' => 'SGPA to CGPA Calculator', 'description' => 'Combine semester GPAs'],
            ['slug' => 'test-grade-calculator', 'title' => 'Test Grade Calculator', 'description' => 'Grade a test'],
        ],
        'elsewhere' => [
            ['route' => 'everyday.office-school-and-productivity.sat-score-calculator', 'title' => 'SAT Score Calculator', 'description' => 'Section and total SAT scores (Everyday Life)'],
            ['route' => 'everyday.office-school-and-productivity.gmat-score-calculator', 'title' => 'GMAT Score Calculator', 'description' => 'GMAT total score (Everyday Life)'],
        ],
    ],
    [
        'slug' => 'video-games',
        'title' => 'Video Games',
        'description' => 'Drop chances, K/D, Minecraft helpers, Pokémon GO candy and Rust decay',
        'tools' => [
            ['slug' => 'drop-chance-calculator', 'title' => 'Drop Chance Calculator', 'description' => 'Find your drop chance'],
            ['slug' => 'fps-to-frame-time-calculator', 'title' => 'FPS to Frame Time Calculator', 'description' => 'Convert FPS to frame time'],
            ['slug' => 'impostor-odds-calculator-among-us', 'title' => 'Impostor Odds Calculator – Among Us', 'description' => 'Find the impostor odds'],
            ['slug' => 'kd-calculator-kill-death-ratio', 'title' => 'KD Calculator (Kill/Death Ratio)', 'description' => 'Find your K/D ratio'],
            ['slug' => 'minecraft-chunk-calculator', 'title' => 'Minecraft Chunk Calculator', 'description' => 'Find a Minecraft chunk'],
            ['slug' => 'minecraft-circle-generator', 'title' => 'Minecraft Circle Generator', 'description' => 'Plan a Minecraft circle'],
            ['slug' => 'minecraft-end-portal-finder', 'title' => 'Minecraft End Portal Finder', 'description' => 'Find the stronghold'],
            ['slug' => 'minecraft-stack-calculator', 'title' => 'Minecraft Stack Calculator', 'description' => 'Count Minecraft stacks'],
            ['slug' => 'nether-portal-calculator', 'title' => 'Nether Portal Calculator', 'description' => 'Link Nether portals'],
            ['slug' => 'pokemon-go-candy-calculator', 'title' => 'Pokémon Go Candy Calculator', 'description' => 'Plan your evolutions'],
            ['slug' => 'pyramid-block-calculator', 'title' => 'Pyramid Block Calculator', 'description' => 'Count pyramid blocks'],
            ['slug' => 'rust-decay-calculator', 'title' => 'Rust Decay Calculator', 'description' => 'Find Rust decay time'],
        ],
    ],
    [
        'slug' => 'logistics',
        'title' => 'Logistics',
        'description' => 'CBM, containers, pallets, dimensional weight, freight class and inventory',
        'tools' => [
            ['slug' => 'cbm-calculator', 'title' => 'CBM Calculator', 'description' => 'Find cubic metres'],
            ['slug' => 'container-loading-calculator', 'title' => 'Container Loading Calculator', 'description' => 'Load a container'],
            ['slug' => 'dimensional-weight-calculator', 'title' => 'Dimensional Weight Calculator', 'description' => 'Find the billable weight'],
            ['slug' => 'dpmo-calculator', 'title' => 'DPMO Calculator', 'description' => 'Find DPMO and sigma level'],
            ['slug' => 'freight-class-calculator', 'title' => 'Freight Class Calculator', 'description' => 'Estimate the freight class'],
            ['slug' => 'landed-cost-calculator', 'title' => 'Landed Cost Calculator', 'description' => 'Find the landed cost'],
            ['slug' => 'pallet-calculator', 'title' => 'Pallet Calculator', 'description' => 'Load a pallet'],
            ['slug' => 'reorder-point-calculator', 'title' => 'Reorder Point Calculator', 'description' => 'Find the reorder point'],
            ['slug' => 'takt-time-calculator', 'title' => 'Takt Time Calculator', 'description' => 'Find the takt time'],
        ],
        'elsewhere' => [
            ['route' => 'finance.microeconomics.eoq-calculator-economic-order-quantity', 'title' => 'EOQ Calculator', 'description' => 'Economic order quantity (Finance)'],
            ['route' => 'finance.business-planning.safety-stock-calculator', 'title' => 'Safety Stock Calculator', 'description' => 'Buffer stock for variable demand (Finance)'],
        ],
    ],
    [
        'slug' => 'seasons-and-holidays',
        'title' => 'Seasons and Holidays',
        'description' => 'Countdowns, Easter, equinoxes, daylight saving, the Mayan calendar and festive fun',
        'tools' => [
            ['slug' => 'christmas-countdown-calculator', 'title' => 'Christmas Countdown Calculator', 'description' => 'Count down to the holidays'],
            ['slug' => 'christmas-tree-calculator', 'title' => 'Christmas Tree Calculator', 'description' => 'Decorate your Christmas tree'],
            ['slug' => 'daylight-saving-time-calculator', 'title' => 'Daylight Saving Time Calculator', 'description' => 'Find when the clocks change'],
            ['slug' => 'easter-calculator', 'title' => 'Easter Calculator', 'description' => 'Find the date of Easter'],
            ['slug' => 'equinox-and-solstice-calculator', 'title' => 'Equinox and Solstice Calculator', 'description' => 'Find the equinoxes and solstices'],
            ['slug' => 'mayan-calendar-converter', 'title' => 'Mayan Calendar Converter', 'description' => 'Convert dates to the Mayan calendar'],
            ['slug' => 'new-years-resolutions-calculator', 'title' => 'New Year\'s Resolutions Calculator', 'description' => 'Check your resolution odds'],
            ['slug' => 'snowman-calculator', 'title' => 'Snowman Calculator', 'description' => 'Plan a snowman'],
            ['slug' => 'trick-or-treat-calculator', 'title' => 'Trick-or-Treat Calculator', 'description' => 'Plan Halloween candy'],
            ['slug' => 'vampire-apocalypse-calculator', 'title' => 'Vampire Apocalypse Calculator', 'description' => 'Model a vampire apocalypse'],
            ['slug' => 'zombie-invasion-calculator', 'title' => 'Zombie Invasion Calculator', 'description' => 'Model a zombie outbreak'],
        ],
        'elsewhere' => [
            ['route' => 'everyday.time-and-date.countdown-calculator', 'title' => 'Countdown Calculator', 'description' => 'Count down to any date and time (Everyday Life)'],
        ],
    ],
    [
        'slug' => 'earth-and-weather',
        'title' => 'Earth and Weather',
        'description' => 'Distances and bearings on the globe, earthquakes, rain, snow and sunburn',
        'tools' => [
            ['slug' => 'antipode-calculator', 'title' => 'Antipode Calculator', 'description' => 'Find the antipode'],
            ['slug' => 'azimuth-calculator', 'title' => 'Azimuth Calculator', 'description' => 'Find the bearing between two places'],
            ['slug' => 'earthquake-calculator', 'title' => 'Earthquake Calculator', 'description' => 'Compare earthquake magnitudes'],
            ['slug' => 'latitude-longitude-distance-calculator', 'title' => 'Latitude Longitude Distance Calculator', 'description' => 'Find the distance between coordinates'],
            ['slug' => 'rain-to-snow-calculator', 'title' => 'Rain to Snow Calculator', 'description' => 'Convert rain to snow'],
            ['slug' => 'rainfall-calculator', 'title' => 'Rainfall Calculator', 'description' => 'Find rainfall volume'],
            ['slug' => 'sunbathing-calculator', 'title' => 'Sunbathing Calculator', 'description' => 'Find your safe sun time'],
        ],
        'elsewhere' => [
            ['route' => 'physics.atmospheric-physics.wind-chill-calculator', 'title' => 'Wind Chill Calculator', 'description' => 'Feels-like temperature in wind (Physics)'],
            ['route' => 'physics.atmospheric-physics.heat-index-calculator', 'title' => 'Heat Index Calculator', 'description' => 'Feels-like temperature in humidity (Physics)'],
            ['route' => 'physics.atmospheric-physics.lightning-distance-calculator', 'title' => 'Lightning Distance Calculator', 'description' => 'Flash-to-bang distance (Physics)'],
            ['route' => 'physics.experiments.sunrise-sunset-calculator', 'title' => 'Sunrise and Sunset Calculator', 'description' => 'Sun times for any place (Physics)'],
        ],
    ],
    [
        'slug' => 'miscellaneous',
        'title' => 'Miscellaneous',
        'description' => 'D&D, poker and betting, pay gaps, PERT, travel costs and other handy tools',
        'tools' => [
            ['slug' => 'age-on-other-planets-calculator', 'title' => 'Age on Other Planets Calculator', 'description' => 'Find your age on other planets'],
            ['slug' => 'angle-of-impact-calculator', 'title' => 'Angle of Impact Calculator', 'description' => 'Find the angle of impact'],
            ['slug' => 'caesar-cipher-shifter', 'title' => 'Caesar Cipher Shifter', 'description' => 'Use the Caesar cipher'],
            ['slug' => 'cost-of-hiring-an-expert-vs-hiring-a-fresher-calculator', 'title' => 'Cost of Hiring an Expert vs. Hiring a Fresher Calculator', 'description' => 'Compare hiring an expert or a fresher'],
            ['slug' => 'dating-theory-calculator', 'title' => 'Dating Theory Calculator', 'description' => 'Apply the 37% rule'],
            ['slug' => 'diamond-weight-calculator', 'title' => 'Diamond Weight Calculator', 'description' => 'Estimate a diamond’s carat weight'],
            ['slug' => 'dnd-money-conversion', 'title' => 'DnD Money Conversion', 'description' => 'Convert D&D coins'],
            ['slug' => 'encounter-calculator-5e', 'title' => 'Encounter Calculator 5e', 'description' => 'Rate a D&D encounter'],
            ['slug' => 'engagement-rate-calculator', 'title' => 'Engagement Rate Calculator', 'description' => 'Find an engagement rate'],
            ['slug' => 'flag-calculator-usa', 'title' => 'Flag Calculator | USA', 'description' => 'Find US flag dimensions'],
            ['slug' => 'gender-pay-gap-calculator', 'title' => 'Gender Pay Gap Calculator', 'description' => 'Find the gender pay gap'],
            ['slug' => 'hp-calculator-5e-dungeons-dragons', 'title' => 'HP Calculator 5e – Dungeons & Dragons', 'description' => 'Find your D&D hit points'],
            ['slug' => 'matched-betting-calculator', 'title' => 'Matched Betting Calculator', 'description' => 'Work out a lay stake'],
            ['slug' => 'nanowrimo-calculator', 'title' => 'NaNoWriMo Calculator', 'description' => 'Stay on track for 50,000 words'],
            ['slug' => 'oxygen-tank-duration-calculator', 'title' => 'Oxygen Tank Duration Calculator', 'description' => 'Find oxygen cylinder duration'],
            ['slug' => 'pay-gap-calculator', 'title' => 'Pay Gap Calculator', 'description' => 'Find a pay gap'],
            ['slug' => 'pert-calculator', 'title' => 'PERT Calculator', 'description' => 'Estimate a project with PERT'],
            ['slug' => 'point-buy-calculator-5e', 'title' => 'Point Buy Calculator 5e', 'description' => 'Plan your ability scores'],
            ['slug' => 'poker-ev-calculator', 'title' => 'Poker EV Calculator', 'description' => 'Decide whether to call'],
            ['slug' => 'poker-odds-calculator', 'title' => 'Poker Odds Calculator', 'description' => 'Find your poker odds'],
            ['slug' => 'recruitment-process-duration-calculator', 'title' => 'Recruitment Process Duration Calculator', 'description' => 'Plan a hiring timeline'],
            ['slug' => 'rounds-per-minute-calculator', 'title' => 'Rounds per Minute Calculator', 'description' => 'Find the rate of fire'],
            ['slug' => 'salt-dough-calculator', 'title' => 'Salt Dough Calculator', 'description' => 'Mix salt dough'],
            ['slug' => 'sandbox-calculator', 'title' => 'Sandbox Calculator', 'description' => 'Fill a sandbox'],
            ['slug' => 'streaming-services-royalties-calculator', 'title' => 'Streaming Services‘ Royalties Calculator', 'description' => 'Estimate streaming royalties'],
            ['slug' => 'travel-expenses-calculator', 'title' => 'Travel Expenses', 'description' => 'Budget a trip'],
        ],
        'elsewhere' => [
            ['route' => 'finance.tax-and-salary.tip-calculator', 'title' => 'Tip Calculator', 'description' => 'Tips, splitting and tipping on the pre-tax amount (Finance)'],
            ['route' => 'everyday.time-and-date.day-of-the-week-calculator', 'title' => 'Day of the Week Calculator', 'description' => 'The weekday of any date (Everyday Life)'],
            ['route' => 'biology.other-animals.aquarium-volume-calculator', 'title' => 'Aquarium Calculator', 'description' => 'Tank volume and water weight (Biology)'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "other.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "other.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
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
