<x-calc.page
    title="Prorated Rent Calculator - SolveKit"
    description="Free Prorated Rent Calculator: prorated = rent × days ÷ days in month. Prorated rent covers a partial month."
    lede="Work out the prorated rent from monthly rent, days occupied and days in the month."
    about="Prorated rent covers a partial month. Some leases use 30 days or 365 ÷ 12 instead of the actual month. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'prorated_rent', 'fields' => ['rent', 'days', 'month']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly rent, Days occupied, Days in the month.'],
        ['name' => 'Read the result', 'text' => 'The prorated rent appears as you type, with daily rate, using a 365-day year below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the prorated rent?', 'answer' => 'Prorated = rent × days ÷ days in month.'],
        ['question' => 'What is the prorated rent for monthly rent $1,500, days occupied 12, days in the month 30?', 'answer' => '$600.00. Daily rate: $50.00.'],
        ['question' => 'And for monthly rent $2,100, days occupied 18, days in the month 31?', 'answer' => '$1,219.35. Daily rate: $67.74.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Check your lease for its method.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rent" label="Monthly rent" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days occupied" value="12" min="0" step="any" suffix="days" />
        <x-calc.field name="month" label="Days in the month" value="30" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Prorated rent" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rent' => 1500, 'days' => 12, 'month' => 30],
        'Example B' => ['rent' => 2100, 'days' => 18, 'month' => 31],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Daily rate'],
            'r2' => ['label' => 'Using a 365-day year'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>prorated = rent × days ÷ days in month</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
