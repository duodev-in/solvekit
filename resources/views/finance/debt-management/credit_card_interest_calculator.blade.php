<x-calc.page
    title="Credit Card Interest Calculator - SolveKit"
    description="Free credit card interest calculator: interest for a billing cycle from the average daily balance, APR and days, as card issuers compute it."
    lede="Work out credit card interest for a month."
    about="Most US issuers use the average daily balance method: interest = average daily balance × daily periodic rate (APR ÷ 365) × days in the billing cycle. Paying the full statement balance by the due date avoids interest on purchases (the grace period). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'card_interest', 'fields' => ['balance', 'apr', 'days']]"
    :how-to="[
        ['name' => 'Enter the average daily balance', 'text' => 'From the statement.'],
        ['name' => 'Enter the APR and cycle length', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What interest does a $3,000 average balance at 24.99% cost in 30 days?', 'answer' => '$61.62.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="balance" label="Average daily balance" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="apr" label="APR" value="24.99" step="any" suffix="%" />
        <x-calc.field name="days" label="Days in the billing cycle" value="30" min="1" step="1" suffix="days" />
    </div>

    <x-calc.result label="Interest this billing cycle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 3000, 'apr' => 24.99, 'days' => 30],
        '31-day cycle' => ['balance' => 1200, 'apr' => 19.99, 'days' => 31],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'daily' => ['label' => 'Daily periodic rate'],
            'perDay' => ['label' => 'Interest per day'],
            'year' => ['label' => 'Interest over a year'],
            'effective' => ['label' => 'Effective annual rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>interest = ADB × APR ÷ 365 × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
