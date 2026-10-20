<x-calc.page
    title="Diffraction Grating Calculator - SolveKit"
    description="Free diffraction grating calculator: diffraction angle, wavelength, line density or order from d sin θ = mλ."
    lede="Solve d sin θ = mλ."
    about="A grating with N lines per millimetre sends each wavelength to angles where the path difference between neighbouring lines is a whole number of wavelengths."
    :calc="['engine' => 'ph-wave', 'tool' => 'grating', 'fields' => ['solve', 'N', 'lambda', 'm', 'theta', 'out_lambda', 'out_theta'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'Where does 532 nm green light go with a 600 lines/mm grating?', 'answer' => 'First order at 18.6146 °.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['N' => 'Lines per millimetre', 'lambda' => 'Wavelength', 'm' => 'Order m', 'theta' => 'Diffraction angle']" selected="theta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:lambda,m,theta">
            <x-calc.field name="N" label="Lines per millimetre" value="600" step="any" />
        </div>
        <div data-show-when="solve:N,m,theta">
            <x-calc.field name="lambda" label="Wavelength" value="532" placeholder="Wavelength">
                <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:N,lambda,theta">
            <x-calc.field name="m" label="Order m" value="1" step="any" />
        </div>
        <div data-show-when="solve:N,lambda,m" hidden>
            <x-calc.field name="theta" label="Diffraction angle" value="18.6" placeholder="Diffraction angle">
                <label for="calc-theta-unit" class="sr-only">Diffraction angle unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:lambda" hidden>
            <x-calc.select name="out_lambda" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
        </div>
        <div data-show-when="solve:theta">
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Diffraction angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'theta', 'N' => 600, 'lambda' => 532, 'lambda-unit' => 'nm', 'out_lambda' => 'nm', 'm' => 1, 'theta' => 18.6, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'd' => ['label' => 'Line spacing d'],
            'max' => ['label' => 'Highest visible order'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d sin θ = m λ, d = 1 ÷ N</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
