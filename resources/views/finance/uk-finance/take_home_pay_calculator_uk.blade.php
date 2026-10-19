<x-calc.page
    title="Take Home Pay Calculator UK - SolveKit"
    description="Free UK take-home pay calculator for 2026/27: income tax (England, Wales, NI or Scotland), National Insurance, pension and student loan repayments, monthly and yearly."
    lede="Work out your UK take-home pay for 2026/27."
    about="Income tax uses the £12,570 personal allowance (lost by £1 for each £2 over £100,000) and 20%/40%/45% bands, or Scotland's six bands from 19% to 48%. Employee NI is 8% between £12,570 and £50,270 and 2% above. Student loans take 9% over the plan threshold (Plan 1 £26,900, Plan 2 £29,385, Plan 4 £33,795, Plan 5 £25,000) and postgraduate loans 6% over £21,000. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'uk_take_home', 'fields' => ['salary', 'region', 'pension', 'pension_type', 'student', 'postgrad'], 'data' => ['uk' => config('finance_data.uk')], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your salary', 'text' => ''],
        ['name' => 'Choose region, pension and loan', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is take-home pay on £40,000 with Plan 2 and 5% pension?', 'answer' => '£2,480.35.'],
        ['question' => 'And in Scotland?', 'answer' => '£2,476.60.'],
        ['question' => 'What about £110,000?', 'answer' => '£5,855.62: the personal allowance falls to £10,320.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Yearly salary" value="40000" step="0.01" suffix="£" />
        <x-calc.select name="region" label="Where you live" :options="['ruk' => 'England, Wales or Northern Ireland', 'scotland' => 'Scotland']" selected="ruk" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pension" label="Pension contribution" value="5" step="any" suffix="%" />
        <x-calc.select name="pension_type" label="Pension type" :options="['sacrifice' => 'Salary sacrifice', 'net' => 'Net pay or relief at source']" selected="net" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="student" label="Student loan" :options="['none' => 'None', 'plan1' => 'Plan 1', 'plan2' => 'Plan 2', 'plan4' => 'Plan 4 (Scotland)', 'plan5' => 'Plan 5']" selected="plan2" />
    </div>

    <x-calc.checkbox name="postgrad" label="Postgraduate loan" :checked="false" />

    <x-calc.result label="Take-home pay a month" />

    <x-calc.options :decimals="false" :examples="[
        '£40k Plan 2' => ['salary' => 40000, 'region' => 'ruk', 'pension' => 5, 'pension_type' => 'net', 'student' => 'plan2', 'postgrad' => false],
        '£40k Scotland' => ['salary' => 40000, 'region' => 'scotland', 'pension' => 5, 'pension_type' => 'net', 'student' => 'plan2', 'postgrad' => false],
        '£110k' => ['salary' => 110000, 'region' => 'ruk', 'pension' => 5, 'pension_type' => 'sacrifice', 'student' => 'none', 'postgrad' => false],
        '£25k no loan' => ['salary' => 25000, 'region' => 'ruk', 'pension' => 3, 'pension_type' => 'net', 'student' => 'none', 'postgrad' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tax' => ['label' => 'Income tax'],
            'ni' => ['label' => 'National Insurance'],
            'pension' => ['label' => 'Pension'],
            'loan' => ['label' => 'Student loan'],
            'allowance' => ['label' => 'Personal allowance'],
            'marginal' => ['label' => 'Marginal rate'],
            'weekly' => ['label' => 'Weekly'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = bands(salary − pension − allowance)</li>
            <li>NI = 8% (12,570–50,270) + 2% above</li>
            <li>loan = 9% × (pay − threshold)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
