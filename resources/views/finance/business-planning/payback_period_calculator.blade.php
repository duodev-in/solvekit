<x-calc.page
    title="Payback Period Calculator - SolveKit"
    description="Free payback period calculator: simple and discounted payback from an investment and yearly cash flows, with cumulative cash flow."
    lede="Find how long an investment takes to pay for itself."
    about="Payback is the time until cumulative cash flows equal the investment, interpolating within the final year. Discounted payback uses cash flows discounted at your rate, so it is longer. Payback ignores cash after the payback point. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'payback', 'fields' => ['investment', 'rate', 'flows']]"
    :how-to="[
        ['name' => 'Enter the investment', 'text' => 'And a discount rate.'],
        ['name' => 'List the yearly cash flows', 'text' => 'Year 1 first.'],
    ]"
    :faqs="[
        ['question' => 'What is the payback of $50,000 returning 12,000, 15,000, 18,000, 20,000?', 'answer' => '3.25 years; discounted 3.799 years at 8%.'],
        ['question' => 'And even cash flows of $10,000?', 'answer' => '4.5 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="investment" label="Initial investment" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Discount rate" value="8" step="any" suffix="%" />
    </div>

    <x-calc.textarea name="flows" label="Yearly cash flows (one per line)" value="12000
15000
18000
20000
20000" rows="6" />

    <x-calc.result label="Payback period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['investment' => 50000, 'rate' => 8, 'flows' => '12000
15000
18000
20000
20000'],
        'Even' => ['investment' => 45000, 'rate' => 6, 'flows' => '10000
10000
10000
10000
10000
10000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'discounted' => ['label' => 'Discounted payback'],
            'total' => ['label' => 'Total cash flows'],
            'npv' => ['label' => 'NPV'],
            'years' => ['label' => 'Years of cash flows'],
        ]" />
        <x-calc.grid heading="Cumulative cash flow" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>payback = years before recovery + remaining ÷ next cash flow</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
