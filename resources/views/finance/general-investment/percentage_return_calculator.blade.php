<x-calc.page
    title="Percentage Return Calculator - SolveKit"
    description="Free Percentage Return Calculator: return = (end − start + income) ÷ start. Percentage return is the gain (or loss) including income as a share of what you invested."
    lede="Work out the return from amount invested, current value and income received."
    about="Percentage return is the gain (or loss) including income as a share of what you invested. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'percentage_return', 'fields' => ['start', 'end', 'income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Amount invested, Current value, Income received.'],
        ['name' => 'Read the result', 'text' => 'The return appears as you type, with gain below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the return?', 'answer' => 'Return = (end − start + income) ÷ start.'],
        ['question' => 'What is the return for amount invested $5,000, current value $6,200, income received $150?', 'answer' => '27%. Gain: $1,350.00.'],
        ['question' => 'And for amount invested $800, current value $640, income received $0?', 'answer' => '−20%. Gain: −$160.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Annualize it to compare investments held for different times.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Amount invested" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Current value" value="6200" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Income received" value="150" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['start' => 5000, 'end' => 6200, 'income' => 150],
        'Example B' => ['start' => 800, 'end' => 640, 'income' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Gain'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>return = (end − start + income) ÷ start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
