<x-calc.page
    title="70/20/10 Rule Money Calculator - SolveKit"
    description="Free 70/20/10 Rule Money Calculator: spending 70%, saving 20%, giving or extra debt payments 10%. The 70/20/10 rule is another simple budget split."
    lede="Work out the spending (70%) from the monthly after-tax income."
    about="The 70/20/10 rule is another simple budget split. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => '70_20_10_rule', 'fields' => ['income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly after-tax income.'],
        ['name' => 'Read the result', 'text' => 'The spending (70%) appears as you type, with saving (20%), giving or debt (10%) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the spending (70%)?', 'answer' => 'Spending 70%, saving 20%, giving or extra debt payments 10%.'],
        ['question' => 'What is the spending (70%) for monthly after-tax income $5,000?', 'answer' => '$3,500.00. Saving (20%): $1,000.00.'],
        ['question' => 'And for monthly after-tax income $2,800?', 'answer' => '$1,960.00. Saving (20%): $560.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A convention; adjust to your situation.'],
    ]"
>
    <x-calc.field name="income" label="Monthly after-tax income" value="5000" step="0.01" suffix="$" />

    <x-calc.result label="Spending (70%)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 5000],
        'Example B' => ['income' => 2800],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Saving (20%)'],
            'r2' => ['label' => 'Giving or debt (10%)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>spending 70%, saving 20%, giving or extra debt payments 10%</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
