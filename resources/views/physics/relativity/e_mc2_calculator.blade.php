<x-calc.page
    title="E = mc² Calculator - SolveKit"
    description="Free E = mc² calculator: convert mass to energy or energy to mass, with TNT equivalent."
    lede="Solve E = mc²."
    about="Mass and energy are equivalent: one kilogram corresponds to about 9 × 10¹⁶ J, more than 20 megatons of TNT."
    :calc="['engine' => 'ph-astro', 'tool' => 'emc2', 'fields' => ['solve', 'E', 'm', 'out_E', 'out_m'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much energy is 1 kg?', 'answer' => '8.98755 × 10¹⁶ J.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Energy', 'm' => 'Mass']" selected="E" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m" hidden>
            <x-calc.field name="E" label="Energy" value="89875500000000000" placeholder="Energy">
                <label for="calc-E-unit" class="sr-only">Energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
    </div>

    <x-calc.result label="Energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'E', 'E' => 89875500000000000, 'E-unit' => 'j', 'out_E' => 'j', 'm' => 1, 'm-unit' => 'kg', 'out_m' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'tnt' => ['label' => 'TNT equivalent'],
            'kwh' => ['label' => 'In kilowatt-hours'],
            'homes' => ['label' => 'Years of an average home’s electricity (10,000 kWh/yr)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = m c²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
