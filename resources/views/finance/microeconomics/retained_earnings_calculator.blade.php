<x-calc.page
    title="Retained Earnings Calculator - SolveKit"
    description="Free Retained Earnings Calculator: RE = beginning RE + net income − dividends. Retained earnings are the accumulated profits kept in the business."
    lede="Work out the ending retained earnings from beginning retained earnings, net income and dividends."
    about="Retained earnings are the accumulated profits kept in the business. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'retained_earnings', 'fields' => ['begin', 'income', 'dividends']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Beginning retained earnings, Net income, Dividends.'],
        ['name' => 'Read the result', 'text' => 'The ending retained earnings appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ending retained earnings?', 'answer' => 'RE = beginning RE + net income − dividends.'],
        ['question' => 'What is the ending retained earnings for beginning retained earnings $500,000, net income $120,000, dividends $40,000?', 'answer' => '$580,000.00.'],
        ['question' => 'And for beginning retained earnings $80,000, net income −$25,000, dividends $0?', 'answer' => '$55,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A net loss reduces retained earnings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="begin" label="Beginning retained earnings" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Net income" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="dividends" label="Dividends" value="40000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Ending retained earnings" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['begin' => 500000, 'income' => 120000, 'dividends' => 40000],
        'Example B' => ['begin' => 80000, 'income' => -25000, 'dividends' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RE = beginning RE + net income − dividends</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
