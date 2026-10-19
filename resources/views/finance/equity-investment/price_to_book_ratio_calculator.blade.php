<x-calc.page
    title="Price to Book Ratio Calculator - SolveKit"
    description="Free Price to Book Ratio Calculator: P/B = price ÷ book value per share. Price to book compares the market price with the accounting net worth per share."
    lede="Work out the P/B ratio from share price and book value per share."
    about="Price to book compares the market price with the accounting net worth per share. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_to_book_ratio', 'fields' => ['price', 'book']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Share price, Book value per share.'],
        ['name' => 'Read the result', 'text' => 'The P/B ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the P/B ratio?', 'answer' => 'P/B = price ÷ book value per share.'],
        ['question' => 'What is the P/B ratio for share price $50, book value per share $25?', 'answer' => '2×.'],
        ['question' => 'And for share price $18, book value per share $24?', 'answer' => '0.75×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Below 1 can signal undervaluation or trouble; banks are often valued on P/B.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Share price" value="50" step="0.01" suffix="$" />
        <x-calc.field name="book" label="Book value per share" value="25" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="P/B ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 50, 'book' => 25],
        'Example B' => ['price' => 18, 'book' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/B = price ÷ book value per share</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
