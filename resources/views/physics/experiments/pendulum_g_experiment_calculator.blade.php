<x-calc.page
    title="Pendulum g Experiment Calculator - SolveKit"
    description="Free pendulum experiment calculator: measure gravity g from a pendulum’s length and timed swings."
    lede="Measure g with a pendulum."
    about="Time several swings of a pendulum and measure its length: g = 4π²L/T². With care this gets within 0.1% of the true value."
    :calc="['engine' => 'ph-quantum', 'tool' => 'pendulum_g', 'fields' => ['L', 't', 'N', 'amp', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'amp' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What g do 10 swings in 20.07 s of a 1 m pendulum give?', 'answer' => '9.81021 m/s².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Pendulum length (pivot to the centre of the bob)" value="1" placeholder="Pendulum length (pivot to the centre of the bob)">
            <label for="calc-L-unit" class="sr-only">Pendulum length (pivot to the centre of the bob) unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Time for the oscillations" value="20.07" placeholder="Time for the oscillations">
            <label for="calc-t-unit" class="sr-only">Time for the oscillations unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="N" label="Number of full oscillations timed" value="10" min="1" step="any" />
        <x-calc.field name="amp" label="Swing amplitude" value="5" placeholder="Swing amplitude">
            <label for="calc-amp-unit" class="sr-only">Swing amplitude unit</label>
            <select id="calc-amp-unit" name="amp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Measured g" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'L' => 1, 'L-unit' => 'm', 't' => 20.07, 't-unit' => 's', 'N' => 10, 'amp' => 5, 'amp-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Period'],
            'small' => ['label' => 'Without the amplitude correction'],
            'error' => ['label' => 'Difference from standard g (9.80665)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
