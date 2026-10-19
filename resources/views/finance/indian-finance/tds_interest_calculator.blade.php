<x-calc.page
    title="TDS Interest Calculator - SolveKit"
    description="Free TDS interest calculator: interest under section 201(1A) at 1% a month for TDS not deducted or 1.5% a month for TDS deducted but not paid, counting part months in full."
    lede="Work out interest on late TDS."
    about="Section 201(1A): if TDS was not deducted, interest is 1% a month from the date it was due to be deducted to the date it is deducted; if deducted but not paid, 1.5% a month from the date of deduction to the date of payment. Each part of a month counts as a full month. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'tds_interest', 'fields' => ['amount', 'type', 'from', 'to'], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the TDS amount', 'text' => ''],
        ['name' => 'Choose the default and dates', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the interest on ₹50,000 deducted April 15 and paid July 20, 2026?', 'answer' => '₹3,000 for 4 months.'],
        ['question' => 'And if it was not deducted?', 'answer' => '₹2,000.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="TDS amount" value="50000" step="1" suffix="₹" />
        <x-calc.select name="type" label="Default" :options="['not_deducted' => 'Not deducted (1%)', 'not_paid' => 'Deducted, not paid (1.5%)']" selected="not_paid" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="from" label="From" value="2026-04-15" type="date" />
        <x-calc.field name="to" label="To" value="2026-07-20" type="date" />
    </div>

    <x-calc.result label="Interest on late TDS" />

    <x-calc.options :decimals="false" :examples="[
        'Not paid' => ['amount' => 50000, 'type' => 'not_paid', 'from' => '2026-04-15', 'to' => '2026-07-20'],
        'Not deducted' => ['amount' => 50000, 'type' => 'not_deducted', 'from' => '2026-04-15', 'to' => '2026-07-20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'months' => ['label' => 'Months charged'],
            'rate' => ['label' => 'Rate'],
            'total' => ['label' => 'TDS plus interest'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>interest = TDS × rate × months (part months in full)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
