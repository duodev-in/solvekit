<x-calc.page
    title="Angle of Banking Calculator - SolveKit"
    description="Free banking angle calculator: the ideal bank angle of a curve for a speed and radius, or the speed for an angle."
    lede="Find the ideal banking angle."
    about="On a banked curve the normal force supplies the centripetal force. At the design speed no friction is needed: tan θ = v² ÷ rg. The extra row shows the top speed when tyre friction helps."
    :calc="['engine' => 'ph-mech', 'tool' => 'banking', 'fields' => ['solve', 'theta', 'v', 'r', 'g', 'out_theta', 'out_v', 'out_r', 'out_g'], 'unitFields' => ['theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What bank suits 80 km/h on a 189 m radius?', 'answer' => '14.9191 °.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['theta' => 'Banking angle', 'v' => 'Speed', 'r' => 'Curve radius', 'g' => 'Gravity']" selected="theta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v,r,g" hidden>
            <x-calc.field name="theta" label="Banking angle" value="15" placeholder="Banking angle">
                <label for="calc-theta-unit" class="sr-only">Banking angle unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta,r,g">
            <x-calc.field name="v" label="Speed" value="80" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta,v,g">
            <x-calc.field name="r" label="Curve radius" value="189" placeholder="Curve radius">
                <label for="calc-r-unit" class="sr-only">Curve radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta,v,r">
            <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
                <label for="calc-g-unit" class="sr-only">Gravity unit</label>
                <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:theta">
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:g" hidden>
            <x-calc.select name="out_g" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
        </div>
    </div>

    <x-calc.result label="Banking angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'theta', 'theta' => 15, 'theta-unit' => 'deg', 'out_theta' => 'deg', 'v' => 80, 'v-unit' => 'kmh', 'out_v' => 'kmh', 'r' => 189, 'r-unit' => 'm', 'out_r' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2', 'out_g' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'lateral' => ['label' => 'Sideways acceleration without banking'],
            'vmax' => ['label' => 'Maximum speed with tyre friction μ = 0.7'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tan θ = v² ÷ (r g)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
