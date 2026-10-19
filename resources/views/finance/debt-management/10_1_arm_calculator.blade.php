<x-calc.page
    title="10/1 ARM Calculator - SolveKit"
    description="Free 10/1 ARM calculator: payment for the 10-year fixed period, then yearly resets with caps."
    lede="See the payment of a 10/1 adjustable-rate mortgage."
    about="A 10/1 ARM is fixed for 10 years, then adjusts once a year. An ARM keeps its start rate for the fixed period, then resets to the index (such as SOFR) plus the margin, limited by caps written as initial/periodic/lifetime (for example 2/1/5 or 5/1/5). This assumes the index stays where you set it; if rates rise, payments could reach the lifetime cap. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'arm', 'fields' => ['amount', 'rate', 'years', 'fixed', 'index', 'margin', 'cap_first', 'cap_periodic', 'cap_life', 'adjust']]"
    :how-to="[
        ['name' => 'Enter the loan and start rate', 'text' => ''],
        ['name' => 'Enter index, margin and caps', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $500,000 at 6% for the first 10 years?', 'answer' => '$2,997.75.'],
        ['question' => 'What after year 10 if the index stays at 4.3%?', 'answer' => '$3,256.64 a month at 7.05%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Start rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="fixed" label="Fixed period" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="index" label="Index rate" value="4.3" step="any" suffix="%" />
        <x-calc.field name="margin" label="Margin" value="2.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap_first" label="Initial cap" value="5" step="any" suffix="%" />
        <x-calc.field name="cap_periodic" label="Periodic cap" value="2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap_life" label="Lifetime cap" value="5" step="any" suffix="%" />
        <x-calc.field name="adjust" label="Adjusts every" value="12" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Payment for the first 10 years" />

    <x-calc.options :decimals="false" :examples="[
        '10/1' => ['amount' => 500000, 'rate' => 6, 'years' => 30, 'fixed' => 10, 'index' => 4.3, 'margin' => 2.75, 'cap_first' => 5, 'cap_periodic' => 2, 'cap_life' => 5, 'adjust' => 12],
        'Rates rise' => ['amount' => 500000, 'rate' => 6, 'years' => 30, 'fixed' => 10, 'index' => 7, 'margin' => 2.75, 'cap_first' => 5, 'cap_periodic' => 2, 'cap_life' => 5, 'adjust' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Monthly payment" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'reset' => ['label' => 'Payment after the first reset'],
            'highest' => ['label' => 'Highest payment'],
            'ceiling' => ['label' => 'Rate ceiling'],
            'interest' => ['label' => 'Total interest'],
            'compare' => ['label' => 'If the rate never changed'],
        ]" />
        <x-calc.grid heading="Rate and payment by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate after 10 years = index + margin within caps</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
