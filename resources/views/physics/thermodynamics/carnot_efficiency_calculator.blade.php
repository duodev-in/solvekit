<x-calc.page
    title="Carnot Efficiency Calculator - SolveKit"
    description="Free Carnot efficiency calculator: the maximum efficiency of a heat engine between two temperatures."
    lede="Solve η = 1 − T_c/T_h."
    about="No heat engine can beat the Carnot efficiency 1 − T_c/T_h, with temperatures in kelvin."
    :calc="['engine' => 'ph-thermo', 'tool' => 'carnot', 'fields' => ['solve', 'eta', 'Th', 'Tc', 'out_Th', 'out_Tc'], 'unitFields' => ['Th' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tc' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the Carnot efficiency between 600 K and 300 K?', 'answer' => '0.5.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['eta' => 'Carnot efficiency (fraction)', 'Th' => 'Hot reservoir', 'Tc' => 'Cold reservoir']" selected="eta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Th,Tc" hidden>
            <x-calc.field name="eta" label="Carnot efficiency (fraction)" value="0.5" step="any" />
        </div>
        <div data-show-when="solve:eta,Tc">
            <x-calc.field name="Th" label="Hot reservoir" value="326.85" placeholder="Hot reservoir">
                <label for="calc-Th-unit" class="sr-only">Hot reservoir unit</label>
                <select id="calc-Th-unit" name="Th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:eta,Th">
            <x-calc.field name="Tc" label="Cold reservoir" value="26.85" placeholder="Cold reservoir">
                <label for="calc-Tc-unit" class="sr-only">Cold reservoir unit</label>
                <select id="calc-Tc-unit" name="Tc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Th" hidden>
            <x-calc.select name="out_Th" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
        <div data-show-when="solve:Tc" hidden>
            <x-calc.select name="out_Tc" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
    </div>

    <x-calc.result label="Carnot efficiency (fraction)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'eta', 'eta' => 0.5, 'Th' => 326.85, 'Th-unit' => 'c', 'out_Th' => 'c', 'Tc' => 26.85, 'Tc-unit' => 'c', 'out_Tc' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'pct' => ['label' => 'As a percentage'],
            'cop' => ['label' => 'Carnot COP as a heat pump'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>η = 1 − T_c ÷ T_h (kelvin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
