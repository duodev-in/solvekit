<x-calc.page
    title="Combustion Analysis Calculator - SolveKit"
    description="Free combustion analysis calculator: empirical and molecular formula from the masses of CO₂ and H₂O produced."
    lede="Find an empirical formula from combustion analysis data."
    about="Burning a CₓHᵧOz compound turns all its carbon into CO₂ and its hydrogen into H₂O. Carbon = CO₂ mass × 12.011 ÷ 44.009 and hydrogen = H₂O mass × 2.016 ÷ 18.015; oxygen is the mass left over. Nitrogen, if measured separately, can be added."
    :calc="['engine' => 'chem-organic', 'tool' => 'combustion_analysis', 'fields' => ['sample', 'co2', 'h2o', 'n_mass', 'molar_mass'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['weight'])]]"
    :how-to="[
        ['name' => 'Enter the masses', 'text' => 'Sample, CO₂ and H₂O.'],
        ['name' => 'Add a molar mass', 'text' => 'For the molecular formula.'],
    ]"
    :faqs="[
        ['question' => 'How does combustion analysis work?', 'answer' => 'Carbon and hydrogen are trapped as CO₂ and H₂O and weighed.'],
        ['question' => 'How is oxygen found?', 'answer' => 'By difference: sample mass minus carbon, hydrogen and any nitrogen.'],
        ['question' => 'What compound gives C₃H₈O?', 'answer' => 'Propanol or isopropanol, among others.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sample" label="Sample mass" value="0.255" min="0" suffix="g" />
        <x-calc.field name="co2" label="CO₂ formed" value="0.561" min="0" suffix="g" />
        <x-calc.field name="h2o" label="H₂O formed" value="0.306" min="0" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n_mass" label="Nitrogen (optional)" value="" min="0" suffix="g" placeholder="Optional" />
        <x-calc.field name="molar_mass" label="Molar mass (optional)" value="60.1" min="0" suffix="g/mol" placeholder="Optional" />
    </div>

    <x-calc.result label="Empirical formula" />

    <x-calc.options :examples="[
        'Propanol' => ['sample' => 0.255, 'co2' => 0.561, 'h2o' => 0.306, 'n_mass' => '', 'molar_mass' => 60.1],
        'Glucose' => ['sample' => 1, 'co2' => 1.466, 'h2o' => 0.6, 'n_mass' => '', 'molar_mass' => 180.16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molecular' => ['label' => 'Molecular formula'],
            'carbon' => ['label' => 'Carbon'],
            'hydrogen' => ['label' => 'Hydrogen'],
            'oxygen' => ['label' => 'Oxygen'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m(C) = m(CO₂) × 12.011 ÷ 44.009</li>
            <li>m(H) = m(H₂O) × 2.016 ÷ 18.015</li>
            <li>m(O) = sample − C − H</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
