@php
    $lengthUnits = collect(config('units.length'))->only(['mm', 'cm', 'm', 'in', 'ft', 'yd'])->all();
    $volumeUnits = config('units.volume') + ['cm3' => ['name' => 'Cubic centimeters', 'symbol' => 'cm³', 'factor' => 0.001]];
    $options = collect($lengthUnits)->mapWithKeys(fn ($unit, $key) => [$key => $unit['symbol']])->all();
    $rows = collect(['l', 'cm3', 'ft3', 'yd3', 'gal_us'])->mapWithKeys(fn ($key) => [$key => ['label' => $volumeUnits[$key]['name'], 'unit' => $volumeUnits[$key]['symbol']]])->all();
@endphp

<x-calc.page
    title="Cubic Meter Calculator - SolveKit"
    description="Professional cubic meter calculator to calculate volume in m³ from length, width, and height dimensions. Perfect for metric volume calculations."
    lede="Find the volume of a box, room or container from its length, width and height."
    about="Volume is length × width × height. Each dimension is converted to meters first, so you can mix units, then the volume is converted to cubic meters and the other units listed."
    :calc="['engine' => 'box-volume', 'lengthUnits' => $lengthUnits, 'volumeUnits' => $volumeUnits, 'primary' => 'm3', 'rows' => array_keys($rows)]"
    :how-to="[
        ['name' => 'Measure the three sides', 'text' => 'Enter length, width and height and choose each one\'s unit.'],
        ['name' => 'Read the volume', 'text' => 'Cubic meters are shown first, with other units beside them.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate cubic meters?', 'answer' => 'Multiply length × width × height, all in meters. A 2 m × 1.5 m × 1 m box is 3 m³.'],
        ['question' => 'How many liters are in a cubic meter?', 'answer' => 'Exactly 1,000 liters.'],
        ['question' => 'Can I enter centimeters?', 'answer' => 'Yes. Set each dimension\'s unit; mixed units are converted before multiplying.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        @foreach(['length' => ['Length', 2], 'width' => ['Width', 1.5], 'height' => ['Height', 1]] as $name => [$fieldLabel, $default])
            <x-calc.field :name="$name" :label="$fieldLabel" :value="$default" min="0" placeholder="0">
                <label for="calc-{{ $name }}-unit" class="sr-only">{{ $fieldLabel }} unit</label>
                <select id="calc-{{ $name }}-unit" name="{{ $name }}-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach($options as $key => $symbol)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $symbol }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        @endforeach
    </div>

    <x-calc.result label="Cubic meters" />

    <x-calc.options :examples="['Shipping crate 120×80×100 cm' => ['length' => 120, 'width' => 80, 'height' => 100, 'length-unit' => 'cm', 'width-unit' => 'cm', 'height-unit' => 'cm'], 'Skip 3×1.8×1 m' => ['length' => 3, 'width' => 1.8, 'height' => 1, 'length-unit' => 'm', 'width-unit' => 'm', 'height-unit' => 'm']]" />

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
