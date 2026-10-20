<x-calc.page
    title="Mixed Air Temperature Calculator - SolveKit"
    description="Free mixed air temperature calculator: temperature of outdoor and return air mixed in an air handler."
    lede="Find mixed air temperature."
    about="An air handler blends outdoor and return air; the mix temperature is the flow-weighted average."
    :calc="['engine' => 'ph-thermo', 'tool' => 'mixed_air_temperature', 'fields' => ['To', 'Tr', 'x', 'out'], 'unitFields' => ['To' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tr' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 30% of 5 °C air with 70% of 22 °C?', 'answer' => '16.9 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="To" label="Outdoor air temperature" value="5" placeholder="Outdoor air temperature">
            <label for="calc-To-unit" class="sr-only">Outdoor air temperature unit</label>
            <select id="calc-To-unit" name="To-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tr" label="Return air temperature" value="22" placeholder="Return air temperature">
            <label for="calc-Tr-unit" class="sr-only">Return air temperature unit</label>
            <select id="calc-Tr-unit" name="Tr-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="x" label="Outdoor air share (%)" value="30" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Mixed air temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'To' => 5, 'To-unit' => 'c', 'Tr' => 22, 'Tr-unit' => 'c', 'x' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'f' => ['label' => 'In °F'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
