<x-calc.page
    title="Heat Capacity Calculator - SolveKit"
    description="Free heat capacity calculator: C = Q/ΔT, solved for any value."
    lede="Solve C = Q ÷ ΔT."
    about="Heat capacity is the heat needed to raise an object’s temperature by one kelvin."
    :calc="['engine' => 'ph-thermo', 'tool' => 'heat_capacity', 'fields' => ['solve', 'C', 'Q', 'dT', 'out_Q', 'out_dT'], 'unitFields' => ['Q' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['C', 'energy', 'force', 'length', 'mass', 'speed', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is C if 12.5 kJ raises it 30 K?', 'answer' => '418.2 J/K.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['C' => 'Heat capacity (J/K)', 'Q' => 'Heat supplied', 'dT' => 'Temperature rise']" selected="C" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Q,dT" hidden>
            <x-calc.field name="C" label="Heat capacity (J/K)" value="418.2" step="any" />
        </div>
        <div data-show-when="solve:C,dT">
            <x-calc.field name="Q" label="Heat supplied" value="12.546" placeholder="Heat supplied">
                <label for="calc-Q-unit" class="sr-only">Heat supplied unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kj')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:C,Q">
            <x-calc.field name="dT" label="Temperature rise" value="30" placeholder="Temperature rise">
                <label for="calc-dT-unit" class="sr-only">Temperature rise unit</label>
                <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q" hidden>
            <x-calc.select name="out_Q" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
        </div>
        <div data-show-when="solve:dT" hidden>
            <x-calc.select name="out_dT" label="Show the result in" :options="['k' => 'K', 'c' => '°C', 'f' => '°F', 'r' => '°R']" selected="k" />
        </div>
    </div>

    <x-calc.result label="Heat capacity (J/K)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'C', 'C' => 418.2, 'Q' => 12.546, 'Q-unit' => 'kj', 'out_Q' => 'kj', 'dT' => 30, 'dT-unit' => 'k', 'out_dT' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'water' => ['label' => 'Equivalent mass of water'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = Q ÷ ΔT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
