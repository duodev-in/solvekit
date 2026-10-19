<x-calc.page
    title="Annualized Return Calculator - SolveKit"
    description="Free Annualized Return Calculator: annualized = (1 + total return)^(365 ÷ days) − 1. Turns a total return over any period into an equivalent yearly rate."
    lede="Work out the annualized return from total return and holding period."
    about="Turns a total return over any period into an equivalent yearly rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'annualized_return', 'fields' => ['total', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total return, Holding period.'],
        ['name' => 'Read the result', 'text' => 'The annualized return appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the annualized return?', 'answer' => 'Annualized = (1 + total return)^(365 ÷ days) − 1.'],
        ['question' => 'What is the annualized return for total return 45%, holding period 900 days?', 'answer' => '16.26%.'],
        ['question' => 'And for total return 8%, holding period 120 days?', 'answer' => '26.38%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Annualizing very short periods exaggerates results; treat them with care.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total" label="Total return" value="45" step="any" suffix="%" />
        <x-calc.field name="days" label="Holding period" value="900" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Annualized return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['total' => 45, 'days' => 900],
        'Example B' => ['total' => 8, 'days' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>annualized = (1 + total return)^(365 ÷ days) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
