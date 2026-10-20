<x-calc.page
    title="Bragg's Law Calculator - SolveKit"
    description="Free Bragg's law calculator: solve nλ = 2d sin θ for the angle, lattice spacing, wavelength or order."
    lede="Solve nλ = 2d sin θ."
    about="X-rays reflecting from planes of atoms interfere constructively only when the extra path 2d sin θ is a whole number of wavelengths. Copper Kα X-rays (0.15406 nm) are the laboratory standard."
    :calc="['engine' => 'ph-wave', 'tool' => 'bragg', 'fields' => ['solve', 'n', 'lambda', 'd', 'theta', 'out_lambda', 'out_d', 'out_theta'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'At what angle do Cu Kα X-rays reflect from planes 0.3 nm apart?', 'answer' => '14.8783 °.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['n' => 'Diffraction order n', 'lambda' => 'Wavelength', 'd' => 'Lattice spacing d', 'theta' => 'Bragg angle θ']" selected="theta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:lambda,d,theta">
            <x-calc.field name="n" label="Diffraction order n" value="1" step="any" />
        </div>
        <div data-show-when="solve:n,d,theta">
            <x-calc.field name="lambda" label="Wavelength" value="0.15406" placeholder="Wavelength">
                <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:n,lambda,theta">
            <x-calc.field name="d" label="Lattice spacing d" value="0.3" placeholder="Lattice spacing d">
                <label for="calc-d-unit" class="sr-only">Lattice spacing d unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:n,lambda,d" hidden>
            <x-calc.field name="theta" label="Bragg angle θ" value="14.8806" placeholder="Bragg angle θ">
                <label for="calc-theta-unit" class="sr-only">Bragg angle θ unit</label>
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
        <div data-show-when="solve:d" hidden>
            <x-calc.select name="out_d" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
        </div>
        <div data-show-when="solve:theta">
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Bragg angle θ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'theta', 'n' => 1, 'lambda' => 0.15406, 'lambda-unit' => 'nm', 'out_lambda' => 'nm', 'd' => 0.3, 'd-unit' => 'nm', 'out_d' => 'nm', 'theta' => 14.8806, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'twoTheta' => ['label' => 'Detector angle 2θ'],
            'orders' => ['label' => 'Highest possible order'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n λ = 2 d sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
