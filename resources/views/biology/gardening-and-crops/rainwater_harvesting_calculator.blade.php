<x-calc.page
    title="Rainwater Harvesting Calculator - SolveKit"
    description="Free rainwater harvesting calculator: gallons and liters collected from a roof for a rainfall amount."
    lede="Work out how much rainwater a roof can collect."
    about="Every square foot of roof yields 0.623 US gallons per inch of rain. Real systems capture about 75 to 90% after splashing, evaporation and the first-flush diverter."
    :calc="['engine' => 'garden', 'tool' => 'rainwater', 'fields' => ['area', 'rain', 'efficiency'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'rain' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the roof footprint', 'text' => 'The area the roof covers seen from above, not the sloped surface.'],
        ['name' => 'Enter the rainfall', 'text' => 'For one storm, a month or a year.'],
    ]"
    :faqs="[
        ['question' => 'How much water from 1 inch of rain on 1,000 ft²?', 'answer' => 'About 623 US gallons before losses.'],
        ['question' => 'Should I use the sloped roof area?', 'answer' => 'No, use the flat footprint; slope does not catch more rain.'],
        ['question' => 'Is harvested rainwater drinkable?', 'answer' => 'Not without proper filtration and treatment.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="area" label="Roof area (footprint)" value="1500" min="0" placeholder="Roof area (footprint)">
            <label for="calc-area-unit" class="sr-only">Roof area (footprint) unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rain" label="Rainfall" value="1" min="0" placeholder="Rainfall">
            <label for="calc-rain-unit" class="sr-only">Rainfall unit</label>
            <select id="calc-rain-unit" name="rain-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="efficiency" label="Capture efficiency" value="80" min="1" max="100" suffix="%" />
    </div>

    <x-calc.result label="Water collected" />

    <x-calc.options :examples="[
        'House 2,000 ft², 1 in' => ['area' => 2000, 'area-unit' => 'ft2', 'rain' => 1, 'efficiency' => 80],
        'Shed 100 ft², 30 in/year' => ['area' => 100, 'area-unit' => 'ft2', 'rain' => 30, 'efficiency' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters', 'unit' => 'L'],
            'ft3' => ['label' => 'Cubic feet', 'unit' => 'ft³'],
            'barrels' => ['label' => 'Rain barrels'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gallons = area (ft²) × rain (in) × 0.623 × efficiency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
