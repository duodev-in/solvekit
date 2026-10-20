<x-calc.page
    title="Efficiency Calculator - SolveKit"
    description="Free efficiency calculator: η = output/input, solved for any value."
    lede="Solve η = output ÷ input."
    about="Efficiency is the useful output divided by the input; the rest becomes waste heat."
    :calc="['engine' => 'ph-thermo', 'tool' => 'efficiency', 'fields' => ['solve', 'eta', 'out', 'in', 'out_out', 'out_in'], 'unitFields' => ['out' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'in' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'eta', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the efficiency of 8.5 kW out from 10 kW in?', 'answer' => '0.85.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['eta' => 'Efficiency (fraction)', 'out' => 'Useful output', 'in' => 'Input']" selected="eta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:out,in" hidden>
            <x-calc.field name="eta" label="Efficiency (fraction)" value="0.85" step="any" />
        </div>
        <div data-show-when="solve:eta,in">
            <x-calc.field name="out" label="Useful output" value="8.5" min="0" placeholder="Useful output">
                <label for="calc-out-unit" class="sr-only">Useful output unit</label>
                <select id="calc-out-unit" name="out-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:eta,out">
            <x-calc.field name="in" label="Input" value="10" min="0" placeholder="Input">
                <label for="calc-in-unit" class="sr-only">Input unit</label>
                <select id="calc-in-unit" name="in-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:out" hidden>
            <x-calc.select name="out_out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
        </div>
        <div data-show-when="solve:in" hidden>
            <x-calc.select name="out_in" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
        </div>
    </div>

    <x-calc.result label="Efficiency (fraction)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'eta', 'eta' => 0.85, 'out' => 8.5, 'out-unit' => 'kw', 'out_out' => 'kw', 'in' => 10, 'in-unit' => 'kw', 'out_in' => 'kw'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'pct' => ['label' => 'As a percentage'],
            'lost' => ['label' => 'Lost as heat'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>η = output ÷ input</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
