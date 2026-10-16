<x-calc.page
    title="Ionic Strength Calculator - SolveKit"
    description="Free ionic strength calculator: I = ½ Σ c z² from a salt and its concentration, or a list of ions."
    lede="Work out the ionic strength of a solution."
    about="Ionic strength I = ½ Σ cᵢ zᵢ² weights each ion by its charge squared, so multiply charged ions count far more. Enter one salt (split into its ions automatically) or any mixture of ions."
    :calc="['engine' => 'chem-electro', 'tool' => 'ionic_strength', 'fields' => ['mode', 'salt', 'salt_concentration', 'ions'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter a salt', 'text' => 'Or a list of ions with concentrations.'],
    ]"
    :faqs="[
        ['question' => 'What is the ionic strength of 0.1 M NaCl?', 'answer' => '0.1 mol/L.'],
        ['question' => 'Why is 0.1 M Na₂SO₄ 0.3?', 'answer' => 'Sulfate\'s 2− charge counts four times: ½ (0.2 × 1 + 0.1 × 4) = 0.3.'],
        ['question' => 'Where is ionic strength used?', 'answer' => 'In activity coefficients, buffer design and protein solubility.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['salt' => 'A salt', 'ions' => 'A list of ions']" selected="salt" />

    <div data-show-when="mode:salt">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="salt" label="Salt formula" value="Na2SO4" type="text" help="e.g. NaCl, CaCl2, Al2(SO4)3" />
            <x-calc.field name="salt_concentration" label="Concentration" value="0.1" min="0" suffix="mol/L" />
        </div>
    </div>

    <div data-show-when="mode:ions" hidden>
        <x-calc.textarea name="ions" label="Ions and concentrations" value="Ca2+ 0.01
Cl- 0.02
Na+ 0.05
SO4^2- 0.025" help="One per line: ion and mol/L" rows="4" />
    </div>

    <x-calc.result label="Ionic strength" />

    <x-calc.options :examples="[
        '0.1 M Na₂SO₄' => ['mode' => 'salt', 'salt' => 'Na2SO4', 'salt_concentration' => 0.1],
        '0.05 M CaCl₂' => ['mode' => 'salt', 'salt' => 'CaCl2', 'salt_concentration' => 0.05],
        'Mixture of ions' => ['mode' => 'ions', 'ions' => 'Ca2+ 0.01
Cl- 0.02
Na+ 0.05
SO4^2- 0.025'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Ions'],
            'net' => ['label' => 'Net charge'],
        ]" />
        <x-calc.quick-ref heading="Each ion" name="ions" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>I = ½ Σ cᵢ zᵢ²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
