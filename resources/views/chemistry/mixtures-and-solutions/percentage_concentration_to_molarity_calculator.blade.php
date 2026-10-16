<x-calc.page
    title="Percentage Concentration to Molarity Calculator - SolveKit"
    description="Free calculator to convert percent by mass (w/w) and density to molarity, with presets for concentrated acids and bases."
    lede="Convert a percent concentration to molarity, for example 37% HCl."
    about="Molarity = % × density (g/mL) × 10 ÷ molar mass. Presets use the nominal compositions of commercial concentrated reagents from OpenStax Chemistry 2e; check your bottle's label, as real lots vary slightly."
    :calc="['engine' => 'chem-mix', 'tool' => 'percent_to_molarity', 'fields' => ['reagent', 'formula', 'percent', 'density'], 'data' => ['reagents' => config('chemistry_data.reagents'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick a reagent', 'text' => 'Or enter your own percent, density and formula.'],
        ['name' => 'Read the molarity', 'text' => 'And how much makes 1 L of 1 M.'],
    ]"
    :faqs="[
        ['question' => 'What is the molarity of concentrated HCl?', 'answer' => 'About 11.6 M for 36% at 1.18 g/mL.'],
        ['question' => 'What is the molarity of concentrated sulfuric acid?', 'answer' => 'About 18.0 M (96%, 1.84 g/mL).'],
        ['question' => 'How do I dilute it safely?', 'answer' => 'Always add acid to water, slowly, with eye protection.'],
    ]"
>
    <x-calc.select name="reagent" label="Reagent" :options="collect(config('chemistry_data.reagents'))->map(fn ($r) => $r['name'].' '.$r['percent'].'%')->put('custom', 'Custom')->all()" selected="hydrochloric_acid" />

    <div data-show-when="reagent:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="formula" label="Formula" value="H2SO4" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="percent" label="Percent by mass" value="96" min="0" max="100" suffix="%" />
            <x-calc.field name="density" label="Density" value="1.84" min="0" suffix="g/mL" />
        </div>
    </div>

    <x-calc.result label="Molarity" />

    <x-calc.options :examples="[
        'Hydrochloric acid 36%' => ['reagent' => 'hydrochloric_acid'],
        'Sulfuric acid 96%' => ['reagent' => 'sulfuric_acid'],
        'Ammonia 28%' => ['reagent' => 'aqueous_ammonia'],
        'Custom 30% H₂O₂' => ['reagent' => 'custom', 'formula' => 'H2O2', 'percent' => 30, 'density' => 1.11],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molality' => ['label' => 'Molality'],
            'fraction' => ['label' => 'Mole fraction'],
            'dilute' => ['label' => 'To make 1 L of 1 M'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = % × ρ × 10 ÷ MW</li>
            <li>molality = (% ÷ MW) ÷ (100 − %) × 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
