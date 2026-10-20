<x-calc.page
    title="Poiseuille's Law Calculator - SolveKit"
    description="Free Poiseuille's law calculator: laminar flow through a tube, solved for any value."
    lede="Solve Q = πr⁴ΔP ÷ 8μL."
    about="Laminar flow in a tube scales with the fourth power of the radius: halve the radius and the flow drops sixteenfold. This is why narrowed arteries matter."
    :calc="['engine' => 'ph-fluid', 'tool' => 'poiseuille', 'fields' => ['solve', 'Q', 'dP', 'r', 'mu', 'L', 'out_Q', 'out_dP', 'out_r', 'out_mu', 'out_L'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['Q', 'energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed', 'viscosity'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What flows through a 1 mm radius, 10 cm tube at 8 kPa?', 'answer' => '1.88496 L/min.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Q' => 'Flow rate', 'dP' => 'Pressure drop', 'r' => 'Tube radius', 'mu' => 'Viscosity', 'L' => 'Length']" selected="Q" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:dP,r,mu,L" hidden>
            <x-calc.field name="Q" label="Flow rate" value="1.5708" min="0" placeholder="Flow rate">
                <label for="calc-Q-unit" class="sr-only">Flow rate unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'lmin')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,r,mu,L">
            <x-calc.field name="dP" label="Pressure drop" value="8" min="0" placeholder="Pressure drop">
                <label for="calc-dP-unit" class="sr-only">Pressure drop unit</label>
                <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,dP,mu,L">
            <x-calc.field name="r" label="Tube radius" value="1" placeholder="Tube radius">
                <label for="calc-r-unit" class="sr-only">Tube radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,dP,r,L">
            <x-calc.field name="mu" label="Viscosity" value="1" min="0" placeholder="Viscosity">
                <label for="calc-mu-unit" class="sr-only">Viscosity unit</label>
                <select id="calc-mu-unit" name="mu-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cp')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,dP,r,mu">
            <x-calc.field name="L" label="Length" value="0.1" placeholder="Length">
                <label for="calc-L-unit" class="sr-only">Length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q">
            <x-calc.select name="out_Q" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="lmin" />
        </div>
        <div data-show-when="solve:dP" hidden>
            <x-calc.select name="out_dP" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
        <div data-show-when="solve:mu" hidden>
            <x-calc.select name="out_mu" label="Show the result in" :options="['pas' => 'Pa·s', 'mpas' => 'mPa·s', 'cp' => 'cP', 'p' => 'P', 'lbfts' => 'lb/(ft·s)']" selected="cp" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Q', 'Q' => 1.5708, 'Q-unit' => 'lmin', 'out_Q' => 'lmin', 'dP' => 8, 'dP-unit' => 'kpa', 'out_dP' => 'kpa', 'r' => 1, 'r-unit' => 'mm', 'out_r' => 'mm', 'mu' => 1, 'mu-unit' => 'cp', 'out_mu' => 'cp', 'L' => 0.1, 'L-unit' => 'm', 'out_L' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'v' => ['label' => 'Mean velocity'],
            'note' => ['label' => 'Validity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = π r⁴ ΔP ÷ (8 μ L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
