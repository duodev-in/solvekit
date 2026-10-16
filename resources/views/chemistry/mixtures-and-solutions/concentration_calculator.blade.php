<x-calc.page
    title="Concentration Calculator - SolveKit"
    description="Free concentration calculator: convert a solution concentration between molarity, g/L, mg/L, ppm, % w/v, % w/w, molality and mole fraction."
    lede="Convert a concentration into every common unit at once."
    about="Molarity, mass concentration and % w/v follow from the molar mass. Units based on mass of solution (ppm, % w/w) or solvent (molality, mole fraction) also need the solution density. Water is taken as the solvent for the mole fraction."
    :calc="['engine' => 'chem-mix', 'tool' => 'concentration', 'fields' => ['value', 'from', 'formula', 'density'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the value and unit', 'text' => 'Any of ten units.'],
        ['name' => 'Enter the solute and density', 'text' => 'Density matters for mass-based units.'],
    ]"
    :faqs="[
        ['question' => 'What is the difference between % w/v and % w/w?', 'answer' => 'w/v is grams per 100 mL of solution; w/w is grams per 100 g of solution.'],
        ['question' => 'Is ppm the same as mg/L?', 'answer' => 'Only when the solution density is 1 g/mL.'],
        ['question' => 'Why does molality need density?', 'answer' => 'It is per kilogram of solvent, so the solvent mass in a liter of solution must be known.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Concentration" value="1" min="0" />
        <x-calc.select name="from" label="Unit" :options="['m' => 'mol/L (M)', 'mm' => 'mmol/L (mM)', 'um' => 'µmol/L (µM)', 'gl' => 'g/L', 'mgl' => 'mg/L', 'ppm' => 'ppm (mg/kg)', 'wv' => '% w/v', 'ww' => '% w/w', 'molal' => 'mol/kg (molal)', 'fraction' => 'Mole fraction']" selected="m" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Solute formula" value="NaCl" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
        <x-calc.field name="density" label="Solution density" value="1.04" min="0" suffix="g/mL" help="Use 1.00 for dilute water solutions" />
    </div>

    <x-calc.result label="Concentration" />

    <x-calc.options :examples="[
        '1 M NaCl' => ['value' => 1, 'from' => 'm', 'formula' => 'NaCl', 'density' => 1.04],
        '0.9% saline' => ['value' => 0.9, 'from' => 'wv', 'formula' => 'NaCl', 'density' => 1.005],
        '50 ppm nitrate' => ['value' => 50, 'from' => 'ppm', 'formula' => 'NO3', 'density' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="In every unit" name="units" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g/L = M × MW; % w/v = g/L ÷ 10</li>
            <li>ppm = mg/L ÷ density; % w/w = g/L ÷ (10 × density)</li>
            <li>molality = M ÷ (kg of solvent per liter)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
