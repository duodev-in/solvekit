<x-calc.page
    title="Sustainable Growth Rate Calculator - SolveKit"
    description="Free Sustainable Growth Rate Calculator: g = ROE × (1 − payout). The sustainable growth rate is how fast a company can grow from retained earnings without new equity or more leverage."
    lede="Work out the sustainable growth rate from return on equity and dividend payout ratio."
    about="The sustainable growth rate is how fast a company can grow from retained earnings without new equity or more leverage. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'sustainable_growth_rate', 'fields' => ['roe', 'payout']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Return on equity, Dividend payout ratio.'],
        ['name' => 'Read the result', 'text' => 'The sustainable growth rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the sustainable growth rate?', 'answer' => 'G = ROE × (1 − payout).'],
        ['question' => 'What is the sustainable growth rate for return on equity 15%, dividend payout ratio 40%?', 'answer' => '9%.'],
        ['question' => 'And for return on equity 22%, dividend payout ratio 25%?', 'answer' => '16.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Faster growth needs more debt or new shares.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="roe" label="Return on equity" value="15" step="any" suffix="%" />
        <x-calc.field name="payout" label="Dividend payout ratio" value="40" step="any" suffix="%" />
    </div>

    <x-calc.result label="Sustainable growth rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['roe' => 15, 'payout' => 40],
        'Example B' => ['roe' => 22, 'payout' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g = ROE × (1 − payout)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
