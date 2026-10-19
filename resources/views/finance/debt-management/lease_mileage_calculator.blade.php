<x-calc.page
    title="Lease Mileage Calculator - SolveKit"
    description="Free Lease Mileage Calculator: projected = miles so far ÷ months × term. Projects lease mileage to the end and the excess-mile charge."
    lede="Work out the projected excess miles from your figures."
    about="Projects lease mileage to the end and the excess-mile charge. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lease_mileage', 'fields' => ['allowed', 'months', 'odometer', 'term', 'fee']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Miles allowed a year, Months into the lease, Miles driven so far, Lease term, Excess mileage fee per mile.'],
        ['name' => 'Read the result', 'text' => 'The projected excess miles appears as you type, with projected at lease end, allowed in total, projected fee below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the projected excess miles?', 'answer' => 'Projected = miles so far ÷ months × term; excess over allowance × fee.'],
        ['question' => 'What is the projected excess miles for miles allowed a year 12,000, months into the lease 18, miles driven so far 20,000, lease term 36 months, excess mileage fee per mile $0.25?', 'answer' => '4,000. Projected at lease end: 40,000.'],
        ['question' => 'And for miles allowed a year 10,000, months into the lease 24, miles driven so far 18,000, lease term 36 months, excess mileage fee per mile $0.20?', 'answer' => '0. Projected at lease end: 27,000.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Fees are often 15–30 cents a mile.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="allowed" label="Miles allowed a year" value="12000" step="any" />
        <x-calc.field name="months" label="Months into the lease" value="18" min="0" step="any" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="odometer" label="Miles driven so far" value="20000" step="any" />
        <x-calc.field name="term" label="Lease term" value="36" min="0" step="any" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fee" label="Excess mileage fee per mile" value="0.25" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Projected excess miles" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['allowed' => 12000, 'months' => 18, 'odometer' => 20000, 'term' => 36, 'fee' => 0.25],
        'Example B' => ['allowed' => 10000, 'months' => 24, 'odometer' => 18000, 'term' => 36, 'fee' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Projected at lease end'],
            'r2' => ['label' => 'Allowed in total'],
            'r3' => ['label' => 'Projected fee'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>projected = miles so far ÷ months × term</li>
            <li>excess over allowance × fee</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
