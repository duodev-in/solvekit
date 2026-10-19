<x-calc.page
    title="Currency Converter - SolveKit"
    description="Free Currency Converter: converted = amount × exchange rate. Converts with the rate you enter, so the result is as current as your rate."
    lede="Work out the converted amount from amount and exchange rate (1 unit of yours = … of the other)."
    about="Converts with the rate you enter, so the result is as current as your rate. Banks and card providers add a margin to the mid-market rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'currency', 'fields' => ['amount', 'rate']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Amount, Exchange rate (1 unit of yours = … of the other).'],
        ['name' => 'Read the result', 'text' => 'The converted amount appears as you type, with inverse rate, back again below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the converted amount?', 'answer' => 'Converted = amount × exchange rate.'],
        ['question' => 'What is the converted amount for amount 100, exchange rate 0.92?', 'answer' => '92. Inverse rate: 1.087.'],
        ['question' => 'And for amount 2,500, exchange rate 83.4?', 'answer' => '208,500. Inverse rate: 0.01199.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Check a live mid-market rate, then compare your bank\'s rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="any" />
        <x-calc.field name="rate" label="Exchange rate (1 unit of yours = … of the other)" value="0.92" step="any" />
    </div>

    <x-calc.result label="Converted amount" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['amount' => 100, 'rate' => 0.92],
        'Example B' => ['amount' => 2500, 'rate' => 83.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Inverse rate'],
            'r2' => ['label' => 'Back again'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>converted = amount × exchange rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
