<x-calc.page
    title="Mohr's Circle Calculator - SolveKit"
    description="Free Mohr's circle calculator: principal stresses, maximum shear and rotated stresses for plane stress, with the circle drawn."
    lede="Draw Mohr's circle."
    about="Mohr's circle shows every combination of normal and shear stress on planes through a point. Its centre is the average normal stress and its radius the maximum shear; the ends of the horizontal diameter are the principal stresses."
    :calc="['engine' => 'ph-mat', 'tool' => 'mohr', 'fields' => ['sx', 'sy', 'txy', 'th', 'out'], 'unitFields' => ['sx' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'sy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'txy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What are the principal stresses for σx = 80, σy = −40, τxy = 30 MPa?', 'answer' => '87.082 MPa and −47.082 MPa (−6.82867 ksi).'],
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
        <x-calc.field name="th" label="Rotate the element by" value="30" placeholder="Rotate the element by">
            <label for="calc-th-unit" class="sr-only">Rotate the element by unit</label>
            <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
    </div>

    <x-calc.result label="Major principal stress σ₁" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpa', 'sx' => 80, 'sx-unit' => 'mpa', 'sy' => -40, 'sy-unit' => 'mpa', 'txy' => 30, 'txy-unit' => 'mpa', 'th' => 30, 'th-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Mohr's circle" name="circle" />
        <x-calc.rows heading="Details" :rows="[
            's2' => ['label' => 'Minor principal stress σ₂'],
            'tmax' => ['label' => 'Maximum in-plane shear'],
            'tp' => ['label' => 'Principal angle θp'],
            'rot' => ['label' => 'Stresses on the rotated element'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
