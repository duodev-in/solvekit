<x-calc.page
    title="Impermanent Loss Calculator - SolveKit"
    description="Free Impermanent Loss Calculator: IL = 2√k ÷ (1 + k) − 1, where k = new price ÷ old price. In a 50/50 constant-product pool (Uniswap v2 style), a price move leaves you worse off than holding the two tokens."
    lede="Work out the impermanent loss from the price change of one token against the other."
    about="In a 50/50 constant-product pool (Uniswap v2 style), a price move leaves you worse off than holding the two tokens. The loss is “impermanent” only if prices return. Fees earned are not included. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'impermanent_loss', 'fields' => ['change']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price change of one token against the other.'],
        ['name' => 'Read the result', 'text' => 'The impermanent loss appears as you type, with price ratio k below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the impermanent loss?', 'answer' => 'IL = 2√k ÷ (1 + k) − 1, where k = new price ÷ old price.'],
        ['question' => 'What is the impermanent loss for price change of one token against the other 100%?', 'answer' => '−5.719%. Price ratio k: 2×.'],
        ['question' => 'And for price change of one token against the other -50%?', 'answer' => '−5.719%. Price ratio k: 0.5×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A doubling of price costs about 5.7% against holding.'],
    ]"
>
    <x-calc.field name="change" label="Price change of one token against the other" value="100" step="any" suffix="%" />

    <x-calc.result label="Impermanent loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['change' => 100],
        'Example B' => ['change' => -50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Price ratio k'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>IL = 2√k ÷ (1 + k) − 1, where k = new price ÷ old price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
