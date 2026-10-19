<x-calc.page
    title="Self-Employment Tax Calculator - SolveKit"
    description="Free self-employment tax calculator for 2026: 15.3% on 92.35% of net profit, Social Security up to the $184,500 wage base, and the deductible half."
    lede="Work out self-employment tax on your profit."
    about="SE tax (Schedule SE) is 12.4% Social Security on net earnings up to $184,500 (less any W-2 wages) plus 2.9% Medicare, on 92.35% of net profit. No SE tax is due if net earnings are under $400. Half of it is deducted from income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'self_employment', 'fields' => ['profit', 'wages', 'status'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter net profit', 'text' => 'From Schedule C.'],
        ['name' => 'Add W-2 wages', 'text' => 'If you also have a job.'],
    ]"
    :faqs="[
        ['question' => 'What is the SE tax on $80,000 of profit?', 'answer' => '$11,303.64.'],
        ['question' => 'And on $250,000?', 'answer' => '$29,573.38.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="profit" label="Net self-employment profit" value="80000" step="0.01" suffix="$" />
        <x-calc.field name="wages" label="W-2 wages (optional)" value="0" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <x-calc.result label="Self-employment tax" />

    <x-calc.options :decimals="false" :examples="[
        '$80k profit' => ['profit' => 80000, 'wages' => 0, 'status' => 'single'],
        '$250k profit' => ['profit' => 250000, 'wages' => 0, 'status' => 'single'],
        'Side gig' => ['profit' => 12000, 'wages' => 90000, 'status' => 'single'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'earnings' => ['label' => 'Net earnings'],
            'ss' => ['label' => 'Social Security part'],
            'medicare' => ['label' => 'Medicare part'],
            'deduction' => ['label' => 'Deductible half'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>earnings = profit × 92.35%</li>
            <li>SE = 12.4% × min(earnings, base − wages) + 2.9% × earnings</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
