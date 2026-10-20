<x-calc.page
    title="Differential Pressure Calculator - SolveKit"
    description="Free differential pressure calculator: difference between two pressures, in any unit and as water column."
    lede="Find a pressure difference."
    about="Differential pressure drives flow and is what flow meters and filters measure."
    :calc="['engine' => 'ph-fluid', 'tool' => 'differential_pressure', 'fields' => ['P1', 'P2', 'out'], 'unitFields' => ['P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'P2' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 350 kPa minus 320 kPa?', 'answer' => '30 kPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P1" label="Upstream pressure" value="350" min="0" placeholder="Upstream pressure">
            <label for="calc-P1-unit" class="sr-only">Upstream pressure unit</label>
            <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="P2" label="Downstream pressure" value="320" min="0" placeholder="Downstream pressure">
            <label for="calc-P2-unit" class="sr-only">Downstream pressure unit</label>
            <select id="calc-P2-unit" name="P2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
    </div>

    <x-calc.result label="Differential pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kpa', 'P1' => 350, 'P1-unit' => 'kpa', 'P2' => 320, 'P2-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'water' => ['label' => 'As a column of water'],
            'psi' => ['label' => 'In psi'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
