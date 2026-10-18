<x-calc.page
    title="Drywall Calculator - SolveKit"
    description="Free drywall calculator: sheets of drywall for walls and ceilings, less doors and windows, with screws and joint tape."
    lede="Work out the drywall sheets, screws and tape for a room."
    about="Sheets = net area × (1 + waste) ÷ sheet area. Screws are counted at the IRC Table R702.3.5 spacing (16 in on walls, 12 in on ceilings) along each framing member at your stud spacing. Joint tape is about half the sheet perimeter per sheet, since each joint is shared by two sheets."
    :calc="['engine' => 'con-finish', 'tool' => 'drywall', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'ceiling', 'sheet', 'spacing', 'waste', 'price'], 'unitFields' => ['ceiling' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Add doors and windows', 'text' => 'Width, height and how many.'],
        ['name' => 'Add the ceiling', 'text' => 'Its area, if you are boarding it.'],
    ]"
    :faqs="[
        ['question' => 'How many sheets of drywall for a 12 × 14 room?', 'answer' => '19 sheets of 4 × 8 with 10% waste: 13 for the 8 ft walls (less a door and two windows) and 6 for the ceiling.'],
        ['question' => 'How many screws per sheet?', 'answer' => 'About 28 on a 4 × 8 wall sheet with studs 16 in on center.'],
        ['question' => 'Should I hang drywall horizontally?', 'answer' => 'On walls, horizontal sheets usually mean fewer and lower joints.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[12, 8], [14, 8], [12, 8], [14, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 1], [3, 4, 2]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ceiling" label="Ceiling area (optional)" value="168" min="0" placeholder="Ceiling area (optional)">
            <label for="calc-ceiling-unit" class="sr-only">Ceiling area (optional) unit</label>
            <select id="calc-ceiling-unit" name="ceiling-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="sheet" label="Sheet size" :options="['4x8' => '4 × 8 ft', '4x10' => '4 × 10 ft', '4x12' => '4 × 12 ft', '4.5x12' => '54 in × 12 ft']" selected="4x8" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spacing" label="Stud spacing" value="16" min="0" placeholder="Stud spacing">
            <label for="calc-spacing-unit" class="sr-only">Stud spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per sheet (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Drywall sheets" />

    <x-calc.options :examples="[
        '12 × 14 room with ceiling' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 2', 'openings_unit' => 'ft', 'ceiling' => 168, 'ceiling-unit' => 'ft2', 'sheet' => '4x8', 'spacing' => 16, 'spacing-unit' => 'in', 'waste' => 10],
        'Walls only, 4 × 12 sheets' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 2', 'openings_unit' => 'ft', 'ceiling' => '', 'sheet' => '4x12', 'spacing' => 16, 'spacing-unit' => 'in', 'waste' => 10],
        'Metric room' => ['walls' => '4 2.5
3.5 2.5
4 2.5
3.5 2.5', 'walls_unit' => 'm', 'openings' => '0.9 2.1 1
1.2 1.2 1', 'openings_unit' => 'm', 'ceiling' => 14, 'ceiling-unit' => 'm2', 'sheet' => '4x8', 'spacing' => 400, 'spacing-unit' => 'mm', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Area'],
            'screws' => ['label' => 'Screws'],
            'tape' => ['label' => 'Joint tape'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sheets = net area × (1 + waste) ÷ sheet area</li>
            <li>screws per sheet = members × (length ÷ spacing + 1)</li>
            <li>tape ≈ sheets × (width + length)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
