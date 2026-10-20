<x-calc.page
    title="Watts to Heat Calculator - SolveKit"
    description="Free watts to heat calculator: convert watts to BTU/h and kcal/h."
    lede="Convert watts to heat output."
    about="An electric heater turns every watt into 3.412 BTU/h of heat."
    :calc="['engine' => 'ph-thermo', 'tool' => 'watts_heat', 'fields' => ['P', 'out'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many BTU/h is a 1,500 W heater?', 'answer' => '5,118.21 BTU/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Power" value="1500" min="0" placeholder="Power">
            <label for="calc-P-unit" class="sr-only">Power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="btuh" />
    </div>

    <x-calc.result label="Heat output" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'btuh', 'P' => 1500, 'P-unit' => 'w'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kcal' => ['label' => 'In kcal/h'],
            'day' => ['label' => 'Energy per day'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
