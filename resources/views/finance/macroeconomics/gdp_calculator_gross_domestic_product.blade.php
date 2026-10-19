<x-calc.page
    title="GDP Calculator (Gross Domestic Product) - SolveKit"
    description="Free GDP calculator: gross domestic product by the expenditure approach (C + I + G + X − M) or the income approach."
    lede="Calculate GDP."
    about="Expenditure approach: GDP = consumption + investment + government purchases + exports − imports. Income approach: compensation of employees + rent + interest + profits + taxes on production less subsidies + depreciation. Both measure the same output; statistical discrepancies remain in practice. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'gdp', 'fields' => ['mode', 'c', 'inv', 'g', 'x', 'm', 'wages', 'rent', 'interest', 'profits', 'taxes', 'depreciation']]"
    :how-to="[
        ['name' => 'Choose the approach', 'text' => ''],
        ['name' => 'Enter the components', 'text' => 'In billions, for example.'],
    ]"
    :faqs="[
        ['question' => 'What is GDP with C 19,500, I 5,300, G 5,000, X 3,200 and M 4,100?', 'answer' => '$28,900.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Approach" :options="['expenditure' => 'Expenditure', 'income' => 'Income']" selected="expenditure" />

    <div data-show-when="mode:expenditure">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="c" label="Consumption (C)" value="19500" step="0.01" suffix="$" />
            <x-calc.field name="inv" label="Investment (I)" value="5300" step="0.01" suffix="$" />
            <x-calc.field name="g" label="Government (G)" value="5000" step="0.01" suffix="$" />
            <x-calc.field name="x" label="Exports (X)" value="3200" step="0.01" suffix="$" />
            <x-calc.field name="m" label="Imports (M)" value="4100" step="0.01" suffix="$" />
        </div>
    </div>

    <div data-show-when="mode:income" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="wages" label="Compensation of employees" value="15000" step="0.01" suffix="$" />
            <x-calc.field name="rent" label="Rent" value="1000" step="0.01" suffix="$" />
            <x-calc.field name="interest" label="Net interest" value="800" step="0.01" suffix="$" />
            <x-calc.field name="profits" label="Profits" value="5500" step="0.01" suffix="$" />
            <x-calc.field name="taxes" label="Indirect taxes" value="2000" step="0.01" suffix="$" />
            <x-calc.field name="depreciation" label="Depreciation" value="4500" step="0.01" suffix="$" />
        </div>
    </div>

    <x-calc.result label="GDP" />

    <x-calc.options :decimals="false" :examples="[
        'Expenditure' => ['mode' => 'expenditure', 'c' => 19500, 'inv' => 5300, 'g' => 5000, 'x' => 3200, 'm' => 4100, 'wages' => '', 'rent' => '', 'interest' => '', 'profits' => '', 'taxes' => '', 'depreciation' => ''],
        'Income' => ['mode' => 'income', 'c' => '', 'inv' => '', 'g' => '', 'x' => '', 'm' => '', 'wages' => 15000, 'rent' => 1000, 'interest' => 800, 'profits' => 5500, 'taxes' => 2000, 'depreciation' => 4500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'share' => ['label' => 'Breakdown'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GDP = C + I + G + (X − M)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
