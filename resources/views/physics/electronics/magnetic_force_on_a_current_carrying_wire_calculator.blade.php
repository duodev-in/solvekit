<x-calc.page
    title="Magnetic Force on a Current-Carrying Wire Calculator - SolveKit"
    description="Free force on a wire calculator: F = BIL sin θ, solved for any value."
    lede="Solve F = BIL sin θ."
    about="A current in a magnetic field feels a sideways force BIL sin θ: the principle of every electric motor."
    :calc="['engine' => 'ph-elec', 'tool' => 'wire_force_field', 'fields' => ['solve', 'F', 'B', 'I', 'L', 'theta', 'out_F', 'out_B', 'out_I', 'out_L', 'out_theta'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'current', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What force acts on 0.5 m of wire with 4 A in 0.5 T?', 'answer' => '1 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Force', 'B' => 'Magnetic field', 'I' => 'Current', 'L' => 'Length in the field', 'theta' => 'Angle between wire and field']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:B,I,L,theta" hidden>
            <x-calc.field name="F" label="Force" value="1" placeholder="Force">
                <label for="calc-F-unit" class="sr-only">Force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,I,L,theta">
            <x-calc.field name="B" label="Magnetic field" value="0.5" placeholder="Magnetic field">
                <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
                <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,B,L,theta">
            <x-calc.field name="I" label="Current" value="4" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,B,I,theta">
            <x-calc.field name="L" label="Length in the field" value="0.5" placeholder="Length in the field">
                <label for="calc-L-unit" class="sr-only">Length in the field unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,B,I,L">
            <x-calc.field name="theta" label="Angle between wire and field" value="90" placeholder="Angle between wire and field">
                <label for="calc-theta-unit" class="sr-only">Angle between wire and field unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:B" hidden>
            <x-calc.select name="out_B" label="Show the result in" :options="['t' => 'T', 'mt' => 'mT', 'ut' => 'µT', 'nt' => 'nT', 'gauss' => 'G', 'mgauss' => 'mG']" selected="t" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:theta" hidden>
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 1, 'F-unit' => 'n', 'out_F' => 'n', 'B' => 0.5, 'B-unit' => 't', 'out_B' => 't', 'I' => 4, 'I-unit' => 'a', 'out_I' => 'a', 'L' => 0.5, 'L-unit' => 'm', 'out_L' => 'm', 'theta' => 90, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'dir' => ['label' => 'Direction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = B I L sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
