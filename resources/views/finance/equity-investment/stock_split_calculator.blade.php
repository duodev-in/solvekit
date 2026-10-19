<x-calc.page
    title="Stock Split Calculator - SolveKit"
    description="Free Stock Split Calculator: shares × new ÷ old. A split changes the number of shares and the price, not the value of your holding."
    lede="Work out the shares after the split from your figures."
    about="A split changes the number of shares and the price, not the value of your holding. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'stock_split', 'fields' => ['shares', 'price', 'new', 'old']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Shares owned, Price before the split, New shares for each old share, Old shares.'],
        ['name' => 'Read the result', 'text' => 'The shares after the split appears as you type, with price after the split, value (unchanged) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the shares after the split?', 'answer' => 'Shares × new ÷ old; price × old ÷ new.'],
        ['question' => 'What is the shares after the split for shares owned 100, price before the split $600, new shares for each old share 3, old shares 1?', 'answer' => '300. Price after the split: $200.00.'],
        ['question' => 'And for shares owned 250, price before the split $4, new shares for each old share 1, old shares 10?', 'answer' => '25. Price after the split: $40.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 1-for-10 reverse split is new = 1, old = 10.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shares" label="Shares owned" value="100" step="any" />
        <x-calc.field name="price" label="Price before the split" value="600" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new" label="New shares for each old share" value="3" step="any" />
        <x-calc.field name="old" label="Old shares" value="1" step="any" />
    </div>

    <x-calc.result label="Shares after the split" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['shares' => 100, 'price' => 600, 'new' => 3, 'old' => 1],
        'Example B' => ['shares' => 250, 'price' => 4, 'new' => 1, 'old' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Price after the split'],
            'r2' => ['label' => 'Value (unchanged)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>shares × new ÷ old</li>
            <li>price × old ÷ new</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
