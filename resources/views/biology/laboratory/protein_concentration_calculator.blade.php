<x-calc.page
    title="Protein Concentration Calculator - SolveKit"
    description="Free protein concentration calculator: mg/mL from A280 with the extinction coefficient and molecular weight, or the quick A280 = 1 mg/mL estimate."
    lede="Work out protein concentration from an A280 reading."
    about="With the extinction coefficient ε and molecular weight, Beer–Lambert gives the concentration accurately: c = A ÷ (ε × l). Without them, A280 ≈ 1 for 1 mg/mL is a rough estimate that can be off by half or more."
    :calc="['engine' => 'lab', 'tool' => 'protein_concentration', 'fields' => ['mode', 'a280', 'path', 'epsilon', 'weight']]"
    :how-to="[
        ['name' => 'Choose a method', 'text' => 'Use ε and MW when you know them.'],
        ['name' => 'Enter A280 and path', 'text' => '1 cm for a cuvette.'],
        ['name' => 'Enter ε and MW', 'text' => 'From the protein molecular weight calculator.'],
    ]"
    :faqs="[
        ['question' => 'Where do I get ε?', 'answer' => 'Calculate it from the sequence (Trp, Tyr and cystine content), e.g. with the protein molecular weight calculator.'],
        ['question' => 'What is ε for BSA?', 'answer' => 'About 43,824 M⁻¹cm⁻¹ at 280 nm; MW 66,430.'],
        ['question' => 'Why is A280 ≈ 1 mg/mL inaccurate?', 'answer' => 'Proteins with more Trp and Tyr absorb more, so the true factor ranges widely.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['epsilon' => 'ε and MW', 'simple' => 'A280 ≈ 1 mg/mL']" selected="epsilon" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a280" label="A280" value="0.8" min="0" />
        <x-calc.field name="path" label="Path length" value="1" min="0" suffix="cm" />
    </div>

    <div data-show-when="mode:epsilon">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="epsilon" label="Extinction coefficient ε" value="43824" min="0" suffix="M⁻¹cm⁻¹" />
            <x-calc.field name="weight" label="Molecular weight" value="66430" min="0" suffix="g/mol" />
        </div>
    </div>

    <x-calc.result label="Concentration" />

    <x-calc.options :examples="[
        'BSA' => ['mode' => 'epsilon', 'a280' => 0.8, 'path' => 1, 'epsilon' => 43824, 'weight' => 66430],
        'Quick estimate' => ['mode' => 'simple', 'a280' => 1.4, 'path' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molar' => ['label' => 'Molar concentration'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c (M) = A280 ÷ (ε × l)</li>
            <li>mg/mL = c × MW</li>
            <li>quick: mg/mL ≈ A280 ÷ l</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
