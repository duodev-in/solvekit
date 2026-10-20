<x-calc.page
    title="Principal Stress Calculator - SolveKit"
    description="Free principal stress calculator: principal stresses, their angle, maximum shear and von Mises stress for plane stress."
    lede="Find principal stresses."
    about="On some planes through any stressed point the shear vanishes; the normal stresses there are the principal stresses, the largest and smallest normal stresses at that point."
    :calc="['engine' => 'ph-mat', 'tool' => 'principal_stress', 'fields' => ['sx', 'sy', 'txy', 'out'], 'unitFields' => ['sx' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'sy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'txy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is σ₁ for σx = 80, σy = −40, τxy = 30 MPa?', 'answer' => '87.082 MPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sx" label="σx" value="80" min="0" placeholder="σx">
            <label for="calc-sx-unit" class="sr-only">σx unit</label>
            <select id="calc-sx-unit" name="sx-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sy" label="σy" value="-40" min="0" placeholder="σy">
            <label for="calc-sy-unit" class="sr-only">σy unit</label>
            <select id="calc-sy-unit" name="sy-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="txy" label="τxy" value="30" min="0" placeholder="τxy">
            <label for="calc-txy-unit" class="sr-only">τxy unit</label>
            <select id="calc-txy-unit" name="txy-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
    </div>

    <x-calc.result label="Major principal stress σ₁" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpa', 'sx' => 80, 'sx-unit' => 'mpa', 'sy' => -40, 'sy-unit' => 'mpa', 'txy' => 30, 'txy-unit' => 'mpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            's2' => ['label' => 'Minor principal stress σ₂'],
            'tmax' => ['label' => 'Maximum in-plane shear'],
            'tabs' => ['label' => 'Absolute maximum shear (with σ₃ = 0)'],
            'tp' => ['label' => 'Principal angle θp'],
            'vm' => ['label' => 'Von Mises stress'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
