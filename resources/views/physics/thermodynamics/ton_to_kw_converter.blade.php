<x-calc.page
    title="Ton to kW Converter - SolveKit"
    description="Free ton to kW converter: tons of refrigeration to kilowatts and BTU/h."
    lede="Convert tons to kW."
    about="Air-conditioning capacity in tons converts at 3.517 kW per ton."
    :calc="['engine' => 'ph-thermo', 'tool' => 'ton_kw', 'fields' => ['P', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many kW is 5 tons?', 'answer' => '17.5843 kW.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Capacity" value="5" min="0" placeholder="Capacity">
            <label for="calc-P-unit" class="sr-only">Capacity unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'tr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="kw" />
    </div>

    <x-calc.result label="Capacity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kw', 'P' => 5, 'P-unit' => 'tr'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tr' => ['label' => 'In tons of refrigeration'],
            'btu' => ['label' => 'In BTU/h'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
