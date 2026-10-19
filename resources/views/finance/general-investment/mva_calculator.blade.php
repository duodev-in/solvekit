<x-calc.page
    title="MVA Calculator - SolveKit"
    description="Free MVA Calculator: MVA = market value − invested capital. Market value added is how much value management has created above the capital investors put in."
    lede="Work out the market value added from market value of the company (debt + equity) and invested capital."
    about="Market value added is how much value management has created above the capital investors put in. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'mva', 'fields' => ['market', 'capital']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Market value of the company (debt + equity), Invested capital.'],
        ['name' => 'Read the result', 'text' => 'The market value added appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the market value added?', 'answer' => 'MVA = market value − invested capital.'],
        ['question' => 'What is the market value added for market value of the company $5,000,000, invested capital $3,500,000?', 'answer' => '$1,500,000.00.'],
        ['question' => 'And for market value of the company $1,200,000, invested capital $1,500,000?', 'answer' => '−$300,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative MVA means the market values the company below its capital.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="market" label="Market value of the company (debt + equity)" value="5000000" step="0.01" suffix="$" />
        <x-calc.field name="capital" label="Invested capital" value="3500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Market value added" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['market' => 5000000, 'capital' => 3500000],
        'Example B' => ['market' => 1200000, 'capital' => 1500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MVA = market value − invested capital</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
