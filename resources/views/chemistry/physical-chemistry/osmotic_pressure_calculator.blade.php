<x-calc.page
    title="Osmotic Pressure Calculator - SolveKit"
    description="Free osmotic pressure calculator: Π = iMRT for a solution, or molar mass of a solute from a measured osmotic pressure."
    lede="Work out osmotic pressure, or a molar mass from it."
    about="The van 't Hoff equation Π = iMRT gives the osmotic pressure of a dilute solution. Because Π is large even for small amounts, it is used to find the molar mass of proteins and polymers."
    :calc="['engine' => 'chem-physical', 'tool' => 'osmotic', 'fields' => ['mode', 'molarity', 'pressure', 'mass', 'volume', 'temperature', 'vant_hoff'], 'unitFields' => ['pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Pressure or molar mass.'],
        ['name' => 'Enter the values', 'text' => 'Use i = 2 for NaCl, 1 for sugars and proteins.'],
    ]"
    :faqs="[
        ['question' => 'What is osmotic pressure?', 'answer' => 'The pressure needed to stop water flowing across a membrane into a solution.'],
        ['question' => 'Why is it used for proteins?', 'answer' => 'A tiny amount gives a measurable pressure, so molar masses can be found.'],
        ['question' => 'What is the osmotic pressure of seawater?', 'answer' => 'About 2.7 MPa (27 atm).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['pressure' => 'Osmotic pressure', 'molar_mass' => 'Molar mass']" selected="pressure" />

    <div data-show-when="mode:pressure">
        <x-calc.field name="molarity" label="Molarity" value="0.1" min="0" suffix="mol/L" />
    </div>

    <div data-show-when="mode:molar_mass" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="pressure" label="Measured pressure" value="0.8" min="0" placeholder="Measured pressure">
                <label for="calc-pressure-unit" class="sr-only">Measured pressure unit</label>
                <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="mass" label="Solute mass" value="1" min="0" suffix="g" />
            <x-calc.field name="volume" label="Solution volume" value="100" min="0" placeholder="Solution volume">
                <label for="calc-volume-unit" class="sr-only">Solution volume unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temperature" label="Temperature" value="25" suffix="°C" />
        <x-calc.field name="vant_hoff" label="van 't Hoff factor i" value="1" min="0" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '0.1 M glucose' => ['mode' => 'pressure', 'molarity' => 0.1, 'temperature' => 25, 'vant_hoff' => 1],
        '0.15 M NaCl (saline)' => ['mode' => 'pressure', 'molarity' => 0.154, 'temperature' => 37, 'vant_hoff' => 2],
        'Protein molar mass' => ['mode' => 'molar_mass', 'pressure' => 0.37, 'pressure-unit' => 'kpa', 'mass' => 1, 'volume' => 100, 'volume-unit' => 'ml', 'temperature' => 25, 'vant_hoff' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'atm' => ['label' => 'In atm'],
            'molar' => ['label' => 'Molarity'],
            'mmhg' => ['label' => 'In mmHg'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Π = iMRT</li>
            <li>M solute = m ÷ (Π V ÷ iRT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
