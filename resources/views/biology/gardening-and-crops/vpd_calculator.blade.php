<x-calc.page
    title="VPD Calculator - SolveKit"
    description="Free VPD calculator: vapor pressure deficit in kPa from air temperature, humidity and leaf temperature."
    lede="Work out the vapor pressure deficit (VPD) for your grow room."
    about="VPD is how much more water vapor the air at the leaf could hold. It uses the Tetens equation for saturation vapor pressure; leaves usually run 1 to 3 °C cooler than the air, which lowers VPD."
    :calc="['engine' => 'garden', 'tool' => 'vpd', 'fields' => ['temp', 'humidity', 'offset'], 'unitFields' => ['temp' => collect(config('units.temperature'))->only(['c', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter air temperature and humidity', 'text' => 'At canopy height.'],
        ['name' => 'Enter the leaf offset', 'text' => 'Leaf temperature minus air temperature; −2 °C if unsure.'],
    ]"
    :faqs="[
        ['question' => 'What is a good VPD?', 'answer' => 'About 0.4 to 0.8 kPa for clones, 0.8 to 1.2 for vegetative growth and 1.2 to 1.6 for flowering.'],
        ['question' => 'How do I raise VPD?', 'answer' => 'Lower the humidity or raise the temperature.'],
        ['question' => 'Why does leaf temperature matter?', 'answer' => 'Transpiring leaves are cooler than the air, so their vapor pressure is lower.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="temp" label="Air temperature" value="25" placeholder="Air temperature">
            <label for="calc-temp-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-temp-unit" name="temp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="humidity" label="Relative humidity" value="60" min="0" max="100" suffix="%" />
        <x-calc.field name="offset" label="Leaf offset" value="-2" step="0.5" suffix="°C" />
    </div>

    <x-calc.result label="Vapor pressure deficit" />

    <x-calc.options :examples="[
        'Veg 26 °C, 65%' => ['temp' => 26, 'humidity' => 65, 'offset' => -2],
        'Flower 24 °C, 50%' => ['temp' => 24, 'humidity' => 50, 'offset' => -2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'svp_air' => ['label' => 'Saturation pressure (air)'],
            'svp_leaf' => ['label' => 'Saturation pressure (leaf)'],
            'avp' => ['label' => 'Actual vapor pressure'],
            'leaf_temp' => ['label' => 'Leaf temperature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SVP = 0.61078 × e^(17.27T ÷ (T + 237.3)) kPa</li>
            <li>VPD = SVP(leaf) − SVP(air) × RH</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
