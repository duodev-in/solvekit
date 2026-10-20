<x-calc.page
    title="Compton Scattering Calculator - SolveKit"
    description="Free Compton scattering calculator: scattered photon wavelength and electron recoil energy at any angle."
    lede="Find the Compton shift."
    about="An X-ray photon bouncing off an electron loses energy, so its wavelength grows by (h/mc)(1 − cos θ). Compton’s 1923 measurement showed light carries momentum."
    :calc="['engine' => 'ph-quantum', 'tool' => 'compton', 'fields' => ['lambda', 'theta', 'out'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What wavelength does a 0.0709 nm X-ray have after 90°?', 'answer' => '0.0733263 nm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lambda" label="Incident wavelength" value="0.0709" placeholder="Incident wavelength">
            <label for="calc-lambda-unit" class="sr-only">Incident wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="theta" label="Scattering angle" value="90" placeholder="Scattering angle">
            <label for="calc-theta-unit" class="sr-only">Scattering angle unit</label>
            <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Scattered wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'lambda' => 0.0709, 'lambda-unit' => 'nm', 'theta' => 90, 'theta-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shift' => ['label' => 'Wavelength shift'],
            'E1' => ['label' => 'Incident photon energy'],
            'E2' => ['label' => 'Scattered photon energy'],
            'Ke' => ['label' => 'Electron recoil energy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
