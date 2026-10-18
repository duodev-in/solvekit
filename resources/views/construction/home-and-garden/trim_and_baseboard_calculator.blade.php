<x-calc.page
    title="Trim and Baseboard Calculator - SolveKit"
    description="Free trim and baseboard calculator: linear feet and pieces of baseboard, crown or other trim for rooms, less doors."
    lede="Work out the baseboard or trim pieces for rooms."
    about="Trim runs the room perimeter, 2 × (length + width), less the width of each door. Add about 10% for miter cuts and short offcuts, then divide by the piece length you buy (often 8, 12 or 16 ft)."
    :calc="['engine' => 'con-finish', 'tool' => 'trim', 'fields' => ['rooms', 'rooms_unit', 'doors', 'door_width', 'piece', 'waste', 'price'], 'unitFields' => ['door_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'piece' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['rooms' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each room', 'text' => 'Length and width.'],
        ['name' => 'Subtract doors', 'text' => 'And choose the piece length.'],
    ]"
    :faqs="[
        ['question' => 'How much baseboard for a 12 × 14 room?', 'answer' => '52 ft of perimeter, 49 ft less one door, so five 12 ft pieces with 10% extra.'],
        ['question' => 'Do I subtract doors for crown molding?', 'answer' => 'No: crown runs the full perimeter; set doors to 0.'],
        ['question' => 'Why add 10%?', 'answer' => 'For miters and offcuts that are too short to use.'],
    ]"
>
    <x-calc.rows-editor name="rooms" label="Rooms" :columns="['length' => 'Length', 'width' => 'Width']" :rows="[[12, 14], [10, 12]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add room" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="doors" label="Doors" value="2" min="0" step="1" />
        <x-calc.field name="door_width" label="Door width" value="36" min="0" placeholder="Door width">
            <label for="calc-door_width-unit" class="sr-only">Door width unit</label>
            <select id="calc-door_width-unit" name="door_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="piece" label="Piece length" value="12" min="0" placeholder="Piece length">
            <label for="calc-piece-unit" class="sr-only">Piece length unit</label>
            <select id="calc-piece-unit" name="piece-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per piece (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Trim pieces" />

    <x-calc.options :examples="[
        'Two rooms' => ['rooms' => '12 14
10 12', 'rooms_unit' => 'ft', 'doors' => 2, 'door_width' => 36, 'door_width-unit' => 'in', 'piece' => 12, 'piece-unit' => 'ft', 'waste' => 10],
        'Crown, one room' => ['rooms' => '16 14', 'rooms_unit' => 'ft', 'doors' => 0, 'door_width' => 36, 'door_width-unit' => 'in', 'piece' => 16, 'piece-unit' => 'ft', 'waste' => 15],
        'Metric' => ['rooms' => '4 3.5', 'rooms_unit' => 'm', 'doors' => 1, 'door_width' => 0.9, 'door_width-unit' => 'm', 'piece' => 2.4, 'piece-unit' => 'm', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'linear' => ['label' => 'Linear length'],
            'perimeter' => ['label' => 'Perimeter'],
            'corners' => ['label' => 'Corners'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>trim = Σ 2(L + W) − doors × door width</li>
            <li>pieces = ⌈trim × (1 + waste) ÷ piece length⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
