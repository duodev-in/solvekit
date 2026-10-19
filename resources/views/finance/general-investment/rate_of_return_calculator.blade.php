<x-calc.page
    title="Rate of Return Calculator - SolveKit"
    description="Free Rate of Return Calculator: return = (end − start) ÷ start. The rate of return is the gain as a share of the starting value, total and per year."
    lede="Work out the total return from starting value, ending value and years."
    about="The rate of return is the gain as a share of the starting value, total and per year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'rate_of_return', 'fields' => ['start', 'end', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Starting value, Ending value, Years.'],
        ['name' => 'Read the result', 'text' => 'The total return appears as you type, with annualized below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the total return?', 'answer' => 'Return = (end − start) ÷ start; annualized = (end ÷ start)^(1/years) − 1.'],
        ['question' => 'What is the total return for starting value $10,000, ending value $12,500, years 3?', 'answer' => '25%. Annualized: 7.722%.'],
        ['question' => 'And for starting value $2,500, ending value $2,100, years 2?', 'answer' => '−16%. Annualized: −8.348%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The annualized figure lets you compare holdings of different lengths.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Starting value" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending value" value="12500" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years" value="3" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Total return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['start' => 10000, 'end' => 12500, 'years' => 3],
        'Example B' => ['start' => 2500, 'end' => 2100, 'years' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Annualized'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>return = (end − start) ÷ start</li>
            <li>annualized = (end ÷ start)^(1/years) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
