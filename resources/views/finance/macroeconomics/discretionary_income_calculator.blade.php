<x-calc.page
    title="Discretionary Income Calculator - SolveKit"
    description="Free discretionary income calculator: income above 150% (or 100%, 225%) of the 2026 HHS poverty guideline for student loan repayment, and the budgeting version after taxes and essentials."
    lede="Work out your discretionary income."
    about="For federal student loans, discretionary income = AGI − a multiple of the HHS poverty guideline for your family size (150% for IBR and PAYE, 100% for ICR). The 2026 guideline is $15,960 for one person plus $5,680 per extra person in the 48 states (higher in Alaska and Hawaii). In budgeting, discretionary income is what remains after taxes and essentials. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'discretionary', 'fields' => ['income', 'family', 'region', 'plan', 'taxes', 'essentials'], 'data' => ['poverty' => config('finance_data.poverty')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter AGI and family size', 'text' => ''],
        ['name' => 'Choose the definition', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the discretionary income of a single borrower with $60,000 AGI?', 'answer' => '$36,060.00.'],
        ['question' => 'And a family of four?', 'answer' => '$10,500.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="AGI" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="family" label="Family size" value="1" min="1" step="1" />
        <x-calc.select name="region" label="Where you live" :options="['contiguous' => '48 states and DC', 'alaska' => 'Alaska', 'hawaii' => 'Hawaii']" selected="contiguous" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="plan" label="Definition" :options="['150' => '150% (IBR, PAYE)', '100' => '100% (ICR)', '225' => '225%']" selected="150" />
        <x-calc.field name="taxes" label="Taxes (budgeting)" value="9000" step="0.01" suffix="$" />
        <x-calc.field name="essentials" label="Essentials (budgeting)" value="30000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Discretionary income" />

    <x-calc.options :decimals="false" :examples="[
        'Single' => ['income' => 60000, 'family' => 1, 'region' => 'contiguous', 'plan' => '150', 'taxes' => 9000, 'essentials' => 30000],
        'Family of four' => ['income' => 60000, 'family' => 4, 'region' => 'contiguous', 'plan' => '150', 'taxes' => 6000, 'essentials' => 42000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'guideline' => ['label' => 'Poverty guideline'],
            'monthly' => ['label' => 'A month'],
            'ibr' => ['label' => 'IBR payment'],
            'budget' => ['label' => 'Budgeting definition'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DI = AGI − 150% × guideline(family)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
