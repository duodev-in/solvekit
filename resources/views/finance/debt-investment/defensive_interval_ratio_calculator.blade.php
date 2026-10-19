<x-calc.page
    title="Defensive Interval Ratio Calculator - SolveKit"
    description="Free Defensive Interval Ratio Calculator: DIR = (cash + securities + receivables) ÷ daily operating expenses. The defensive interval is how many days the company could run on its liquid assets with no new revenue."
    lede="Work out the defensive interval from your figures."
    about="The defensive interval is how many days the company could run on its liquid assets with no new revenue. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'defensive_interval_ratio', 'fields' => ['cash', 'securities', 'receivables', 'expenses']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cash, Marketable securities, Receivables, Annual operating expenses (excluding non-cash).'],
        ['name' => 'Read the result', 'text' => 'The defensive interval appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the defensive interval?', 'answer' => 'DIR = (cash + securities + receivables) ÷ daily operating expenses.'],
        ['question' => 'What is the defensive interval for cash $50,000, marketable securities $30,000, receivables $40,000, annual operating expenses $730,000?', 'answer' => '60 days.'],
        ['question' => 'And for cash $15,000, marketable securities $0, receivables $22,000, annual operating expenses $365,000?', 'answer' => '37 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Longer is safer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Cash" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="securities" label="Marketable securities" value="30000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="receivables" label="Receivables" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="expenses" label="Annual operating expenses (excluding non-cash)" value="730000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Defensive interval" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cash' => 50000, 'securities' => 30000, 'receivables' => 40000, 'expenses' => 730000],
        'Example B' => ['cash' => 15000, 'securities' => 0, 'receivables' => 22000, 'expenses' => 365000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DIR = (cash + securities + receivables) ÷ daily operating expenses</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
