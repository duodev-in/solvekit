<x-calc.page
    title="Effective Corporate Tax Rate Calculator - SolveKit"
    description="Free Effective Corporate Tax Rate Calculator: ETR = tax expense ÷ pre-tax income. The effective rate is the tax actually charged as a share of profit, which credits, deductions and foreign rates make differ from the 21% US federal statutory rate."
    lede="Work out the effective tax rate from income tax expense and pre-tax income."
    about="The effective rate is the tax actually charged as a share of profit, which credits, deductions and foreign rates make differ from the 21% US federal statutory rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'effective_corporate_tax_rate', 'fields' => ['tax', 'pretax']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Income tax expense, Pre-tax income.'],
        ['name' => 'Read the result', 'text' => 'The effective tax rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the effective tax rate?', 'answer' => 'ETR = tax expense ÷ pre-tax income.'],
        ['question' => 'What is the effective tax rate for income tax expense $210,000, pre-tax income $1,000,000?', 'answer' => '21%.'],
        ['question' => 'And for income tax expense $45,000, pre-tax income $300,000?', 'answer' => '15%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with the statutory rate to see the effect of credits and deductions.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Income tax expense" value="210000" step="0.01" suffix="$" />
        <x-calc.field name="pretax" label="Pre-tax income" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Effective tax rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['tax' => 210000, 'pretax' => 1000000],
        'Example B' => ['tax' => 45000, 'pretax' => 300000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ETR = tax expense ÷ pre-tax income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
