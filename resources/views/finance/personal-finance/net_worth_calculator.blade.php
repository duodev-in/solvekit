<x-calc.page
    title="Net Worth Calculator - SolveKit"
    description="Free Net Worth Calculator: net worth = assets − liabilities. Net worth is everything you own minus everything you owe."
    lede="Work out the net worth from your figures."
    about="Net worth is everything you own minus everything you owe. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_worth', 'fields' => ['cash', 'investments', 'property', 'mortgage', 'other']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cash and savings, Investments and retirement, Home and other property, Mortgage, Other debts.'],
        ['name' => 'Read the result', 'text' => 'The net worth appears as you type, with total assets, total liabilities below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net worth?', 'answer' => 'Net worth = assets − liabilities.'],
        ['question' => 'What is the net worth for cash and savings $15,000, investments and retirement $85,000, home and other property $350,000, mortgage $240,000, other debts $18,000?', 'answer' => '$192,000.00. Total assets: $450,000.00.'],
        ['question' => 'And for cash and savings $4,000, investments and retirement $12,000, home and other property $0, mortgage $0, other debts $26,000?', 'answer' => '−$10,000.00. Total assets: $16,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Track it yearly; the trend matters more than the number.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Cash and savings" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="investments" label="Investments and retirement" value="85000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="property" label="Home and other property" value="350000" step="0.01" suffix="$" />
        <x-calc.field name="mortgage" label="Mortgage" value="240000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other" label="Other debts" value="18000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net worth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cash' => 15000, 'investments' => 85000, 'property' => 350000, 'mortgage' => 240000, 'other' => 18000],
        'Example B' => ['cash' => 4000, 'investments' => 12000, 'property' => 0, 'mortgage' => 0, 'other' => 26000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total assets'],
            'r2' => ['label' => 'Total liabilities'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net worth = assets − liabilities</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
