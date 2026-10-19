<x-calc.page
    title="Holding Period Return Calculator - SolveKit"
    description="Free Holding Period Return Calculator: HPR = (income + end − start) ÷ start. Holding period return is the total return over the time you held an investment."
    lede="Work out the holding period return from starting value, ending value and income received (dividends, interest)."
    about="Holding period return is the total return over the time you held an investment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'holding_period_return', 'fields' => ['start', 'end', 'income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Starting value, Ending value, Income received (dividends, interest).'],
        ['name' => 'Read the result', 'text' => 'The holding period return appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the holding period return?', 'answer' => 'HPR = (income + end − start) ÷ start.'],
        ['question' => 'What is the holding period return for starting value $1,000, ending value $1,100, income received $30?', 'answer' => '13%.'],
        ['question' => 'And for starting value $2,000, ending value $1,850, income received $60?', 'answer' => '−4.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Annualize it to compare periods of different lengths.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Starting value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending value" value="1100" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Income received (dividends, interest)" value="30" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Holding period return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['start' => 1000, 'end' => 1100, 'income' => 30],
        'Example B' => ['start' => 2000, 'end' => 1850, 'income' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>HPR = (income + end − start) ÷ start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
