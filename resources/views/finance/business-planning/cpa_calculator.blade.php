<x-calc.page
    title="CPA Calculator — Cost per Acquisition - SolveKit"
    description="Free CPA Calculator — Cost per Acquisition: CPA = spend ÷ acquisitions. Cost per acquisition is what you pay in advertising for each customer or conversion."
    lede="Work out the cost per acquisition from ad spend and acquisitions (sales or sign-ups)."
    about="Cost per acquisition is what you pay in advertising for each customer or conversion. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cpa', 'fields' => ['spend', 'acquisitions']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Ad spend, Acquisitions (sales or sign-ups).'],
        ['name' => 'Read the result', 'text' => 'The cost per acquisition appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cost per acquisition?', 'answer' => 'CPA = spend ÷ acquisitions.'],
        ['question' => 'What is the cost per acquisition for ad spend $5,000, acquisitions 125?', 'answer' => '$40.00.'],
        ['question' => 'And for ad spend $1,200, acquisitions 30?', 'answer' => '$40.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It is profitable when below the profit (or lifetime value) each acquisition brings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spend" label="Ad spend" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="acquisitions" label="Acquisitions (sales or sign-ups)" value="125" min="0" step="1" />
    </div>

    <x-calc.result label="Cost per acquisition" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['spend' => 5000, 'acquisitions' => 125],
        'Example B' => ['spend' => 1200, 'acquisitions' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPA = spend ÷ acquisitions</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
