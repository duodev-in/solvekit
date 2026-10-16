<x-calc.page
    title="Recombination Frequency Calculator - SolveKit"
    description="Free recombination frequency calculator: percent recombinants and map distance in centimorgans from a test cross."
    lede="Work out recombination frequency and map distance."
    about="In a test cross, offspring with new allele combinations are recombinants. The recombination frequency is recombinants ÷ total; 1% corresponds to 1 centimorgan. Frequencies near 50% mean the genes behave as if unlinked."
    :calc="['engine' => 'genetics', 'tool' => 'recombination', 'fields' => ['recombinants', 'total']]"
    :how-to="[
        ['name' => 'Count recombinants', 'text' => 'Offspring with combinations not seen in either parent.'],
        ['name' => 'Enter the total', 'text' => 'All offspring scored.'],
    ]"
    :faqs="[
        ['question' => 'What is a centimorgan?', 'answer' => 'A map distance where 1% of offspring are recombinant.'],
        ['question' => 'Why can\'t recombination exceed 50%?', 'answer' => 'Unlinked genes give 50% recombinants by independent assortment.'],
        ['question' => 'Is map distance additive?', 'answer' => 'Only for close genes; double crossovers make long distances underestimated.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="recombinants" label="Recombinant offspring" value="17" min="0" step="1" />
        <x-calc.field name="total" label="Total offspring" value="100" min="0" step="1" />
    </div>

    <x-calc.result label="Recombination frequency" />

    <x-calc.options :examples="[
        '17 of 100' => ['recombinants' => 17, 'total' => 100],
        'Unlinked' => ['recombinants' => 248, 'total' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'Map distance'],
            'parental' => ['label' => 'Parental types'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RF = recombinants ÷ total</li>
            <li>1% RF = 1 cM</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
