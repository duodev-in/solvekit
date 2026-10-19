<x-calc.page
    title="Rental Commission Calculator - SolveKit"
    description="Free Rental Commission Calculator: fee = monthly rent × months (or % of a year's rent). Rental agents are often paid one month's rent or 8–15% of the first year's rent."
    lede="Work out the commission from monthly rent and fee in months of rent."
    about="Rental agents are often paid one month's rent or 8–15% of the first year's rent. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'rental_commission', 'fields' => ['rent', 'months']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly rent, Fee in months of rent.'],
        ['name' => 'Read the result', 'text' => 'The commission appears as you type, with as % of yearly rent below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the commission?', 'answer' => 'Fee = monthly rent × months (or % of a year\'s rent).'],
        ['question' => 'What is the commission for monthly rent $2,000, fee in months of rent 1?', 'answer' => '$2,000.00. As % of yearly rent: 8.333%.'],
        ['question' => 'And for monthly rent $3,200, fee in months of rent 1.5?', 'answer' => '$4,800.00. As % of yearly rent: 12.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Some places limit who can be charged rental fees (e.g. New York\'s 2025 FARE Act).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rent" label="Monthly rent" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="months" label="Fee in months of rent" value="1" step="any" />
    </div>

    <x-calc.result label="Commission" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rent' => 2000, 'months' => 1],
        'Example B' => ['rent' => 3200, 'months' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'As % of yearly rent'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fee = monthly rent × months (or % of a year's rent)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
