<?php

/*
|--------------------------------------------------------------------------
| Construction calculators
|--------------------------------------------------------------------------
|
| Same shape as config/chemistry.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name construction.{category}.{tool}
|   view       construction.{category}.{tool with underscores}
|
*/

$categories = [
    [
        'slug' => 'construction-converters',
        'title' => 'Construction Converters',
        'description' => 'Board feet, cubic yards, square footage and coverage conversions',
        'tools' => [
            ['slug' => 'board-foot-calculator', 'title' => 'Board Foot Calculator', 'description' => 'Lumber and log board feet'],
            ['slug' => 'cubic-yard-calculator', 'title' => 'Cubic Yard Calculator', 'description' => 'Yards of fill, soil or concrete, from any shape'],
            ['slug' => 'gallons-per-square-foot-calculator', 'title' => 'Gallons per Square Foot Calculator', 'description' => 'Coverage rate ⇄ liquid depth'],
            ['slug' => 'size-to-weight-calculator', 'title' => 'Size to Weight Calculator (Rectangular Box)', 'description' => 'Weight of a block of any material'],
            ['slug' => 'square-footage-calculator', 'title' => 'Square Footage Calculator', 'description' => 'Area of rooms and plots, with cost'],
            ['slug' => 'square-yards-calculator', 'title' => 'Square Yards Calculator', 'description' => 'Square yards for carpet, sod and paving'],
        ],
    ],
    [
        'slug' => 'construction-materials',
        'title' => 'Construction Materials',
        'description' => 'Aggregates, lumber, metal weights, framing, siding and finishes',
        'tools' => [
            ['slug' => 'aluminum-weight-calculator', 'title' => 'Aluminum Weight Calculator', 'description' => 'Sheet, plate, bar, tube and angle by alloy'],
            ['slug' => 'baluster-calculator', 'title' => 'Baluster Calculator', 'description' => 'Baluster and spindle count and spacing'],
            ['slug' => 'board-and-batten-calculator', 'title' => 'Board and Batten Calculator', 'description' => 'Boards and battens for a wall'],
            ['slug' => 'brick-calculator', 'title' => 'Brick Calculator', 'description' => 'Bricks and mortar for a wall'],
            ['slug' => 'decking-calculator', 'title' => 'Decking Calculator', 'description' => 'Deck boards, joists and screws'],
            ['slug' => 'diy-shed-cost-calculator', 'title' => 'DIY Shed Cost Calculator', 'description' => 'Materials and cost of a shed'],
            ['slug' => 'drywall-calculator', 'title' => 'Drywall Calculator', 'description' => 'Sheets, screws, tape and compound'],
            ['slug' => 'fire-glass-calculator', 'title' => 'Fire Glass Calculator', 'description' => 'Pounds of fire glass for a pit'],
            ['slug' => 'framing-calculator', 'title' => 'Framing Calculator', 'description' => 'Studs, plates and headers for a wall'],
            ['slug' => 'french-drain-calculator', 'title' => 'French Drain Calculator', 'description' => 'Gravel, pipe and fall for a drain'],
            ['slug' => 'glass-weight-calculator', 'title' => 'Glass Weight Calculator', 'description' => 'Weight of glass panes'],
            ['slug' => 'gravel-calculator', 'title' => 'Gravel Calculator', 'description' => 'Tons and yards of gravel'],
            ['slug' => 'landscape-rock-calculator', 'title' => 'Landscape Rock Calculator', 'description' => 'Tons of decorative rock'],
            ['slug' => 'limestone-calculator', 'title' => 'Limestone Calculator', 'description' => 'Tons of crushed limestone'],
            ['slug' => 'log-weight-calculator', 'title' => 'Log Weight Calculator', 'description' => 'Green or dry log weight by species'],
            ['slug' => 'lumber-calculator', 'title' => 'Lumber Calculator', 'description' => 'Board feet, actual sizes and cost'],
            ['slug' => 'metal-weight-calculator', 'title' => 'Metal Weight Calculator', 'description' => 'Weight of any metal shape'],
            ['slug' => 'pipe-weight-calculator', 'title' => 'Pipe Weight Calculator', 'description' => 'Pipe weight by NPS and schedule'],
            ['slug' => 'plate-weight-calculator', 'title' => 'Plate Weight Calculator', 'description' => 'Steel and metal plate weight'],
            ['slug' => 'rebar-calculator', 'title' => 'Rebar Calculator', 'description' => 'Bars, length and weight for a slab'],
            ['slug' => 'retaining-wall-calculator', 'title' => 'Retaining Wall Calculator', 'description' => 'Blocks, caps and gravel'],
            ['slug' => 'rip-rap-calculator', 'title' => 'Rip Rap Calculator', 'description' => 'Tons of riprap for a slope or channel'],
            ['slug' => 'river-rock-calculator', 'title' => 'River Rock Calculator', 'description' => 'Tons of river rock'],
            ['slug' => 'rock-calculator', 'title' => 'Rock Calculator', 'description' => 'Tons of rock for an area'],
            ['slug' => 'rolling-offset-calculator', 'title' => 'Rolling Offset Calculator', 'description' => 'Pipe travel for a rolling offset'],
            ['slug' => 'sag-calculator', 'title' => 'SAG Calculator', 'description' => 'Sagitta of an arc from radius and chord'],
            ['slug' => 'sand-calculator', 'title' => 'Sand Calculator', 'description' => 'Tons and yards of sand'],
            ['slug' => 'sealant-calculator', 'title' => 'Sealant Calculator', 'description' => 'Caulk cartridges for a joint'],
            ['slug' => 'sonotube-calculator', 'title' => 'Sonotube Calculator', 'description' => 'Concrete for round form tubes'],
            ['slug' => 'spiral-staircase-calculator', 'title' => 'Spiral Staircase Calculator', 'description' => 'Treads, risers and code check'],
            ['slug' => 'steel-weight-calculator', 'title' => 'Steel Weight Calculator', 'description' => 'Bars, tubes, angles, channels and beams'],
            ['slug' => 'stone-weight-calculator', 'title' => 'Stone Weight Calculator', 'description' => 'Weight of granite, marble and other stone'],
            ['slug' => 'tile-calculator', 'title' => 'Tile Calculator', 'description' => 'Tiles and boxes for a floor or wall'],
            ['slug' => 'tonnage-calculator', 'title' => 'Tonnage Calculator', 'description' => 'Tons of any bulk material'],
            ['slug' => 'vinyl-fence-calculator', 'title' => 'Vinyl Fence Calculator', 'description' => 'Panels, posts and concrete'],
            ['slug' => 'vinyl-siding-calculator', 'title' => 'Vinyl Siding Calculator', 'description' => 'Squares, boxes and trim'],
            ['slug' => 'wall-square-footage-calculator', 'title' => 'Wall Square Footage Calculator', 'description' => 'Net wall area less openings'],
            ['slug' => 'excavation-calculator', 'title' => 'Excavation Calculator', 'description' => 'Bank and loose volume, truckloads'],
        ],
    ],
    [
        'slug' => 'cement-and-concrete',
        'title' => 'Cement and Concrete',
        'description' => 'Concrete volumes, bags, blocks, mortar and grout',
        'tools' => [
            ['slug' => 'cement-calculator', 'title' => 'Cement Calculator', 'description' => 'Cement, sand and aggregate for a mix'],
            ['slug' => 'concrete-calculator', 'title' => 'Concrete Calculator', 'description' => 'Slabs, footings, columns, curbs and bags'],
            ['slug' => 'concrete-block-calculator', 'title' => 'Concrete Block Calculator', 'description' => 'Blocks and mortar for a wall'],
            ['slug' => 'concrete-block-fill-calculator', 'title' => 'Concrete Block Fill Calculator', 'description' => 'Grout to fill block cores'],
            ['slug' => 'concrete-column-calculator', 'title' => 'Concrete Column Calculator', 'description' => 'Round and square columns'],
            ['slug' => 'concrete-stairs-calculator', 'title' => 'Concrete Stairs Calculator', 'description' => 'Concrete for a flight of steps'],
            ['slug' => 'concrete-weight-calculator', 'title' => 'Concrete Weight Calculator', 'description' => 'Weight by concrete type'],
            ['slug' => 'grout-calculator', 'title' => 'Grout Calculator', 'description' => 'Tile grout by joint size'],
            ['slug' => 'hole-volume-calculator', 'title' => 'Hole Volume Calculator', 'description' => 'Post holes and concrete'],
            ['slug' => 'mortar-calculator', 'title' => 'Mortar Calculator', 'description' => 'Mortar for brick and block, by type'],
            ['slug' => 'thinset-calculator', 'title' => 'Thinset Calculator', 'description' => 'Thinset bags by trowel size'],
        ],
    ],
    [
        'slug' => 'home-and-garden',
        'title' => 'Home and Garden',
        'description' => 'Flooring, paint, stairs, fences, heating and cooling',
        'tools' => [
            ['slug' => 'air-conditioner-btu-calculator', 'title' => 'Air Conditioner BTU Calculator', 'description' => 'Cooling load from heat gains'],
            ['slug' => 'ac-tonnage-calculator', 'title' => 'AC Tonnage Calculator', 'description' => 'Air conditioner tons'],
            ['slug' => 'air-changes-per-hour-calculator', 'title' => 'Air Changes per Hour Calculator', 'description' => 'ACH ⇄ CFM for a room'],
            ['slug' => 'arch-calculator', 'title' => 'Arch Calculator', 'description' => 'Radius, arc length and area of an arch'],
            ['slug' => 'boiler-size-calculator', 'title' => 'Boiler Size Calculator', 'description' => 'Boiler output from heat loss'],
            ['slug' => 'carpet-calculator', 'title' => 'Carpet Calculator', 'description' => 'Carpet, seams and pad'],
            ['slug' => 'clearance-hole-calculator', 'title' => 'Clearance Hole Calculator', 'description' => 'Drill size for a bolt to pass'],
            ['slug' => 'deck-stain-calculator', 'title' => 'Deck Stain Calculator', 'description' => 'Gallons of deck stain'],
            ['slug' => 'epoxy-calculator', 'title' => 'Epoxy Calculator', 'description' => 'Epoxy resin and hardener'],
            ['slug' => 'fence-calculator', 'title' => 'Fence Calculator', 'description' => 'Posts, rails, pickets and perimeter'],
            ['slug' => 'fence-post-depth-calculator', 'title' => 'Fence Post Depth Calculator', 'description' => 'Hole depth and concrete'],
            ['slug' => 'floor-area-ratio-calculator', 'title' => 'Floor Area Ratio Calculator', 'description' => 'FAR and allowed floor area'],
            ['slug' => 'flooring-calculator', 'title' => 'Flooring Calculator', 'description' => 'Boxes of flooring with waste'],
            ['slug' => 'furnace-size-calculator', 'title' => 'Furnace Size Calculator', 'description' => 'Furnace input from heat loss'],
            ['slug' => 'heat-loss-calculator', 'title' => 'Heat Loss Calculator', 'description' => 'Building heat loss in BTU/h'],
            ['slug' => 'hoop-house-calculator', 'title' => 'Hoop House Calculator', 'description' => 'Hoops and plastic for a hoop house'],
            ['slug' => 'ladder-angle-calculator', 'title' => 'Ladder Angle Calculator', 'description' => 'Angle and the 4 : 1 rule'],
            ['slug' => 'paint-calculator', 'title' => 'Paint Calculator', 'description' => 'Gallons of paint for walls'],
            ['slug' => 'paver-calculator', 'title' => 'Paver Calculator', 'description' => 'Pavers, base and sand'],
            ['slug' => 'paver-sand-calculator', 'title' => 'Paver Sand Calculator', 'description' => 'Bedding and joint sand'],
            ['slug' => 'plywood-calculator', 'title' => 'Plywood Calculator', 'description' => 'Sheets for floors, walls and roofs'],
            ['slug' => 'ramp-calculator', 'title' => 'Ramp Calculator', 'description' => 'Ramp length and ADA check'],
            ['slug' => 'shiplap-calculator', 'title' => 'Shiplap Calculator', 'description' => 'Shiplap boards for walls'],
            ['slug' => 'siding-calculator', 'title' => 'Siding Calculator', 'description' => 'Siding squares and pieces'],
            ['slug' => 'stair-carpet-calculator', 'title' => 'Stair Carpet Calculator', 'description' => 'Carpet for a staircase'],
            ['slug' => 'stair-calculator', 'title' => 'Stair Calculator', 'description' => 'Risers, treads, stringers and code check'],
            ['slug' => 'wainscoting-calculator', 'title' => 'Wainscoting Calculator', 'description' => 'Panels and trim for wainscoting'],
            ['slug' => 'wallpaper-calculator', 'title' => 'Wallpaper Calculator', 'description' => 'Rolls of wallpaper with repeat'],
            ['slug' => 'stucco-calculator', 'title' => 'Stucco Calculator', 'description' => 'Stucco bags and lath'],
            ['slug' => 'trim-and-baseboard-calculator', 'title' => 'Trim and Baseboard Calculator', 'description' => 'Pieces of trim for rooms'],
        ],
    ],
    [
        'slug' => 'roofing',
        'title' => 'Roofing',
        'description' => 'Pitch, rafters, trusses and roofing materials',
        'tools' => [
            ['slug' => 'birdsmouth-cut-calculator', 'title' => 'Birdsmouth Cut Calculator', 'description' => 'Seat and plumb cuts for a rafter'],
            ['slug' => 'gambrel-roof-calculator', 'title' => 'Gambrel Roof Calculator', 'description' => 'Rafters and area of a gambrel roof'],
            ['slug' => 'metal-roof-cost-calculator', 'title' => 'Metal Roof Cost Calculator', 'description' => 'Panels, screws and cost'],
            ['slug' => 'rafter-length-calculator', 'title' => 'Rafter Length Calculator', 'description' => 'Rafter length with overhang'],
            ['slug' => 'roofing-calculator', 'title' => 'Roofing Calculator', 'description' => 'Squares, bundles and underlayment'],
            ['slug' => 'roof-pitch-calculator', 'title' => 'Roof Pitch Calculator', 'description' => 'Pitch ⇄ angle ⇄ percent'],
            ['slug' => 'roof-truss-calculator', 'title' => 'Roof Truss Calculator', 'description' => 'Truss count and member lengths'],
        ],
    ],
    [
        'slug' => 'driveway',
        'title' => 'Driveway',
        'description' => 'Asphalt, concrete, gravel and base for driveways',
        'tools' => [
            ['slug' => 'asphalt-calculator', 'title' => 'Asphalt Calculator', 'description' => 'Tons of asphalt for paving'],
            ['slug' => 'concrete-driveway-cost-calculator', 'title' => 'Concrete Driveway Cost Calculator', 'description' => 'Concrete and cost of a driveway'],
            ['slug' => 'crushed-stone-calculator', 'title' => 'Crushed Stone Calculator', 'description' => 'Tons of crushed stone'],
            ['slug' => 'gravel-driveway-calculator', 'title' => 'Gravel Driveway Calculator', 'description' => 'Tons for each driveway layer'],
            ['slug' => 'road-base-calculator', 'title' => 'Road Base Calculator', 'description' => 'Compacted road base tons'],
        ],
    ],
    [
        'slug' => 'water-tanks-and-vessels',
        'title' => 'Water Tanks and Vessels',
        'description' => 'Tanks, pools, ponds, pipes and flow rate',
        'tools' => [
            ['slug' => 'gallons-per-minute-calculator', 'title' => 'Gallons Per Minute Calculator (GPM)', 'description' => 'GPM and liters per minute'],
            ['slug' => 'pipe-volume-calculator', 'title' => 'Pipe Volume Calculator', 'description' => 'Water a pipe holds'],
            ['slug' => 'pond-calculator', 'title' => 'Pond Calculator', 'description' => 'Pond volume, liner and pump'],
            ['slug' => 'pool-calculator', 'title' => 'Pool Calculator', 'description' => 'Pool volume and fill time'],
            ['slug' => 'round-pool-volume-calculator', 'title' => 'Round Pool Volume Calculator', 'description' => 'Gallons in a round pool'],
            ['slug' => 'tank-volume-calculator', 'title' => 'Tank Volume Calculator', 'description' => 'Tank capacity and fill level'],
        ],
    ],
    [
        'slug' => 'materials-specifications',
        'title' => 'Materials Specifications',
        'description' => 'Beams, fasteners, machining, welding, electrical and insulation',
        'tools' => [
            ['slug' => 'beam-deflection-calculator', 'title' => 'Beam Deflection Calculator', 'description' => 'Deflection and moment of a beam'],
            ['slug' => 'bending-stress-calculator', 'title' => 'Bending Stress Calculator', 'description' => 'σ = M ÷ S for common sections'],
            ['slug' => 'bolt-torque-calculator', 'title' => 'Bolt Torque Calculator', 'description' => 'Tightening torque and clamp load'],
            ['slug' => 'box-fill-calculator', 'title' => 'Box Fill Calculator', 'description' => 'NEC electrical box volume'],
            ['slug' => 'carbon-equivalent-calculator', 'title' => 'Carbon Equivalent Calculator', 'description' => 'CE (IIW) and Pcm of a steel'],
            ['slug' => 'cfm-calculator', 'title' => 'CFM Calculator', 'description' => 'Airflow from ACH or duct velocity'],
            ['slug' => 'fence-stain-calculator', 'title' => 'Fence Stain Calculator', 'description' => 'Gallons of fence stain'],
            ['slug' => 'insulation-calculator', 'title' => 'Insulation Calculator', 'description' => 'Thickness for a target R-value'],
            ['slug' => 'junction-box-sizing-calculator', 'title' => 'Junction Box Sizing Calculator', 'description' => 'NEC 314.28 pull box size'],
            ['slug' => 'k-factor-calculator', 'title' => 'K-Factor Calculator', 'description' => 'Sheet metal K-factor and bend allowance'],
            ['slug' => 'material-removal-rate-calculator', 'title' => 'Material Removal Rate Calculator', 'description' => 'MRR for milling, turning and drilling'],
            ['slug' => 'pitch-diameter-calculator', 'title' => 'Pitch Diameter Calculator', 'description' => 'Thread and gear pitch diameter'],
            ['slug' => 'punch-force-calculator', 'title' => 'Punch Force Calculator', 'description' => 'Tonnage to punch a hole'],
            ['slug' => 'rivet-size-calculator', 'title' => 'Rivet Size Calculator', 'description' => 'Rivet diameter, length and spacing'],
            ['slug' => 'spindle-speed-calculator', 'title' => 'Spindle Speed Calculator', 'description' => 'RPM and feed rate'],
            ['slug' => 'taper-calculator', 'title' => 'Taper Calculator', 'description' => 'Taper per inch and angle'],
            ['slug' => 'thread-calculator', 'title' => 'Thread Calculator', 'description' => 'Unified and metric thread dimensions'],
            ['slug' => 'thread-pitch-calculator', 'title' => 'Thread Pitch Calculator', 'description' => 'TPI ⇄ pitch'],
            ['slug' => 'true-position-calculator', 'title' => 'True Position Calculator', 'description' => 'GD&T position and bonus tolerance'],
            ['slug' => 'welding-calculator', 'title' => 'Welding Calculator', 'description' => 'Fillet weld strength and filler metal'],
            ['slug' => 'voltage-drop-calculator', 'title' => 'Voltage Drop Calculator', 'description' => 'Voltage drop in a circuit'],
            ['slug' => 'wire-size-calculator', 'title' => 'Wire Size Calculator', 'description' => 'AWG for a load and distance'],
            ['slug' => 'conduit-fill-calculator', 'title' => 'Conduit Fill Calculator', 'description' => 'NEC conduit fill percent'],
        ],
    ],
    [
        'slug' => 'other',
        'title' => 'Other',
        'description' => 'Angles, cuts, grades, curves and layouts',
        'tools' => [
            ['slug' => 'angle-cut-calculator', 'title' => 'Angle Cut Calculator', 'description' => 'Miter and bevel for polygons and crown'],
            ['slug' => 'angle-of-depression-calculator', 'title' => 'Angle of Depression Calculator', 'description' => 'Angle, height and distance'],
            ['slug' => 'bolt-circle-calculator', 'title' => 'Bolt Circle Calculator', 'description' => 'Hole coordinates on a circle'],
            ['slug' => 'bowl-segment-calculator', 'title' => 'Bowl Segment Calculator', 'description' => 'Segmented bowl ring cuts'],
            ['slug' => 'countersink-depth-calculator', 'title' => 'Countersink Depth Calculator', 'description' => 'Depth for a countersink diameter'],
            ['slug' => 'elevation-grade-calculator', 'title' => 'Elevation Grade Calculator', 'description' => 'Grade %, angle and ratio'],
            ['slug' => 'miter-angle-calculator', 'title' => 'Miter Angle Calculator', 'description' => 'Miter angle for any corner'],
            ['slug' => 'round-pen-calculator', 'title' => 'Round Pen Calculator', 'description' => 'Panels for a round pen'],
            ['slug' => 'vertical-curve-calculator', 'title' => 'Vertical Curve Calculator', 'description' => 'Elevations on a road curve'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "construction.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "construction.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
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
