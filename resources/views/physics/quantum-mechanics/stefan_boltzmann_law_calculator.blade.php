<x-calc.page
    title="Stefan Boltzmann Law Calculator - SolveKit"
    description="Free Stefan–Boltzmann law calculator: radiated power P = εσAT⁴, solved for any value."
    lede="Solve P = εσAT⁴."
    about="Every object radiates heat in proportion to the fourth power of its absolute temperature. Doubling the temperature multiplies the power by 16."
    :calc="['engine' => 'ph-quantum', 'tool' => 'stefan_boltzmann', 'fields' => ['solve', 'P', 'eps', 'A', 'T', 'out_P', 'out_A', 'out_T'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['P', 'area', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What does 1 m² at 300 K radiate?', 'answer' => '459.3 W.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P' => 'Radiated power', 'eps' => 'Emissivity', 'A' => 'Area', 'T' => 'Temperature']" selected="P" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:eps,A,T" hidden>
            <x-calc.field name="P" label="Radiated power" value="459.32" min="0" placeholder="Radiated power">
                <label for="calc-P-unit" class="sr-only">Radiated power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P,A,T">
            <x-calc.field name="eps" label="Emissivity" value="1" step="any" />
        </div>
        <div data-show-when="solve:P,eps,T">
            <x-calc.field name="A" label="Area" value="1" min="0" placeholder="Area">
                <label for="calc-A-unit" class="sr-only">Area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P,eps,A">
            <x-calc.field name="T" label="Temperature" value="300" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P">
            <x-calc.select name="out_P" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
        </div>
        <div data-show-when="solve:A" hidden>
            <x-calc.select name="out_A" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="m2" />
        </div>
        <div data-show-when="solve:T" hidden>
            <x-calc.select name="out_T" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="k" />
        </div>
    </div>

    <x-calc.result label="Radiated power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'P', 'P' => 459.32, 'P-unit' => 'w', 'out_P' => 'w', 'eps' => 1, 'A' => 1, 'A-unit' => 'm2', 'out_A' => 'm2', 'T' => 300, 'T-unit' => 'k', 'out_T' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'flux' => ['label' => 'Radiant exitance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = ε σ A T⁴</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
