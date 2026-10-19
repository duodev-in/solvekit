<x-calc.page
    title="CTR Calculator - SolveKit"
    description="Free CTR Calculator: CTR = clicks ÷ impressions. Click-through rate is the share of people who saw an ad or link and clicked it."
    lede="Work out the click-through rate from clicks and impressions."
    about="Click-through rate is the share of people who saw an ad or link and clicked it. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ctr', 'fields' => ['clicks', 'impressions']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Clicks, Impressions.'],
        ['name' => 'Read the result', 'text' => 'The click-through rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the click-through rate?', 'answer' => 'CTR = clicks ÷ impressions.'],
        ['question' => 'What is the click-through rate for clicks 350, impressions 25,000?', 'answer' => '1.4%.'],
        ['question' => 'And for clicks 90, impressions 15,000?', 'answer' => '0.6%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Search ads often get 2–6%; display ads well under 1%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="clicks" label="Clicks" value="350" min="0" step="1" />
        <x-calc.field name="impressions" label="Impressions" value="25000" min="0" step="1" />
    </div>

    <x-calc.result label="Click-through rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['clicks' => 350, 'impressions' => 25000],
        'Example B' => ['clicks' => 90, 'impressions' => 15000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CTR = clicks ÷ impressions</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
