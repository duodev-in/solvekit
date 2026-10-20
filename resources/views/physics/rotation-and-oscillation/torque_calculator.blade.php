<x-calc.page
    title="Torque Calculator - SolveKit"
    description="Free torque calculator: τ = rF sin θ for torque, lever arm, force or angle in any units."
    lede="Solve τ = rF sin θ."
    about="Torque is the turning effect of a force: the lever arm times the force times the sine of the angle between them."
    :calc="['engine' => 'ph-mech', 'tool' => 'torque', 'fields' => ['solve', 'tau', 'r', 'F', 'theta', 'out_tau', 'out_r', 'out_F', 'out_theta'], 'unitFields' => ['tau' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What torque does 100 N at 50 cm give?', 'answer' => '50 N·m.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['tau' => 'Torque', 'r' => 'Lever arm', 'F' => 'Force', 'theta' => 'Angle between arm and force']" selected="tau" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:r,F,theta" hidden>
            <x-calc.field name="tau" label="Torque" value="50" placeholder="Torque">
                <label for="calc-tau-unit" class="sr-only">Torque unit</label>
                <select id="calc-tau-unit" name="tau-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:tau,F,theta">
            <x-calc.field name="r" label="Lever arm" value="50" placeholder="Lever arm">
                <label for="calc-r-unit" class="sr-only">Lever arm unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:tau,r,theta">
            <x-calc.field name="F" label="Force" value="100" placeholder="Force">
                <label for="calc-F-unit" class="sr-only">Force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:tau,r,F">
            <x-calc.field name="theta" label="Angle between arm and force" value="90" placeholder="Angle between arm and force">
                <label for="calc-theta-unit" class="sr-only">Angle between arm and force unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:tau">
            <x-calc.select name="out_tau" label="Show the result in" :options="['nm' => 'N·m', 'knm' => 'kN·m', 'ncm' => 'N·cm', 'nmm' => 'N·mm', 'lbfft' => 'ft·lbf', 'lbfin' => 'in·lbf', 'kgfm' => 'kgf·m']" selected="nm" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
        <div data-show-when="solve:F" hidden>
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:theta" hidden>
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Torque" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'tau', 'tau' => 50, 'tau-unit' => 'nm', 'out_tau' => 'nm', 'r' => 50, 'r-unit' => 'cm', 'out_r' => 'cm', 'F' => 100, 'F-unit' => 'n', 'out_F' => 'n', 'theta' => 90, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'power' => ['label' => 'Power at 1,000 rpm'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>τ = r F sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
