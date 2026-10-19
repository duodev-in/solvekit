<x-calc.page
    title="True Cost of Real Estate Commission Calculator - SolveKit"
    description="Free True Cost of Real Estate Commission Calculator: commission ÷ equity. Commission is charged on the whole price but paid out of your equity, so it takes a larger share of what you own."
    lede="Work out the commission from sale price, commission rate and mortgage balance."
    about="Commission is charged on the whole price but paid out of your equity, so it takes a larger share of what you own. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'true_cost_of_real_estate_commission', 'fields' => ['price', 'rate', 'loan']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Sale price, Commission rate, Mortgage balance.'],
        ['name' => 'Read the result', 'text' => 'The commission appears as you type, with your equity, commission as share of equity below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the commission?', 'answer' => 'Commission ÷ equity.'],
        ['question' => 'What is the commission for sale price $500,000, commission rate 5%, mortgage balance $300,000?', 'answer' => '$25,000.00. Your equity: $200,000.00.'],
        ['question' => 'And for sale price $350,000, commission rate 6%, mortgage balance $290,000?', 'answer' => '$21,000.00. Your equity: $60,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 5% fee on a home with 40% equity takes 12.5% of the equity.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Sale price" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Commission rate" value="5" step="any" suffix="%" />
        <x-calc.field name="loan" label="Mortgage balance" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Commission" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 500000, 'rate' => 5, 'loan' => 300000],
        'Example B' => ['price' => 350000, 'rate' => 6, 'loan' => 290000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Your equity'],
            'r2' => ['label' => 'Commission as share of equity'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>commission ÷ equity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
