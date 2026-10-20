<x-calc.page
    title="Shear Modulus Calculator - SolveKit"
    description="Free shear modulus calculator: G from shear stress and strain, or from Young's modulus and Poisson's ratio."
    lede="Find the shear modulus G."
    about="The shear modulus is the ratio of shear stress to shear strain. For an isotropic material G = E/2(1 + ν)."
    :calc="['engine' => 'ph-mat', 'tool' => 'shear_modulus', 'fields' => ['mode', 'tau', 'gamma', 'E', 'nu', 'out'], 'unitFields' => ['tau' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is G for steel (E = 200 GPa, ν = 0.29)?', 'answer' => '77.5194 GPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['tg' => 'Shear stress and strain', 'enu' => 'Young\'s modulus and Poisson\'s ratio']" selected="enu" />
        <div data-show-when="mode:tg">
            <x-calc.field name="tau" label="Shear stress" value="50" min="0" placeholder="Shear stress">
                <label for="calc-tau-unit" class="sr-only">Shear stress unit</label>
                <select id="calc-tau-unit" name="tau-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tg">
            <x-calc.field name="gamma" label="Shear strain (rad)" value="0.00063" step="any" />
        </div>
        <div data-show-when="mode:enu">
            <x-calc.field name="E" label="Young's modulus" value="200" min="0" placeholder="Young's modulus">
                <label for="calc-E-unit" class="sr-only">Young's modulus unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:enu">
            <x-calc.field name="nu" label="Poisson's ratio" value="0.29" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="gpa" />
    </div>

    <x-calc.result label="Shear modulus G" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'gpa', 'mode' => 'enu', 'tau' => 50, 'tau-unit' => 'mpa', 'gamma' => 0.00063, 'E' => 200, 'E-unit' => 'gpa', 'nu' => 0.29],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'typical' => ['label' => 'Typical values'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
