<x-calc.page
    title="ARM Mortgage Calculator - SolveKit"
    description="Free ARM calculator: payments for an adjustable-rate mortgage through the fixed period and each reset, with initial, periodic and lifetime caps."
    lede="See how an adjustable-rate mortgage payment can change."
    about="An ARM keeps its start rate for the fixed period, then resets to the index (such as SOFR) plus the margin, limited by caps written as initial/periodic/lifetime (for example 2/1/5 or 5/1/5). This assumes the index stays where you set it; if rates rise, payments could reach the lifetime cap. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'arm', 'fields' => ['amount', 'rate', 'years', 'fixed', 'index', 'margin', 'cap_first', 'cap_periodic', 'cap_life', 'adjust']]"
    :how-to="[
        ['name' => 'Enter the loan and start rate', 'text' => ''],
        ['name' => 'Enter index, margin and caps', 'text' => 'From the loan estimate.'],
    ]"
    :faqs="[
        ['question' => 'What happens to a 5/6 ARM at 5.75% if SOFR stays at 4.3% with a 2.75% margin?', 'answer' => 'It starts at $2,334.29, then $2,634.34 a month at 7.05%.'],
        ['question' => 'How high can it go?', 'answer' => 'Up to 10.75% under the lifetime cap: $3,551.69 a month if the index rises to 8%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Start rate" value="5.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="fixed" label="Fixed period" value="5" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="index" label="Index rate (e.g. SOFR)" value="4.3" step="any" suffix="%" />
        <x-calc.field name="margin" label="Margin" value="2.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap_first" label="Initial cap" value="2" step="any" suffix="%" />
        <x-calc.field name="cap_periodic" label="Periodic cap" value="1" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap_life" label="Lifetime cap" value="5" step="any" suffix="%" />
        <x-calc.field name="adjust" label="Adjusts every" value="6" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Payment for the first years" />

    <x-calc.options :decimals="false" :examples="[
        '5/6 ARM' => ['amount' => 400000, 'rate' => 5.75, 'years' => 30, 'fixed' => 5, 'index' => 4.3, 'margin' => 2.75, 'cap_first' => 2, 'cap_periodic' => 1, 'cap_life' => 5, 'adjust' => 6],
        'Worst case' => ['amount' => 400000, 'rate' => 5.75, 'years' => 30, 'fixed' => 5, 'index' => 8, 'margin' => 2.75, 'cap_first' => 2, 'cap_periodic' => 1, 'cap_life' => 5, 'adjust' => 6],
        'Rates fall' => ['amount' => 400000, 'rate' => 5.75, 'years' => 30, 'fixed' => 5, 'index' => 2.5, 'margin' => 2.75, 'cap_first' => 2, 'cap_periodic' => 1, 'cap_life' => 5, 'adjust' => 6],
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
            <li>new rate = index + margin, within caps</li>
            <li>payment re-amortized over the remaining term</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
