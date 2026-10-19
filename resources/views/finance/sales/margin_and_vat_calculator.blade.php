<x-calc.page
    title="Margin and VAT Calculator - SolveKit"
    description="Free Margin and VAT Calculator: net price = cost ÷ (1 − margin). Margins are worked on prices excluding VAT; VAT is added for consumers."
    lede="Work out the price including VAT from cost (excluding VAT), margin and VAT rate."
    about="Margins are worked on prices excluding VAT; VAT is added for consumers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_and_vat', 'fields' => ['cost', 'margin', 'vat']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost (excluding VAT), Margin, VAT rate.'],
        ['name' => 'Read the result', 'text' => 'The price including VAT appears as you type, with price excluding VAT, VAT below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price including VAT?', 'answer' => 'Net price = cost ÷ (1 − margin); gross = net × (1 + VAT).'],
        ['question' => 'What is the price including VAT for cost $50, margin 35%, VAT rate 20%?', 'answer' => '$92.31. Price excluding VAT: $76.92.'],
        ['question' => 'And for cost $15, margin 60%, VAT rate 21%?', 'answer' => '$45.38. Price excluding VAT: $37.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'UK standard VAT is 20%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Cost (excluding VAT)" value="50" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Margin" value="35" step="any" suffix="%" />
        <x-calc.field name="vat" label="VAT rate" value="20" step="any" suffix="%" />
    </div>

    <x-calc.result label="Price including VAT" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 50, 'margin' => 35, 'vat' => 20],
        'Example B' => ['cost' => 15, 'margin' => 60, 'vat' => 21],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Price excluding VAT'],
            'r2' => ['label' => 'VAT'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net price = cost ÷ (1 − margin)</li>
            <li>gross = net × (1 + VAT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
