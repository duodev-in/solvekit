<x-calc.page
    title="Budget Calculator - SolveKit"
    description="Free budget calculator: monthly spending by category against take-home income, what is left to save and each category's share."
    lede="Build a monthly budget."
    about="Left over = take-home income − total spending. Common guides keep housing under about 30% of income and aim to save at least 10–20%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'budget', 'fields' => ['income', 'lines']]"
    :how-to="[
        ['name' => 'Enter income', 'text' => ''],
        ['name' => 'List spending', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is left from $5,200 after the example spending?', 'answer' => '$1,070.00.'],
    ]"
>
    <x-calc.field name="income" label="Monthly take-home income" value="5200" step="0.01" suffix="$" />

    <x-calc.rows-editor name="lines" label="Spending" :columns="['name' => 'Category', 'amount' => 'Monthly amount']" :rows="[['Rent', 1650], ['Groceries', 600], ['Transportation', 450], ['Utilities', 220], ['Insurance', 260], ['Debt payments', 300], ['Dining and fun', 400], ['Other', 250]]" :text="['name']" />

    <x-calc.result label="Left over each month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['income' => 5200, 'lines' => 'Rent	1650
Groceries	600
Transportation	450
Utilities	220
Insurance	260
Debt payments	300
Dining and fun	400
Other	250'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'spent' => ['label' => 'Spent'],
            'yearly' => ['label' => 'Left over a year'],
            'saving' => ['label' => 'Saving rate'],
            'largest' => ['label' => 'Largest category'],
        ]" />
        <x-calc.quick-ref heading="Categories" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>left = income − Σ spending</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
