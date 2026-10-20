<x-calc.page
    title="Harmonic Wave Equation Calculator - SolveKit"
    description="Free harmonic wave calculator: displacement y(x, t) = A sin(kx − ωt + φ), with the wave plot."
    lede="Evaluate a travelling wave."
    about="A sinusoidal travelling wave is y = A sin(kx − ωt + φ), with wave number k = 2π/λ and angular frequency ω = 2πf. The wave moves at v = fλ."
    :calc="['engine' => 'ph-mech', 'tool' => 'harmonic_wave', 'fields' => ['A', 'lambda', 'f', 'phi', 'x', 't', 'out'], 'unitFields' => ['A' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'phi' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'x' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is y at x = 0.5 m and t = 0.1 s in the example?', 'answer' => '−1.54508 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="A" label="Amplitude" value="5" placeholder="Amplitude">
            <label for="calc-A-unit" class="sr-only">Amplitude unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="lambda" label="Wavelength" value="2" placeholder="Wavelength">
            <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Frequency" value="3" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="phi" label="Phase" value="0" placeholder="Phase">
            <label for="calc-phi-unit" class="sr-only">Phase unit</label>
            <select id="calc-phi-unit" name="phi-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="x" label="Position x" value="0.5" placeholder="Position x">
            <label for="calc-x-unit" class="sr-only">Position x unit</label>
            <select id="calc-x-unit" name="x-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Time t" value="0.1" placeholder="Time t">
            <label for="calc-t-unit" class="sr-only">Time t unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Displacement y(x, t)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'A' => 5, 'A-unit' => 'cm', 'lambda' => 2, 'lambda-unit' => 'm', 'f' => 3, 'f-unit' => 'hz', 'phi' => 0, 'phi-unit' => 'deg', 'x' => 0.5, 'x-unit' => 'm', 't' => 0.1, 't-unit' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Wave at time t" name="wave" />
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Wave speed'],
            'k' => ['label' => 'Wave number'],
            'w' => ['label' => 'Angular frequency'],
            'vy' => ['label' => 'Particle velocity at that point'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
