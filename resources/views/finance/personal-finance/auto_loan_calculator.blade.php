<x-calc.page
    title="Auto Loan Calculator - SolveKit"
    description="Free auto loan calculator: monthly payment with sales tax, fees, down payment and trade-in, and the total cost of the car."
    lede="Work out a car loan payment including tax and trade-in."
    about="Amount financed = price + sales tax + fees − down payment − trade-in value + any amount still owed on the trade-in. Most states tax the price after subtracting the trade-in. The payment is the standard amortizing payment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'auto_loan', 'fields' => ['price', 'down', 'trade', 'trade_owed', 'tax', 'fees', 'rate', 'months', 'income']]"
    :how-to="[
        ['name' => 'Enter price, down payment and trade-in', 'text' => ''],
        ['name' => 'Enter tax, fees, rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $35,000 car with $5,000 down at 7% for 60 months?', 'answer' => '$658.39.'],
        ['question' => 'And over 72 months?', 'answer' => '$574.90, with more interest: $8,142.53.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Car price" value="35000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="trade" label="Trade-in value" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="trade_owed" label="Owed on the trade-in" value="0" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Sales tax" value="7" step="any" suffix="%" />
        <x-calc.field name="fees" label="Title, registration and dealer fees" value="800" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
        <x-calc.field name="months" label="Term" value="60" min="0" step="1" suffix="months" />
        <x-calc.field name="income" label="Gross yearly income (optional)" value="75000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 35000, 'down' => 5000, 'trade' => 0, 'trade_owed' => 0, 'tax' => 7, 'fees' => 800, 'rate' => 7, 'months' => 60, 'income' => 75000],
        '72 months' => ['price' => 35000, 'down' => 5000, 'trade' => 0, 'trade_owed' => 0, 'tax' => 7, 'fees' => 800, 'rate' => 7.5, 'months' => 72, 'income' => 75000],
        'With trade-in' => ['price' => 35000, 'down' => 2000, 'trade' => 8000, 'trade_owed' => 3000, 'tax' => 7, 'fees' => 800, 'rate' => 7, 'months' => 60, 'income' => 75000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'financed' => ['label' => 'Amount financed'],
            'tax' => ['label' => 'Sales tax'],
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total cost'],
            'ratio' => ['label' => 'Share of income'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>financed = price + tax + fees − down − trade + owed</li>
            <li>PMT = F r ÷ [1 − (1 + r)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
