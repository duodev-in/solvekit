<x-calc.page
    title="50/30/20 Rule Calculator - SolveKit"
    description="Free 50/30/20 Rule Calculator: needs 50%, wants 30%, savings and debt repayment 20%. The 50/30/20 budget (Elizabeth Warren, All Your Worth) splits after-tax income into needs, wants and savings."
    lede="Work out the needs (50%) from the monthly after-tax income."
    about="The 50/30/20 budget (Elizabeth Warren, All Your Worth) splits after-tax income into needs, wants and savings. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => '50_30_20_rule', 'fields' => ['income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly after-tax income.'],
        ['name' => 'Read the result', 'text' => 'The needs (50%) appears as you type, with wants (30%), savings and debt (20%) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the needs (50%)?', 'answer' => 'Needs 50%, wants 30%, savings and debt repayment 20%.'],
        ['question' => 'What is the needs (50%) for monthly after-tax income $5,000?', 'answer' => '$2,500.00. Wants (30%): $1,500.00.'],
        ['question' => 'And for monthly after-tax income $3,200?', 'answer' => '$1,600.00. Wants (30%): $960.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A rule of thumb; high-cost areas may need more for needs.'],
    ]"
>
    <x-calc.field name="income" label="Monthly after-tax income" value="5000" step="0.01" suffix="$" />

    <x-calc.result label="Needs (50%)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 5000],
        'Example B' => ['income' => 3200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Wants (30%)'],
            'r2' => ['label' => 'Savings and debt (20%)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>needs 50%, wants 30%, savings and debt repayment 20%</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
