<x-calc.page
    title="Angular Resolution Calculator - SolveKit"
    description="Free angular resolution calculator: the Rayleigh diffraction limit θ = 1.22λ/D of a telescope, camera or eye."
    lede="Find the smallest angle an aperture can resolve."
    about="Diffraction blurs every point of light into a small disc, so two points closer than about 1.22λ/D radians merge. Bigger apertures and shorter wavelengths resolve finer detail. The Dawes limit (116″ ÷ D in mm) is the practical visual figure for double stars."
    :calc="['engine' => 'ph-wave', 'tool' => 'angular_resolution', 'fields' => ['solve', 'theta', 'lambda', 'D', 'out_theta', 'out_lambda', 'out_D'], 'unitFields' => ['theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed', 'theta'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What can a 100 mm telescope resolve at 550 nm?', 'answer' => '1.38404 ″.'],
        ['question' => 'Why does seeing matter?', 'answer' => 'Air turbulence usually limits ground-based telescopes to about 1″, whatever their size.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['theta' => 'Angular resolution', 'lambda' => 'Wavelength', 'D' => 'Aperture diameter']" selected="theta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:lambda,D" hidden>
            <x-calc.field name="theta" label="Angular resolution" value="1.38389" placeholder="Angular resolution">
                <label for="calc-theta-unit" class="sr-only">Angular resolution unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'arcsec')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta,D">
            <x-calc.field name="lambda" label="Wavelength" value="550" placeholder="Wavelength">
                <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta,lambda">
            <x-calc.field name="D" label="Aperture diameter" value="100" placeholder="Aperture diameter">
                <label for="calc-D-unit" class="sr-only">Aperture diameter unit</label>
                <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta">
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="arcsec" />
        </div>
        <div data-show-when="solve:lambda" hidden>
            <x-calc.select name="out_lambda" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
        </div>
        <div data-show-when="solve:D" hidden>
            <x-calc.select name="out_D" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
    </div>

    <x-calc.result label="Angular resolution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'theta', 'theta' => 1.38389, 'theta-unit' => 'arcsec', 'out_theta' => 'arcsec', 'lambda' => 550, 'lambda-unit' => 'nm', 'out_lambda' => 'nm', 'D' => 100, 'D-unit' => 'mm', 'out_D' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'dawes' => ['label' => 'Dawes limit (visual double stars)'],
            'km' => ['label' => 'Smallest detail at 1 km'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = 1.22 λ ÷ D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
