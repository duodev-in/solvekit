<x-calc.page
    title="3x Rent Calculator - SolveKit"
    description="Free 3x Rent Calculator: income ≥ 3 × monthly rent. Many landlords require gross monthly income of at least three times the rent."
    lede="Work out the income needed (gross, yearly) from the monthly rent."
    about="Many landlords require gross monthly income of at least three times the rent. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => '3x_rent', 'fields' => ['rent']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly rent.'],
        ['name' => 'Read the result', 'text' => 'The income needed (gross, yearly) appears as you type, with monthly income needed, hourly at 40 h a week below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the income needed (gross, yearly)?', 'answer' => 'Income ≥ 3 × monthly rent.'],
        ['question' => 'What is the income needed (gross, yearly) for monthly rent $1,800?', 'answer' => '$64,800.00. Monthly income needed: $5,400.00.'],
        ['question' => 'And for monthly rent $2,650?', 'answer' => '$95,400.00. Monthly income needed: $7,950.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Some cities limit income requirements; landlords may also accept guarantors.'],
    ]"
>
    <x-calc.field name="rent" label="Monthly rent" value="1800" step="0.01" suffix="$" />

    <x-calc.result label="Income needed (gross, yearly)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rent' => 1800],
        'Example B' => ['rent' => 2650],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Monthly income needed'],
            'r2' => ['label' => 'Hourly at 40 h a week'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>income ≥ 3 × monthly rent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
