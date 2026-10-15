@php
    $currencies = [
        'USD' => ['symbol' => '$', 'major' => 'dollar', 'majorPlural' => 'dollars', 'minor' => 'cent', 'minorPlural' => 'cents'],
        'CAD' => ['symbol' => '$', 'major' => 'dollar', 'majorPlural' => 'dollars', 'minor' => 'cent', 'minorPlural' => 'cents'],
        'AUD' => ['symbol' => '$', 'major' => 'dollar', 'majorPlural' => 'dollars', 'minor' => 'cent', 'minorPlural' => 'cents'],
        'EUR' => ['symbol' => '€', 'major' => 'euro', 'majorPlural' => 'euros', 'minor' => 'cent', 'minorPlural' => 'cents'],
        'GBP' => ['symbol' => '£', 'major' => 'pound', 'majorPlural' => 'pounds', 'minor' => 'penny', 'minorPlural' => 'pence'],
        'INR' => ['symbol' => '₹', 'major' => 'rupee', 'majorPlural' => 'rupees', 'minor' => 'paisa', 'minorPlural' => 'paise'],
    ];
@endphp

<x-calc.page
    title="Cents to Dollars Calculator - SolveKit"
    description="Professional cents to dollars calculator for currency conversion. Convert cent amounts to dollars with precise decimal calculations for financial applications."
    lede="Convert cents to dollars, or dollars to cents, and write the amount in words."
    about="There are 100 cents in a dollar, so cents are divided by 100 for dollars and dollars are multiplied by 100 for cents. The same rule holds for euros and cents, pounds and pence, and rupees and paise; the currency only changes the symbol and the words."
    :calc="['engine' => 'cents-dollars', 'currencies' => $currencies, 'quickRef' => [1, 5, 10, 25, 50, 99, 250, 1000]]"
    :how-to="[
        ['name' => 'Choose a direction and currency', 'text' => 'Cents to dollars, or dollars to cents.'],
        ['name' => 'Enter the amount', 'text' => 'The decimal amount and the amount in words update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert cents to dollars?', 'answer' => 'Divide by 100. 250 cents is $2.50.'],
        ['question' => 'How do I write $1,234.56 in words?', 'answer' => 'One thousand two hundred thirty-four dollars and fifty-six cents.'],
        ['question' => 'Do all currencies have 100 minor units?', 'answer' => 'Most do, including all those listed here. A few, such as the Japanese yen, have none in everyday use.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['cents' => 'Cents → Dollars', 'dollars' => 'Dollars → Cents']" selected="cents" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
        <x-calc.field name="value" label="Amount" value="12345" min="0" suffix="cents" suffix-ref="value-suffix" placeholder="Enter an amount" />
        <x-calc.select name="currency" label="Currency" :options="collect($currencies)->map(fn ($currency, $code) => $code.' ('.$currency['symbol'].')')->all()" selected="USD" />
    </div>

    <x-calc.result label="Dollars" />

    <x-calc.options :examples="[
        'Coin jar 873 cents' => ['value' => 873, 'direction' => 'cents'],
        'Price $19.99' => ['value' => 19.99, 'direction' => 'dollars'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same amount as" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'minor' => ['label' => 'In cents'],
            'mixed' => ['label' => 'Dollars and cents'],
            'words' => ['label' => 'In words'],
        ]" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dollars = cents ÷ 100</li>
            <li>cents = dollars × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
