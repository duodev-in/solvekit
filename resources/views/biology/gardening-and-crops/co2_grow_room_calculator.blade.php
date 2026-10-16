<x-calc.page
    title="CO2 Grow Room Calculator - SolveKit"
    description="Free CO₂ grow room calculator: how much CO₂ raises a grow room to a target ppm."
    lede="Work out how much CO₂ raises a grow room to a target ppm."
    about="The CO₂ to add is the room volume times the rise in concentration (target minus ambient, in ppm ÷ 1,000,000). Leaks and plant uptake mean real rooms need topping up over time."
    :calc="['engine' => 'garden', 'tool' => 'co2', 'fields' => ['length', 'width', 'height', 'target', 'ambient'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the room size', 'text' => 'Inside length, width and height.'],
        ['name' => 'Enter the CO₂ levels', 'text' => 'Outdoor air is about 420 ppm.'],
    ]"
    :faqs="[
        ['question' => 'What CO₂ level is best for plants?', 'answer' => 'Many growers target 1,000 to 1,500 ppm during lights-on.'],
        ['question' => 'Is high CO₂ dangerous?', 'answer' => 'Levels above 5,000 ppm are unsafe for people; use a monitor and ventilate before entering.'],
        ['question' => 'Does CO₂ help without strong light?', 'answer' => 'Little; enrichment pays off only with high light intensity.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="10" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="10" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="8" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Target CO₂" value="1200" min="0" suffix="ppm" />
        <x-calc.field name="ambient" label="Ambient CO₂" value="420" min="0" suffix="ppm" />
    </div>

    <x-calc.result label="CO₂ to add" />

    <x-calc.options :examples="[
        'Tent 4 × 4 × 6.5 ft' => ['length' => 4, 'width' => 4, 'height' => 6.5, 'target' => 1200, 'ambient' => 420],
        'Room 12 × 10 × 8 ft' => ['length' => 12, 'width' => 10, 'height' => 8, 'target' => 1500, 'ambient' => 420],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters', 'unit' => 'L'],
            'kg' => ['label' => 'Kilograms', 'unit' => 'kg'],
            'lb' => ['label' => 'Pounds', 'unit' => 'lb'],
            'room' => ['label' => 'Room volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CO₂ = room volume × (target − ambient) ÷ 10⁶</li>
            <li>CO₂ density ≈ 1.84 kg/m³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
