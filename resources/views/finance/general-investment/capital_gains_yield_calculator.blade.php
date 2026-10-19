<x-calc.page
    title="Capital Gains Yield Calculator - SolveKit"
    description="Free Capital Gains Yield Calculator: CGY = (P₁ − P₀) ÷ P₀. Capital gains yield is the price change as a share of the purchase price, excluding dividends."
    lede="Work out the capital gains yield from purchase price and current or sale price."
    about="Capital gains yield is the price change as a share of the purchase price, excluding dividends. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'capital_gains_yield', 'fields' => ['buy', 'sell']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Purchase price, Current or sale price.'],
        ['name' => 'Read the result', 'text' => 'The capital gains yield appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the capital gains yield?', 'answer' => 'CGY = (P₁ − P₀) ÷ P₀.'],
        ['question' => 'What is the capital gains yield for purchase price $40, current or sale price $46?', 'answer' => '15%.'],
        ['question' => 'And for purchase price $120, current or sale price $102?', 'answer' => '−15%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Total return = capital gains yield + dividend yield.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="buy" label="Purchase price" value="40" step="0.01" suffix="$" />
        <x-calc.field name="sell" label="Current or sale price" value="46" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Capital gains yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['buy' => 40, 'sell' => 46],
        'Example B' => ['buy' => 120, 'sell' => 102],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CGY = (P₁ − P₀) ÷ P₀</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
