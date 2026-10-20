<x-calc.page
    title="BTU to Tons Converter - SolveKit"
    description="Free BTU to tons converter: cooling capacity in BTU/h, tons of refrigeration and kW."
    lede="Convert BTU/h to tons."
    about="One ton of refrigeration is 12,000 BTU/h, the cooling of melting a short ton of ice per day."
    :calc="['engine' => 'ph-thermo', 'tool' => 'btu_tons', 'fields' => ['P', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many tons is 24,000 BTU/h?', 'answer' => '2 TR.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Cooling or heating capacity" value="24000" min="0" placeholder="Cooling or heating capacity">
            <label for="calc-P-unit" class="sr-only">Cooling or heating capacity unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'btuh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="tr" />
    </div>

    <x-calc.result label="Capacity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'tr', 'P' => 24000, 'P-unit' => 'btuh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kw' => ['label' => 'In kilowatts'],
            'btu' => ['label' => 'In BTU/h'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
