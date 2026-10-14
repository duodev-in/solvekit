@php
    $lengthUnits = collect(config('units.length'))->only(['mm', 'cm', 'm', 'in', 'ft', 'yd'])->all();
    $volumeUnits = config('units.volume') + ['cm3' => ['name' => 'Cubic centimeters', 'symbol' => 'cm³', 'factor' => 0.001]];
    $options = collect($lengthUnits)->mapWithKeys(fn ($unit, $key) => [$key => $unit['symbol']])->all();
    $rows = collect(['m3', 'yd3', 'in3', 'l', 'gal_us'])->mapWithKeys(fn ($key) => [$key => ['label' => $volumeUnits[$key]['name'], 'unit' => $volumeUnits[$key]['symbol']]])->all();
@endphp

<x-calc.page
    title="Cubic Feet Calculator - SolveKit"
    description="Professional cubic feet calculator to calculate volume in ft³ from length, width, and height dimensions. Perfect for construction and storage calculations."
    lede="Find the volume of a box, room or container from its length, width and height."
    about="Volume is length × width × height. Each dimension is converted to meters first, so you can mix units, then the volume is converted to cubic feet and the other units listed."
    :calc="['engine' => 'box-volume', 'lengthUnits' => $lengthUnits, 'volumeUnits' => $volumeUnits, 'primary' => 'ft3', 'rows' => array_keys($rows)]"
    :how-to="[
        ['name' => 'Measure the three sides', 'text' => 'Enter length, width and height and choose each one\'s unit.'],
        ['name' => 'Read the volume', 'text' => 'Cubic feet are shown first, with other units beside them.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate cubic feet?', 'answer' => 'Multiply length × width × height, all in feet. A 10 ft × 8 ft × 4 ft space is 320 ft³.'],
        ['question' => 'How many gallons are in a cubic foot?', 'answer' => 'One cubic foot holds 7.48052 US gallons, or 28.317 liters.'],
        ['question' => 'How do I measure in inches?', 'answer' => 'Set each dimension\'s unit to inches. The calculator converts them before multiplying, so mixed units work.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        @foreach(['length' => ['Length', 10], 'width' => ['Width', 8], 'height' => ['Height', 4]] as $name => [$fieldLabel, $default])
            <x-calc.field :name="$name" :label="$fieldLabel" :value="$default" min="0" placeholder="0">
                <label for="calc-{{ $name }}-unit" class="sr-only">{{ $fieldLabel }} unit</label>
                <select id="calc-{{ $name }}-unit" name="{{ $name }}-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach($options as $key => $symbol)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $symbol }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        @endforeach
    </div>

    <x-calc.result label="Cubic feet" />

    <x-calc.options :examples="['Moving box 18×18×24 in' => ['length' => 18, 'width' => 18, 'height' => 24, 'length-unit' => 'in', 'width-unit' => 'in', 'height-unit' => 'in'], 'Room 12×10×8 ft' => ['length' => 12, 'width' => 10, 'height' => 8, 'length-unit' => 'ft', 'width-unit' => 'ft', 'height-unit' => 'ft']]" />

    <x-slot:panel>
        <x-calc.rows heading="Same volume in" :rows="$rows" />
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = length × width × height</li>
            <li>1 ft³ = 0.028316846592 m³ · 1 m³ = 1,000 L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
