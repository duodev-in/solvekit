<x-calc.page
    title="Thermal Resistance Calculator - SolveKit"
    description="Free thermal resistance calculator: R-value of layered walls and the heat flow through them."
    lede="Find thermal resistance."
    about="Each layer resists heat by its thickness over its conductivity; layers in series add."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_resistance', 'fields' => ['layers', 'A', 'dT'], 'unitFields' => ['A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the resistance of the example wall?', 'answer' => '0.306956 K/W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="layers" label="Layers: thickness in mm, conductivity in W/(m·K) (one per line)" value="100, 0.72
100, 0.035
12.5, 0.17" rows="3" />
        <x-calc.field name="A" label="Area" value="10" min="0" placeholder="Area">
            <label for="calc-A-unit" class="sr-only">Area unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dT" label="Temperature difference" value="20" placeholder="Temperature difference">
            <label for="calc-dT-unit" class="sr-only">Temperature difference unit</label>
            <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Thermal resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['layers' => '100, 0.72
100, 0.035
12.5, 0.17', 'A' => 10, 'A-unit' => 'm2', 'dT' => 20, 'dT-unit' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Rsq' => ['label' => 'Resistance per m² (R-value)'],
            'Rus' => ['label' => 'US R-value'],
            'Q' => ['label' => 'Heat flow'],
            'each' => ['label' => 'Each layer (m²·K/W)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
