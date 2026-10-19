<x-calc.page
    title="Down Payment Calculator - SolveKit"
    description="Free Down Payment Calculator: down payment = price × %. The down payment is the part of the price you pay in cash; the rest is the loan."
    lede="Work out the down payment from home price and down payment."
    about="The down payment is the part of the price you pay in cash; the rest is the loan. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'down_payment', 'fields' => ['price', 'percent']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Home price, Down payment.'],
        ['name' => 'Read the result', 'text' => 'The down payment appears as you type, with loan amount, loan-to-value below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the down payment?', 'answer' => 'Down payment = price × %.'],
        ['question' => 'What is the down payment for home price $400,000, down payment 20%?', 'answer' => '$80,000.00. Loan amount: $320,000.00.'],
        ['question' => 'And for home price $285,000, down payment 3.5%?', 'answer' => '$9,975.00. Loan amount: $275,025.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Under 20% down, conventional loans usually need PMI.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Home price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="percent" label="Down payment" value="20" step="any" suffix="%" />
    </div>

    <x-calc.result label="Down payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 400000, 'percent' => 20],
        'Example B' => ['price' => 285000, 'percent' => 3.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Loan amount'],
            'r2' => ['label' => 'Loan-to-value'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>down payment = price × %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
