<x-calc.page
    title="Dividend Yield Calculator - SolveKit"
    description="Free Dividend Yield Calculator: yield = annual dividend ÷ price. Dividend yield is the annual dividend as a share of the price."
    lede="Work out the dividend yield from annual dividend per share and share price."
    about="Dividend yield is the annual dividend as a share of the price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dividend_yield', 'fields' => ['dividend', 'price']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual dividend per share, Share price.'],
        ['name' => 'Read the result', 'text' => 'The dividend yield appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the dividend yield?', 'answer' => 'Yield = annual dividend ÷ price.'],
        ['question' => 'What is the dividend yield for annual dividend per share $2.40, share price $60?', 'answer' => '4%.'],
        ['question' => 'And for annual dividend per share $0.96, share price $185?', 'answer' => '0.5189%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Unusually high yields can signal the market expects a cut.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dividend" label="Annual dividend per share" value="2.4" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Share price" value="60" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Dividend yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['dividend' => 2.4, 'price' => 60],
        'Example B' => ['dividend' => 0.96, 'price' => 185],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yield = annual dividend ÷ price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
