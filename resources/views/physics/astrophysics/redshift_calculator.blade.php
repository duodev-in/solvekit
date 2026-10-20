<x-calc.page
    title="Redshift Calculator - SolveKit"
    description="Free redshift calculator: z from observed and rest wavelengths, or from velocity with the relativistic Doppler formula."
    lede="Find the redshift z."
    about="Redshift compares observed and emitted wavelengths: 1 + z = λ_obs/λ_emit. The hydrogen-alpha line at 656.28 nm seen at 721.9 nm means z ≈ 0.1."
    :calc="['engine' => 'ph-astro', 'tool' => 'redshift', 'fields' => ['mode', 'obs', 'emit', 'v'], 'unitFields' => ['obs' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'emit' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What z is Hα seen at 721.9 nm?', 'answer' => '0.099988.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['wl' => 'Observed and emitted wavelengths', 'v' => 'Velocity (relativistic Doppler)']" selected="wl" />
        <div data-show-when="mode:wl">
            <x-calc.field name="obs" label="Observed wavelength" value="721.9" placeholder="Observed wavelength">
                <label for="calc-obs-unit" class="sr-only">Observed wavelength unit</label>
                <select id="calc-obs-unit" name="obs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:wl">
            <x-calc.field name="emit" label="Emitted (rest) wavelength" value="656.28" placeholder="Emitted (rest) wavelength">
                <label for="calc-emit-unit" class="sr-only">Emitted (rest) wavelength unit</label>
                <select id="calc-emit-unit" name="emit-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:v">
            <x-calc.field name="v" label="Velocity away from us" value="30000" placeholder="Velocity away from us">
                <label for="calc-v-unit" class="sr-only">Velocity away from us unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Redshift z" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'wl', 'obs' => 721.9, 'obs-unit' => 'nm', 'emit' => 656.28, 'emit-unit' => 'nm', 'v' => 30000, 'v-unit' => 'kms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Equivalent Doppler velocity'],
            'simple' => ['label' => 'Simple estimate cz'],
            'scale' => ['label' => 'Universe was smaller by'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
