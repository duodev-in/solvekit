<x-calc.page
    title="Dew Point Calculator - SolveKit"
    description="Free dew point calculator: dew point from temperature and relative humidity, with comfort level."
    lede="Find the dew point."
    about="The dew point is the temperature at which air becomes saturated and dew or condensation forms. It is the best single measure of how humid the air feels."
    :calc="['engine' => 'ph-thermo', 'tool' => 'dew_point', 'fields' => ['T', 'rh', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the dew point at 25 °C and 60%?', 'answer' => '16.7011 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Air temperature" value="25" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rh" label="Relative humidity (%)" value="60" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Dew point" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'T' => 25, 'T-unit' => 'c', 'rh' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'magnus' => ['label' => 'Magnus formula (comparison)'],
            'spread' => ['label' => 'Temperature minus dew point'],
            'comfort' => ['label' => 'How it feels'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
