<?php

/*
|--------------------------------------------------------------------------
| Sports calculators
|--------------------------------------------------------------------------
|
| Same shape as config/everyday.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name sports.{category}.{tool}
|   view       sports.{category}.{tool with underscores}
|
| Generated pages share handlers in resources/js/calc/tools/sp-*.js and the
| shared physics engine in resources/js/calc/physics/.
|
*/

$categories = [
    [
        'slug' => 'baseball',
        'title' => 'Baseball',
        'description' => 'Batting, pitching and fielding statistics, magic numbers and WAR',
        'tools' => [
            ['slug' => 'babip-calculator', 'title' => 'BABIP Calculator', 'description' => 'Find BABIP'],
            ['slug' => 'batting-average-calculator', 'title' => 'Batting Average Calculator', 'description' => 'Find a batting average'],
            ['slug' => 'era-calculator-earned-run-average', 'title' => 'ERA Calculator – Earned Run Average', 'description' => 'Find a pitcher’s ERA'],
            ['slug' => 'fielding-percentage-calculator', 'title' => 'Fielding Percentage Calculator', 'description' => 'Find fielding percentage'],
            ['slug' => 'fip-calculator-fielding-independent-pitching', 'title' => 'FIP Calculator (Fielding Independent Pitching)', 'description' => 'Find a pitcher’s FIP'],
            ['slug' => 'k9-and-bb9-calculator', 'title' => 'K/9 and BB/9 Calculator', 'description' => 'Find strikeouts and walks per nine'],
            ['slug' => 'magic-number-calculator', 'title' => 'Magic Number Calculator', 'description' => 'Find a team’s magic number'],
            ['slug' => 'on-base-percentage-calculator', 'title' => 'On Base Percentage Calculator', 'description' => 'Find on-base percentage'],
            ['slug' => 'ops-calculator-on-base-plus-slugging', 'title' => 'OPS Calculator (On-Base Plus Slugging)', 'description' => 'Find OPS'],
            ['slug' => 'pythagorean-win-expectation-calculator', 'title' => 'Pythagorean Win Expectation Calculator', 'description' => 'Find expected wins from runs'],
            ['slug' => 'slugging-percentage-calculator', 'title' => 'Slugging Percentage Calculator', 'description' => 'Find slugging percentage'],
            ['slug' => 'war-calculator-wins-above-replacement', 'title' => 'WAR Calculator (Wins Above Replacement)', 'description' => 'Find WAR from component runs'],
            ['slug' => 'whip-calculator-for-baseball', 'title' => 'WHIP Calculator for Baseball', 'description' => 'Find a pitcher’s WHIP'],
        ],
    ],
    [
        'slug' => 'basketball',
        'title' => 'Basketball',
        'description' => 'Shooting efficiency, game score, usage and the dunk check',
        'tools' => [
            ['slug' => 'assist-to-turnover-ratio-calculator', 'title' => 'Assist to Turnover Ratio Calculator', 'description' => 'Find the assist-to-turnover ratio'],
            ['slug' => 'dunk-calculator', 'title' => 'Dunk Calculator', 'description' => 'Check whether you can dunk'],
            ['slug' => 'efg-calculator', 'title' => 'eFG Calculator', 'description' => 'Find effective field-goal percentage'],
            ['slug' => 'game-score-calculator-basketball-performance-indicator', 'title' => 'Game Score Calculator – Basketball Performance Indicator', 'description' => 'Rate a game with Game Score'],
            ['slug' => 'ts-calculator-true-shooting-percentage', 'title' => 'TS Calculator (True Shooting Percentage)', 'description' => 'Find true shooting percentage'],
            ['slug' => 'usage-rate-calculator', 'title' => 'Usage Rate Calculator', 'description' => 'Find usage rate'],
        ],
    ],
    [
        'slug' => 'calories-burned',
        'title' => 'Calories Burned',
        'description' => 'Energy used by activity, heart rate and weight-loss timelines',
        'tools' => [
            ['slug' => 'burpee-calorie-calculator', 'title' => 'Burpee Calorie Calculator', 'description' => 'Find calories burned doing burpees'],
            ['slug' => 'calories-burned-by-heart-rate-calculator', 'title' => 'Calories Burned by Heart Rate Calculator', 'description' => 'Estimate calories from heart rate'],
            ['slug' => 'calories-burned-rowing-calculator', 'title' => 'Calories Burned Rowing Calculator', 'description' => 'Find rowing calories'],
            ['slug' => 'calories-burned-yoga-and-pilates-calculator', 'title' => 'Calories Burned Yoga and Pilates Calculator', 'description' => 'Find yoga and Pilates calories'],
            ['slug' => 'elliptical-calorie-calculator', 'title' => 'Elliptical Calorie Calculator', 'description' => 'Find elliptical calories'],
            ['slug' => 'fat-burning-zone-calculator', 'title' => 'Fat Burning Zone Calculator', 'description' => 'Find your fat-burning zone'],
            ['slug' => 'hiking-calculator', 'title' => 'Hiking Calculator', 'description' => 'Find calories burned hiking'],
            ['slug' => 'jump-rope-calorie-calculator', 'title' => 'Jump Rope Calorie Calculator', 'description' => 'Find jump rope calories'],
            ['slug' => 'running-calorie-calculator', 'title' => 'Running Calorie Calculator', 'description' => 'Find calories burned running'],
            ['slug' => 'sauna-calories-burned-calculator', 'title' => 'Sauna Calories Burned Calculator', 'description' => 'Estimate sauna calories'],
            ['slug' => 'snow-shoveling-calories-burned-calculator', 'title' => 'Snow Shoveling Calories Burned Calculator', 'description' => 'Find snow-shovelling calories'],
            ['slug' => 'stairs-calorie-calculator', 'title' => 'Stairs Calorie Calculator', 'description' => 'Find stair-climbing calories'],
            ['slug' => 'swimming-calorie-calculator', 'title' => 'Swimming Calorie Calculator', 'description' => 'Find swimming calories'],
            ['slug' => 'walking-calorie-calculator', 'title' => 'Walking Calorie Calculator', 'description' => 'Find calories burned walking'],
            ['slug' => 'weight-loss-calculator', 'title' => 'Weight Loss Calculator', 'description' => 'Find how long weight loss takes'],
        ],
        'elsewhere' => [
            ['route' => 'health.other.calories-burned-calculator', 'title' => 'Calories Burned Calculator', 'description' => 'Calories by activity and minutes, including standing and weight lifting (Health)'],
            ['route' => 'health.other.steps-to-calories-calculator', 'title' => 'Steps to Calories Calculator', 'description' => 'Distance and calories from steps (Health)'],
        ],
    ],
    [
        'slug' => 'cricket',
        'title' => 'Cricket',
        'description' => 'Strike rates, averages, run rates, follow-on and ICC ratings',
        'tools' => [
            ['slug' => 'batting-strike-rate-calculator', 'title' => 'Batting Strike Rate Calculator', 'description' => 'Find a batting strike rate'],
            ['slug' => 'bowling-average-calculator', 'title' => 'Bowling Average Calculator', 'description' => 'Find a bowling average'],
            ['slug' => 'cricket-batting-average-calculator', 'title' => 'Cricket Batting Average Calculator', 'description' => 'Find a batting average in cricket'],
            ['slug' => 'cricket-follow-on-calculator', 'title' => 'Cricket Follow-On Calculator', 'description' => 'Check the follow-on'],
            ['slug' => 'economy-rate-calculator', 'title' => 'Economy Rate Calculator', 'description' => 'Find a bowler’s economy rate'],
            ['slug' => 'icc-calculator', 'title' => 'ICC Calculator', 'description' => 'Find ICC ranking points for a match'],
            ['slug' => 'net-run-rate-calculator', 'title' => 'Net Run Rate Calculator', 'description' => 'Find net run rate'],
            ['slug' => 'required-run-rate-calculator', 'title' => 'Required Run Rate Calculator', 'description' => 'Find the required run rate'],
        ],
    ],
    [
        'slug' => 'cycling',
        'title' => 'Cycling',
        'description' => 'Gearing, cadence and speed, power, zones, bike fit and running costs',
        'tools' => [
            ['slug' => 'bicycle-lubricant-cost-to-run-calculator', 'title' => 'Bicycle Lubricant Cost-to-Run Calculator', 'description' => 'Find your chain-lube cost'],
            ['slug' => 'bike-cadence-and-speed-calculator', 'title' => 'Bike Cadence and Speed Calculator', 'description' => 'Convert cadence and speed'],
            ['slug' => 'bike-gear-calculator', 'title' => 'Bike Gear Calculator', 'description' => 'Compare bike gears'],
            ['slug' => 'bike-pace-calculator', 'title' => 'Bike Pace Calculator', 'description' => 'Find cycling speed or time'],
            ['slug' => 'bike-size-calculator', 'title' => 'Bike Size Calculator', 'description' => 'Find your bike frame size'],
            ['slug' => 'calories-burned-biking-calculator', 'title' => 'Calories Burned Biking Calculator', 'description' => 'Find cycling calories'],
            ['slug' => 'chain-length-calculator', 'title' => 'Chain Length Calculator', 'description' => 'Find bike chain length'],
            ['slug' => 'cycling-breakaway-calculator', 'title' => 'Cycling Breakaway Calculator', 'description' => 'Will the breakaway survive?'],
            ['slug' => 'cycling-heart-rate-zone-calculator', 'title' => 'Cycling Heart Rate Zone Calculator', 'description' => 'Find cycling heart-rate zones'],
            ['slug' => 'cycling-wattage-calculator', 'title' => 'Cycling Wattage Calculator', 'description' => 'Find cycling power'],
            ['slug' => 'e-bike-range-calculator', 'title' => 'E-Bike Range Calculator', 'description' => 'Estimate e-bike range'],
            ['slug' => 'ftp-calculator', 'title' => 'FTP Calculator', 'description' => 'Find your FTP'],
        ],
    ],
    [
        'slug' => 'overall-fitness',
        'title' => 'Overall Fitness',
        'description' => 'Ape index, vertical jump and punch force',
        'tools' => [
            ['slug' => 'ape-index-calculator', 'title' => 'Ape Index Calculator', 'description' => 'Find your ape index'],
            ['slug' => 'human-punch-force-calculator', 'title' => 'Human Punch Force Calculator', 'description' => 'Estimate punch force'],
            ['slug' => 'vertical-jump-calculator', 'title' => 'Vertical Jump Calculator', 'description' => 'Find jump height and power'],
        ],
    ],
    [
        'slug' => 'performance',
        'title' => 'Performance',
        'description' => 'Heart-rate zones and recovery, METs, threshold and rowing ergometer',
        'tools' => [
            ['slug' => 'anaerobic-threshold-calculator', 'title' => 'Anaerobic Threshold Calculator', 'description' => 'Find your threshold heart rate'],
            ['slug' => 'bruce-protocol-mets-calculator', 'title' => 'Bruce Protocol METs Calculator', 'description' => 'Find METs from a Bruce test'],
            ['slug' => 'erg-calculator', 'title' => 'ERG Calculator', 'description' => 'Convert erg pace and watts'],
            ['slug' => 'heart-rate-calculator', 'title' => 'Heart Rate Calculator', 'description' => 'Find your heart rate'],
            ['slug' => 'heart-rate-recovery-calculator', 'title' => 'Heart Rate Recovery Calculator', 'description' => 'Find heart-rate recovery'],
            ['slug' => 'heart-rate-zone-calculator', 'title' => 'Heart Rate Zone Calculator', 'description' => 'Find your heart-rate zones'],
            ['slug' => 'hiking-time-calculator', 'title' => 'Hiking Time Calculator', 'description' => 'Estimate hiking time'],
            ['slug' => 'max-heart-rate-calculator', 'title' => 'Max Heart Rate Calculator', 'description' => 'Estimate maximum heart rate'],
            ['slug' => 'met-minutes-calculator', 'title' => 'MET Minutes Calculator', 'description' => 'Total your weekly MET-minutes'],
            ['slug' => 'target-heart-rate-calculator', 'title' => 'Target Heart Rate Calculator', 'description' => 'Find your target heart rate'],
        ],
        'elsewhere' => [
            ['route' => 'health.other.vo2-max-calculator', 'title' => 'VO2 Max Calculator – Aerobic Capacity', 'description' => 'Cooper, Rockport or heart-rate methods (Health)'],
        ],
    ],
    [
        'slug' => 'running',
        'title' => 'Running',
        'description' => 'Pace, race prediction, VDOT training paces, splits, steps and stride',
        'tools' => [
            ['slug' => 'cooper-test-calculator', 'title' => 'Cooper Test Calculator', 'description' => 'Score a Cooper test'],
            ['slug' => 'magic-mile-calculator', 'title' => 'Magic Mile Calculator', 'description' => 'Set race paces from a Magic Mile'],
            ['slug' => 'marathon-pace-calculator', 'title' => 'Marathon Pace Calculator', 'description' => 'Find your marathon pace'],
            ['slug' => 'pace-calculator', 'title' => 'Pace Calculator', 'description' => 'Find pace, time or distance'],
            ['slug' => 'race-predictor-running-time-calculator', 'title' => 'Race Predictor – Running Time Calculator', 'description' => 'Predict race times'],
            ['slug' => 'race-time-improvement-calculator', 'title' => 'Race Time Improvement Calculator', 'description' => 'Plan a race-time improvement'],
            ['slug' => 'running-pace-calculator', 'title' => 'Running Pace Calculator', 'description' => 'Convert running pace and speed'],
            ['slug' => 'running-split-calculator', 'title' => 'Running Split Calculator', 'description' => 'Plan your race splits'],
            ['slug' => 'steps-to-km-calculator', 'title' => 'Steps to km Calculator', 'description' => 'Convert steps to kilometres'],
            ['slug' => 'steps-to-miles-calculator', 'title' => 'Steps to Miles Calculator', 'description' => 'Convert steps to miles'],
            ['slug' => 'stride-length-calculator', 'title' => 'Stride Length Calculator', 'description' => 'Find your stride length'],
            ['slug' => 'training-pace-calculator', 'title' => 'Training Pace Calculator', 'description' => 'Find your training paces'],
            ['slug' => 'treadmill-calculator', 'title' => 'Treadmill Calculator', 'description' => 'Convert treadmill effort'],
            ['slug' => 'vo2-max-runners-calculator', 'title' => 'VO2 Max Runners Calculator', 'description' => 'Estimate VO₂max from a race'],
        ],
    ],
    [
        'slug' => 'triathlon',
        'title' => 'Triathlon',
        'description' => 'Finishing time, power and heart-rate zones, fuelling, sweat rate and training',
        'tools' => [
            ['slug' => 'average-triathlon-finishing-time-calculator', 'title' => 'Average Triathlon Finishing Time Calculator', 'description' => 'Find your triathlon finishing time'],
            ['slug' => 'cycling-power-zones-calculator', 'title' => 'Cycling Power Zones Calculator', 'description' => 'Find your power zones'],
            ['slug' => 'diy-sports-drink-calculator', 'title' => 'DIY Sports Drink Calculator', 'description' => 'Mix your own sports drink'],
            ['slug' => 'sweat-rate-calculator', 'title' => 'Sweat Rate Calculator', 'description' => 'Find your sweat rate'],
            ['slug' => 'triathlon-heart-rate-training-zones-calculator', 'title' => 'Triathlon Heart Rate Training Zones Calculator', 'description' => 'Find triathlon heart-rate zones'],
            ['slug' => 'triathlon-nutrition-calculator', 'title' => 'Triathlon Nutrition Calculator', 'description' => 'Plan race fuelling'],
            ['slug' => 'triathlon-training-calculator', 'title' => 'Triathlon Training Calculator', 'description' => 'Split your training time'],
        ],
    ],
    [
        'slug' => 'watersports',
        'title' => 'Watersports',
        'description' => 'Hull speed, swim pace, scuba, fishing, kites and sails',
        'tools' => [
            ['slug' => 'critical-swim-speed-calculator', 'title' => 'Critical Swim Speed Calculator', 'description' => 'Find your critical swim speed'],
            ['slug' => 'fish-weight-calculator', 'title' => 'Fish Weight Calculator', 'description' => 'Estimate a fish’s weight'],
            ['slug' => 'fishing-reel-line-capacity-calculator', 'title' => 'Fishing Reel Line Capacity Calculator', 'description' => 'Find reel line capacity'],
            ['slug' => 'hull-speed-calculator', 'title' => 'Hull Speed Calculator', 'description' => 'Find hull speed'],
            ['slug' => 'kiteboarding-calculator', 'title' => 'Kiteboarding Calculator', 'description' => 'Find your kite size'],
            ['slug' => 'scuba-air-consumption-calculator', 'title' => 'Scuba Air Consumption Calculator', 'description' => 'Find your air consumption'],
            ['slug' => 'scuba-weight-calculator', 'title' => 'Scuba Weight Calculator', 'description' => 'Estimate scuba weighting'],
            ['slug' => 'windsurfing-calculator', 'title' => 'Windsurfing Calculator', 'description' => 'Find your sail size'],
        ],
    ],
    [
        'slug' => 'weightlifting',
        'title' => 'Weightlifting',
        'description' => 'One-rep max, programmes, plates, RPE and strength scores',
        'tools' => [
            ['slug' => '531-calculator', 'title' => '5/3/1 Calculator', 'description' => 'Plan a 5/3/1 cycle'],
            ['slug' => 'barbell-plate-calculator', 'title' => 'Barbell Plate Calculator', 'description' => 'Load the bar'],
            ['slug' => 'bench-press-calculator-find-your-1rm', 'title' => 'Bench Press Calculator - Find Your 1RM', 'description' => 'Estimate your bench press max'],
            ['slug' => 'bench-press-pyramid-calculator', 'title' => 'Bench Press Pyramid Calculator', 'description' => 'Build a pyramid workout'],
            ['slug' => 'dots-calculator', 'title' => 'DOTS Calculator', 'description' => 'Find your DOTS score'],
            ['slug' => 'ipf-gl-points-calculator', 'title' => 'IPF GL Points Calculator', 'description' => 'Find your IPF GL points'],
            ['slug' => 'one-rep-max-calculator', 'title' => 'One-Rep Max Calculator', 'description' => 'Estimate your one-rep max'],
            ['slug' => 'rpe-calculator', 'title' => 'RPE Calculator', 'description' => 'Use RPE to set loads'],
            ['slug' => 'wilks-calculator', 'title' => 'Wilks Calculator', 'description' => 'Find your Wilks score'],
        ],
    ],
    [
        'slug' => 'other-sports',
        'title' => 'Other Sports',
        'description' => 'Football, hockey, golf, bowling, archery, skiing, athletics scoring and more',
        'tools' => [
            ['slug' => 'arrow-foc-calculator', 'title' => 'Arrow FOC Calculator', 'description' => 'Find your arrow’s FOC'],
            ['slug' => 'bowling-score-calculator', 'title' => 'Bowling Score Calculator', 'description' => 'Score a bowling game'],
            ['slug' => 'decathlon-calculator', 'title' => 'Decathlon Calculator', 'description' => 'Score a decathlon'],
            ['slug' => 'elo-calculator', 'title' => 'Elo Calculator', 'description' => 'Update an Elo rating'],
            ['slug' => 'football-calorie-calculator-world-cup-edition', 'title' => 'Football Calorie Calculator (World Cup Edition)', 'description' => 'Find football calories'],
            ['slug' => 'gaa-calculator-goals-against-average', 'title' => 'GAA Calculator (Goals Against Average)', 'description' => 'Find goals against average'],
            ['slug' => 'goalie-save-percentage-calculator', 'title' => 'Goalie Save Percentage Calculator', 'description' => 'Find a goalie’s save percentage'],
            ['slug' => 'golf-handicap-calculator', 'title' => 'Golf Handicap Calculator', 'description' => 'Find your Handicap Index'],
            ['slug' => 'heptathlon-calculator', 'title' => 'Heptathlon Calculator', 'description' => 'Score a heptathlon'],
            ['slug' => 'passer-rating-calculator', 'title' => 'Passer Rating Calculator', 'description' => 'Find a passer rating'],
            ['slug' => 'pool-table-room-size-calculator', 'title' => 'Pool Table Room Size Calculator', 'description' => 'Find the room size for a pool table'],
            ['slug' => 'save-percentage-calculator', 'title' => 'Save Percentage Calculator', 'description' => 'Find a closer’s save percentage'],
            ['slug' => 'ski-size-calculator', 'title' => 'Ski Size Calculator', 'description' => 'Find your ski length'],
            ['slug' => 'tennis-ball-usage-calculator', 'title' => 'Tennis Ball Usage Calculator', 'description' => 'Find how many tennis balls you use'],
            ['slug' => 'winning-percentage-calculator', 'title' => 'Winning Percentage Calculator', 'description' => 'Find a winning percentage'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "sports.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "sports.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
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
