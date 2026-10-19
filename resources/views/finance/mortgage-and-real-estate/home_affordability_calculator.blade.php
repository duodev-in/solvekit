<x-calc.page
    title="Home Affordability Calculator - SolveKit"
    description="Free home affordability calculator: the most house you can afford from income, debts, down payment and rate, using the 28/36 debt-to-income rule."
    lede="Find how much house you can afford."
    about="Lenders commonly cap housing costs (principal, interest, taxes, insurance, HOA, PMI) at 28% of gross monthly income and all debt payments at 36%. The highest price meeting both is found numerically. FHA and some programs allow higher ratios, but a lower payment leaves room to save. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'affordability', 'fields' => ['income', 'debts', 'downpay', 'rate', 'years', 'tax', 'insurance', 'hoa', 'pmi', 'front', 'back']]"
    :how-to="[
        ['name' => 'Enter income and debts', 'text' => ''],
        ['name' => 'Enter down payment, rate and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much house can someone earning $120,000 with $1,000 of debts and $60,000 down afford at 6.5%?', 'answer' => '$376,174.'],
        ['question' => 'And with no other debts?', 'answer' => '$402,304.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Gross yearly income" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="debts" label="Other monthly debt payments" value="1000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="downpay" label="Down payment" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="tax" label="Property tax (% a year)" value="1.1" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insurance" label="Home insurance a year" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="hoa" label="HOA a month" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pmi" label="PMI rate" value="0.5" step="any" suffix="%" />
        <x-calc.field name="front" label="Housing ratio" value="28" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="back" label="Total debt ratio" value="36" step="any" suffix="%" />
    </div>

    <x-calc.result label="Home price you can afford" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['income' => 120000, 'debts' => 1000, 'downpay' => 60000, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1500, 'hoa' => 0, 'pmi' => 0.5, 'front' => 28, 'back' => 36],
        'No debts' => ['income' => 120000, 'debts' => 0, 'downpay' => 60000, 'rate' => 6.5, 'years' => 30, 'tax' => 1.1, 'insurance' => 1500, 'hoa' => 0, 'pmi' => 0.5, 'front' => 28, 'back' => 36],
        'FHA ratios' => ['income' => 70000, 'debts' => 400, 'downpay' => 12000, 'rate' => 6.25, 'years' => 30, 'tax' => 1.1, 'insurance' => 1200, 'hoa' => 0, 'pmi' => 0.55, 'front' => 31, 'back' => 43],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'budget' => ['label' => 'Housing budget'],
            'loan' => ['label' => 'Loan'],
            'pi' => ['label' => 'Principal and interest'],
            'rule' => ['label' => 'Limiting rule'],
            'ltv' => ['label' => 'Loan-to-value'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>housing ≤ 28% × income ÷ 12</li>
            <li>housing + debts ≤ 36% × income ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
