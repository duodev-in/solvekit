<x-calc.page
    title="Heat Transfer Coefficient Calculator - SolveKit"
    description="Free U-value calculator: overall heat transfer coefficient of a wall or roof from its layers."
    lede="Find the U-value of a wall."
    about="Layers add their thermal resistances in series, plus inside and outside surface films. U is the reciprocal of the total."
    :calc="['engine' => 'ph-thermo', 'tool' => 'u_value', 'fields' => ['layers', 'hi', 'ho', 'A', 'dT', 'out'], 'unitFields' => ['hi' => collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f'])->all(), 'ho' => collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'heat_transfer_coefficient', 'length', 'mass', 'speed', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the U-value of the example wall?', 'answer' => '0.30868 W/(m²·K).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="layers" label="Layers: thickness in mm, conductivity in W/(m·K) (one per line)" value="100, 0.72
100, 0.035
12.5, 0.17" rows="3" />
        <x-calc.field name="hi" label="Inside surface coefficient" value="7.69" min="0" placeholder="Inside surface coefficient">
            <label for="calc-hi-unit" class="sr-only">Inside surface coefficient unit</label>
            <select id="calc-hi-unit" name="hi-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'wm2k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ho" label="Outside surface coefficient" value="25" min="0" placeholder="Outside surface coefficient">
            <label for="calc-ho-unit" class="sr-only">Outside surface coefficient unit</label>
            <select id="calc-ho-unit" name="ho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'wm2k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="A" label="Area (optional)" value="10" min="0" placeholder="Area (optional)">
            <label for="calc-A-unit" class="sr-only">Area (optional) unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dT" label="Temperature difference (optional)" value="20" placeholder="Temperature difference (optional)">
            <label for="calc-dT-unit" class="sr-only">Temperature difference (optional) unit</label>
            <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['wm2k' => 'W/(m²·K)', 'kwm2k' => 'kW/(m²·K)', 'btuhft2f' => 'BTU/(h·ft²·°F)']" selected="wm2k" />
    </div>

    <x-calc.result label="Overall U-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'wm2k', 'layers' => '100, 0.72
100, 0.035
12.5, 0.17', 'hi' => 7.69, 'hi-unit' => 'wm2k', 'ho' => 25, 'ho-unit' => 'wm2k', 'A' => 10, 'A-unit' => 'm2', 'dT' => 20, 'dT-unit' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Rt' => ['label' => 'Total thermal resistance'],
            'Q' => ['label' => 'Heat loss'],
            'share' => ['label' => 'Resistance of each layer'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
