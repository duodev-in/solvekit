<x-calc.page
    title="Realtor Commission Calculator with VAT - SolveKit"
    description="Free Realtor Commission Calculator with VAT: fee = price × rate × (1 + VAT). In the UK and elsewhere, estate agent fees carry VAT (20% in the UK)."
    lede="Work out the commission including VAT from sale price, commission rate and VAT."
    about="In the UK and elsewhere, estate agent fees carry VAT (20% in the UK). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'realtor_commission_calculator_with_vat', 'fields' => ['price', 'rate', 'vat']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Sale price, Commission rate, VAT.'],
        ['name' => 'Read the result', 'text' => 'The commission including VAT appears as you type, with commission before VAT, VAT below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the commission including VAT?', 'answer' => 'Fee = price × rate × (1 + VAT).'],
        ['question' => 'What is the commission including VAT for sale price $300,000, commission rate 1.5%, VAT 20%?', 'answer' => '$5,400.00. Commission before VAT: $4,500.00.'],
        ['question' => 'And for sale price $425,000, commission rate 1.2%, VAT 20%?', 'answer' => '$6,120.00. Commission before VAT: $5,100.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Check whether a quoted rate includes VAT.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Sale price" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Commission rate" value="1.5" step="any" suffix="%" />
        <x-calc.field name="vat" label="VAT" value="20" step="any" suffix="%" />
    </div>

    <x-calc.result label="Commission including VAT" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 300000, 'rate' => 1.5, 'vat' => 20],
        'Example B' => ['price' => 425000, 'rate' => 1.2, 'vat' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Commission before VAT'],
            'r2' => ['label' => 'VAT'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fee = price × rate × (1 + VAT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
