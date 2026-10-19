<x-calc.page
    title="Annualized Rate of Return Calculator - SolveKit"
    description="Free Annualized Rate of Return Calculator: annualized return = (end ÷ start)^(1/years) − 1. The annualized (geometric) return is the constant yearly rate that turns the starting value into the ending value."
    lede="Work out the annualized return from starting value, ending value and years held."
    about="The annualized (geometric) return is the constant yearly rate that turns the starting value into the ending value. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'annualized_rate_of_return', 'fields' => ['start', 'end', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Starting value, Ending value, Years held.'],
        ['name' => 'Read the result', 'text' => 'The annualized return appears as you type, with total return below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the annualized return?', 'answer' => 'Annualized return = (end ÷ start)^(1/years) − 1.'],
        ['question' => 'What is the annualized return for starting value $10,000, ending value $16,500, years held 5?', 'answer' => '10.53%. Total return: 65%.'],
        ['question' => 'And for starting value $5,000, ending value $4,200, years held 2.5?', 'answer' => '−6.736%. Total return: −16%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It is lower than the simple average of yearly returns when returns vary.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Starting value" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending value" value="16500" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years held" value="5" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Annualized return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['start' => 10000, 'end' => 16500, 'years' => 5],
        'Example B' => ['start' => 5000, 'end' => 4200, 'years' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total return'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>annualized return = (end ÷ start)^(1/years) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
