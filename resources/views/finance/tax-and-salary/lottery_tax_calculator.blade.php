<x-calc.page
    title="Lottery Tax Calculator - SolveKit"
    description="Free lottery tax calculator: federal tax on lottery winnings at 2026 rates, the 24% withheld, what you still owe and your state tax."
    lede="See how much of a lottery prize you keep."
    about="Lottery prizes are ordinary income. The lottery withholds 24% federal tax on prizes over $5,000, but large prizes fall mostly in the 37% bracket, so more is owed at filing. State tax varies from 0% (e.g. California, Florida, Texas) to over 10% (New York City residents pay city tax too). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'lottery', 'fields' => ['prize', 'income', 'status', 'state_rate'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the prize', 'text' => 'Cash value if you take the lump sum.'],
        ['name' => 'Enter your state rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is left of a $1,000,000 prize?', 'answer' => '$612,819.75.'],
        ['question' => 'How much more federal tax is due after withholding?', 'answer' => '$97,180.25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prize" label="Prize (lump sum)" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Other taxable income" value="60000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
        <x-calc.field name="state_rate" label="State tax rate on the prize" value="5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Prize after tax" />

    <x-calc.options :decimals="false" :examples="[
        '$1 million' => ['prize' => 1000000, 'income' => 60000, 'status' => 'single', 'state_rate' => 5],
        '$50,000' => ['prize' => 50000, 'income' => 60000, 'status' => 'single', 'state_rate' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'withheld' => ['label' => 'Withheld'],
            'owed' => ['label' => 'Still owed at filing'],
            'federal' => ['label' => 'Federal tax'],
            'state' => ['label' => 'State tax'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tax = tax(income + prize) − tax(income)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
