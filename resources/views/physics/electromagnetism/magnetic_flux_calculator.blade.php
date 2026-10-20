<x-calc.page
    title="Magnetic Flux Calculator - SolveKit"
    description="Free magnetic flux calculator: Φ = BA cos θ, solved for flux, field, area or angle."
    lede="Solve Φ = BA cos θ."
    about="Magnetic flux counts field lines through an area: field × area × the cosine of the angle between the field and the area’s normal."
    :calc="['engine' => 'ph-em', 'tool' => 'magnetic_flux', 'fields' => ['solve', 'phi', 'B', 'A', 'theta', 'out_B', 'out_A', 'out_theta'], 'unitFields' => ['B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'area', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What flux does 0.5 T through 1,000 cm² at 30° give?', 'answer' => '0.0433013 Wb.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['phi' => 'Magnetic flux (Wb)', 'B' => 'Magnetic field', 'A' => 'Area', 'theta' => 'Angle between field and normal']" selected="phi" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:B,A,theta" hidden>
            <x-calc.field name="phi" label="Magnetic flux (Wb)" value="0.0433" step="any" />
        </div>
        <div data-show-when="solve:phi,A,theta">
            <x-calc.field name="B" label="Magnetic field" value="0.5" placeholder="Magnetic field">
                <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
                <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:phi,B,theta">
            <x-calc.field name="A" label="Area" value="1000" min="0" placeholder="Area">
                <label for="calc-A-unit" class="sr-only">Area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:phi,B,A">
            <x-calc.field name="theta" label="Angle between field and normal" value="30" placeholder="Angle between field and normal">
                <label for="calc-theta-unit" class="sr-only">Angle between field and normal unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:B" hidden>
            <x-calc.select name="out_B" label="Show the result in" :options="['t' => 'T', 'mt' => 'mT', 'ut' => 'µT', 'nt' => 'nT', 'gauss' => 'G', 'mgauss' => 'mG']" selected="t" />
        </div>
        <div data-show-when="solve:A" hidden>
            <x-calc.select name="out_A" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="cm2" />
        </div>
        <div data-show-when="solve:theta" hidden>
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Magnetic flux (Wb)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'phi', 'phi' => 0.0433, 'B' => 0.5, 'B-unit' => 't', 'out_B' => 't', 'A' => 1000, 'A-unit' => 'cm2', 'out_A' => 'cm2', 'theta' => 30, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mwb' => ['label' => 'In milliwebers'],
            'maxwell' => ['label' => 'In maxwells'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Φ = B A cos θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
