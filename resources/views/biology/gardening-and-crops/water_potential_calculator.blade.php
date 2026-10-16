<x-calc.page
    title="Water Potential Calculator - SolveKit"
    description="Free water potential calculator: total, solute and pressure potential in MPa."
    lede="Work out water potential from solute and pressure potential."
    about="Water potential Ψ = Ψs + Ψp. Solute potential is Ψs = −iCRT, where i is the ionization constant (1 for sucrose, about 2 for NaCl), C the molar concentration, R = 0.0083145 L·MPa/(mol·K) and T the absolute temperature."
    :calc="['engine' => 'garden', 'tool' => 'water_potential', 'fields' => ['ionization', 'concentration', 'temp', 'pressure'], 'unitFields' => ['temp' => collect(config('units.temperature'))->only(['c', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter the solution', 'text' => 'Ionization constant and molar concentration.'],
        ['name' => 'Enter temperature and pressure', 'text' => 'Pressure potential is 0 in an open beaker.'],
    ]"
    :faqs="[
        ['question' => 'Which way does water move?', 'answer' => 'From higher (less negative) to lower (more negative) water potential.'],
        ['question' => 'What is the water potential of pure water?', 'answer' => '0 MPa at atmospheric pressure.'],
        ['question' => 'What i should I use for NaCl?', 'answer' => 'About 2, since it splits into two ions.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ionization" label="Ionization constant (i)" value="1" min="0" step="0.1" />
        <x-calc.field name="concentration" label="Concentration" value="0.3" min="0" step="0.01" suffix="mol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temp" label="Temperature" value="22" placeholder="Temperature">
            <label for="calc-temp-unit" class="sr-only">Temperature unit</label>
            <select id="calc-temp-unit" name="temp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pressure" label="Pressure potential" value="0" step="0.01" suffix="MPa" />
    </div>

    <x-calc.result label="Water potential (Ψ)" />

    <x-calc.options :examples="[
        '0.3 M sucrose' => ['ionization' => 1, 'concentration' => 0.3, 'temp' => 22, 'pressure' => 0],
        '0.1 M NaCl' => ['ionization' => 2, 'concentration' => 0.1, 'temp' => 25, 'pressure' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'solute' => ['label' => 'Solute potential Ψs'],
            'pressure' => ['label' => 'Pressure potential Ψp'],
            'bars' => ['label' => 'In bars'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Ψ = Ψs + Ψp</li>
            <li>Ψs = −iCRT, R = 0.0083145 L·MPa/(mol·K)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
