<x-calc.page
    title="Molarity Calculator - SolveKit"
    description="Free molarity calculator: mass to weigh, concentration or volume for a solution from molar mass, in M, mM, µM or nM."
    lede="Work out the mass to weigh, the concentration or the volume of a solution."
    about="Molarity is moles of solute per liter of solution. Mass = molarity × volume × molar mass; any one of the three can be found from the other two. Use the formula weight on the bottle, which includes any water of hydration."
    :calc="['engine' => 'lab', 'tool' => 'molarity', 'fields' => ['mode', 'concentration', 'conc_unit', 'volume', 'mass', 'formula', 'weight'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Mass to weigh, the concentration you made, or the volume to make up to.'],
        ['name' => 'Enter the molar mass', 'text' => 'From the label (formula weight).'],
        ['name' => 'Enter the other values', 'text' => 'Volume is the final volume of solution, not of water added.'],
    ]"
    :faqs="[
        ['question' => 'How do I make a 1 M NaCl solution?', 'answer' => 'Dissolve 58.44 g NaCl in water and make up to 1 L.'],
        ['question' => 'What is the difference between molarity and molality?', 'answer' => 'Molarity is per liter of solution; molality is per kilogram of solvent.'],
        ['question' => 'Should I use the hydrated molar mass?', 'answer' => 'Yes, if you are weighing the hydrate, e.g. CaCl₂·2H₂O is 147.0 g/mol.'],
        ['question' => 'Can I type the formula instead?', 'answer' => 'Yes. Enter it in the formula box (e.g. CuSO4·5H2O) and the molar mass is worked out from IUPAC atomic weights.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['mass' => 'Mass', 'concentration' => 'Concentration', 'volume' => 'Volume']" selected="mass" />

    <div data-show-when="mode:mass,volume">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="concentration" label="Concentration" value="1" min="0" />
            <x-calc.select name="conc_unit" label="Unit" :options="['M' => 'M', 'mM' => 'mM', 'uM' => 'µM', 'nM' => 'nM']" selected="M" />
        </div>
    </div>

    <div data-show-when="mode:mass,concentration">
        <x-calc.field name="volume" label="Final volume" value="500" min="0" placeholder="Final volume">
            <label for="calc-volume-unit" class="sr-only">Final volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:concentration,volume" hidden>
        <x-calc.field name="mass" label="Mass of solute" value="10" min="0" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Formula (optional)" value="" type="text" help="Sets the molar mass for you" placeholder="e.g. NaCl" />
        <x-calc.field name="weight" label="Molar mass" value="58.44" min="0" suffix="g/mol" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '1 M NaCl, 500 mL' => ['mode' => 'mass', 'concentration' => 1, 'conc_unit' => 'M', 'volume' => 500, 'volume-unit' => 'ml', 'weight' => 58.44, 'formula' => ''],
        '50 mM Tris, 1 L' => ['mode' => 'mass', 'concentration' => 50, 'conc_unit' => 'mM', 'volume' => 1, 'volume-unit' => 'l', 'weight' => 121.14, 'formula' => ''],
        '10 g glucose in 250 mL' => ['mode' => 'concentration', 'mass' => 10, 'volume' => 250, 'volume-unit' => 'ml', 'weight' => 180.16, 'formula' => ''],
        '0.1 M CuSO₄·5H₂O, 250 mL' => ['mode' => 'mass', 'concentration' => 0.1, 'conc_unit' => 'M', 'volume' => 250, 'volume-unit' => 'ml', 'formula' => 'CuSO4·5H2O', 'weight' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mg' => ['label' => 'Also'],
            'moles' => ['label' => 'Amount'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mass (g) = M × V (L) × MW (g/mol)</li>
            <li>M = mass ÷ MW ÷ V</li>
            <li>V = mass ÷ MW ÷ M</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
