<x-calc.page
    title="Wheel Offset Calculator - SolveKit"
    description="Free wheel offset calculator: backspacing from wheel width and offset, and how far the inner and outer edges move with a new wheel."
    lede="Convert offset to backspacing and compare two wheels."
    about="Offset is the distance from the wheel's center line to its mounting face (positive toward the street side). Backspacing = width ÷ 2 + offset, measured from the mounting face to the inner edge. Wheel width here is the bead-seat width; add about ¼–½ in of lip for a measured backspacing. A new wheel moves the inner edge by the change in backspacing and the outer edge by the change in front spacing."
    :calc="['engine' => 'ev-transport', 'tool' => 'wheel_offset', 'fields' => ['width', 'offset', 'width2', 'offset2'], 'unitFields' => ['width' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'offset' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'width2' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'offset2' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter width and offset', 'text' => 'From the wheel, e.g. 8J ET35.'],
        ['name' => 'Compare a new wheel', 'text' => 'To see clearance changes.'],
    ]"
    :faqs="[
        ['question' => 'What is the backspacing of an 8 in wheel at +35 mm?', 'answer' => '5.38 in.'],
        ['question' => 'Does lower offset push the wheel out?', 'answer' => 'Yes, lower or negative offset moves the wheel outward.'],
        ['question' => 'What is ET?', 'answer' => 'The German abbreviation for offset (Einpresstiefe), in mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Wheel width" value="8" min="0" placeholder="Wheel width">
            <label for="calc-width-unit" class="sr-only">Wheel width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="offset" label="Offset" value="35" placeholder="Offset">
            <label for="calc-offset-unit" class="sr-only">Offset unit</label>
            <select id="calc-offset-unit" name="offset-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width2" label="New wheel width (optional)" value="9" min="0" placeholder="New wheel width (optional)">
            <label for="calc-width2-unit" class="sr-only">New wheel width (optional) unit</label>
            <select id="calc-width2-unit" name="width2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="offset2" label="New offset" value="20" placeholder="New offset">
            <label for="calc-offset2-unit" class="sr-only">New offset unit</label>
            <select id="calc-offset2-unit" name="offset2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Backspacing" />

    <x-calc.options :examples="[
        '8 in ET35 → 9 in ET20' => ['width' => 8, 'width-unit' => 'in', 'offset' => 35, 'offset-unit' => 'mm', 'width2' => 9, 'width2-unit' => 'in', 'offset2' => 20, 'offset2-unit' => 'mm'],
        'Truck 9 in −12' => ['width' => 9, 'width-unit' => 'in', 'offset' => -12, 'offset-unit' => 'mm', 'width2' => '', 'width2-unit' => 'in', 'offset2' => '', 'offset2-unit' => 'mm'],
        '7.5 in +45' => ['width' => 7.5, 'width-unit' => 'in', 'offset' => 45, 'offset-unit' => 'mm', 'width2' => 8, 'width2-unit' => 'in', 'offset2' => 40, 'offset2-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'front' => ['label' => 'Front spacing'],
            'compare' => ['label' => 'New wheel'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>backspacing = width ÷ 2 + offset</li>
            <li>front spacing = width ÷ 2 − offset</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
