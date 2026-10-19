<x-calc.page
    title="Net Effective Rent Calculator - SolveKit"
    description="Free Net Effective Rent Calculator: NER = rent × (term − free months) ÷ term. Net effective rent spreads concessions such as free months over the lease."
    lede="Work out the net effective rent from monthly rent, lease term and free months."
    about="Net effective rent spreads concessions such as free months over the lease. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_effective_rent', 'fields' => ['rent', 'months', 'free']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly rent, Lease term, Free months.'],
        ['name' => 'Read the result', 'text' => 'The net effective rent appears as you type, with total paid below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net effective rent?', 'answer' => 'NER = rent × (term − free months) ÷ term.'],
        ['question' => 'What is the net effective rent for monthly rent $3,000, lease term 12 months, free months 1?', 'answer' => '$2,750.00. Total paid: $33,000.00.'],
        ['question' => 'And for monthly rent $2,400, lease term 13 months, free months 1?', 'answer' => '$2,215.38. Total paid: $28,800.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Renewal rent is usually the gross rent, not the net effective.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rent" label="Monthly rent" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="months" label="Lease term" value="12" min="0" step="any" suffix="months" />
        <x-calc.field name="free" label="Free months" value="1" min="0" step="any" suffix="months" />
    </div>

    <x-calc.result label="Net effective rent" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rent' => 3000, 'months' => 12, 'free' => 1],
        'Example B' => ['rent' => 2400, 'months' => 13, 'free' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total paid'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NER = rent × (term − free months) ÷ term</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
