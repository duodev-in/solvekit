<x-calc.page
    title="Internal Rate of Return (IRR) Calculator - SolveKit"
    description="Free IRR calculator: internal rate of return of a series of cash flows, every IRR when cash flows change sign more than once, and an NPV profile chart."
    lede="Find the internal rate of return of cash flows."
    about="The IRR is the discount rate at which NPV = 0. It is found numerically: this calculator scans −99% to 1,000% for every sign change of NPV, so it also reports multiple IRRs, which occur when cash flows change sign more than once. In that case use NPV or MIRR. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'irr', 'fields' => ['flows']]"
    :how-to="[
        ['name' => 'List the cash flows', 'text' => 'Investment first (negative), then returns.'],
        ['name' => 'Read the IRR', 'text' => 'And the NPV profile.'],
    ]"
    :faqs="[
        ['question' => 'What is the IRR of −100, 30, 40, 50, 20?', 'answer' => '15.32%.'],
        ['question' => 'Can a project have two IRRs?', 'answer' => 'Yes: −100, 230, −132 has 10%, 20%.'],
    ]"
>
    <x-calc.textarea name="flows" label="Cash flows, year 0 first (one per line)" value="-100
30
40
50
20" rows="6" />

    <x-calc.result label="Internal rate of return" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['flows' => '-100
30
40
50
20'],
        'Two IRRs' => ['flows' => '-100
230
-132'],
        'Real estate' => ['flows' => '-250000
15000
15000
15000
15000
315000'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="NPV profile" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'all' => ['label' => 'All IRRs'],
            'total' => ['label' => 'Net cash flow'],
            'multiple' => ['label' => 'Money multiple'],
            'npv0' => ['label' => 'NPV at 0%'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>0 = Σ CFₜ ÷ (1 + IRR)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
