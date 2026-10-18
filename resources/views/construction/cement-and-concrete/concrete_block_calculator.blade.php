<x-calc.page
    title="Concrete Block Calculator - SolveKit"
    description="Free concrete block calculator: number of CMU blocks for a wall, by block size, with courses and cost."
    lede="Work out how many concrete blocks a wall needs."
    about="Concrete blocks are sized nominally, including a ⅜ in mortar joint: a standard block is 8 × 16 in, so 1.125 blocks cover a square foot. Subtract door and window openings and add a few percent for cuts and breakage. For mortar use the Mortar Calculator and for core fill the Block Fill Calculator."
    :calc="['engine' => 'con-concrete', 'tool' => 'block', 'fields' => ['length', 'height', 'block', 'openings', 'waste', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the wall size', 'text' => 'Length and height.'],
        ['name' => 'Subtract openings', 'text' => 'Doors and windows.'],
        ['name' => 'Pick the block size', 'text' => 'Nominal size, including the joint.'],
    ]"
    :faqs="[
        ['question' => 'How many blocks in a square foot?', 'answer' => '1.125 standard 8 × 16 in blocks.'],
        ['question' => 'How many blocks for a 40 × 8 ft wall?', 'answer' => '360 blocks before waste.'],
        ['question' => 'What is nominal size?', 'answer' => 'The actual block size plus a ⅜ in joint: an 8 × 16 block is 7⅝ × 15⅝ in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Wall length" value="40" min="0" placeholder="Wall length">
            <label for="calc-length-unit" class="sr-only">Wall length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Wall height" value="8" min="0" placeholder="Wall height">
            <label for="calc-height-unit" class="sr-only">Wall height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="block" label="Block face (nominal)" :options="['16x8' => '16 × 8 in (standard)', '16x4' => '16 × 4 in (half-high)', '8x8' => '8 × 8 in (half block)', '12x4' => '12 × 4 in', '24x8' => '24 × 8 in']" selected="16x8" />
        <x-calc.field name="openings" label="Openings (optional)" value="" min="0" placeholder="Openings (optional)">
            <label for="calc-openings-unit" class="sr-only">Openings (optional) unit</label>
            <select id="calc-openings-unit" name="openings-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for cuts and breakage" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per block (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Blocks needed" />

    <x-calc.options :examples="[
        'Wall 40 × 8 ft' => ['length' => 40, 'length-unit' => 'ft', 'height' => 8, 'height-unit' => 'ft', 'block' => '16x8', 'waste' => 5],
        'Garage wall with a door' => ['length' => 24, 'length-unit' => 'ft', 'height' => 10, 'height-unit' => 'ft', 'block' => '16x8', 'openings' => 63, 'openings-unit' => 'ft2', 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Wall area'],
            'courses' => ['label' => 'Courses'],
            'per_ft2' => ['label' => 'Blocks per area'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>blocks = net area ÷ (nominal length × nominal height) × (1 + waste)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
