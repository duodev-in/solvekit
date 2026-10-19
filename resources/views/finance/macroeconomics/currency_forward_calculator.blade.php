<x-calc.page
    title="Currency Forward Calculator - SolveKit"
    description="Free Currency Forward Calculator: F = S × (1 + r_quote × t) ÷ (1 + r_base × t). Covered interest parity sets the forward exchange rate from the spot rate and the two interest rates."
    lede="Work out the forward rate from your figures."
    about="Covered interest parity sets the forward exchange rate from the spot rate and the two interest rates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'currency_forward', 'fields' => ['spot', 'rd', 'rf', 'days', 'basis']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Spot rate (quote per base), Quote currency interest rate, Base currency interest rate, Days, Day count.'],
        ['name' => 'Read the result', 'text' => 'The forward rate appears as you type, with forward points (× 10,000) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the forward rate?', 'answer' => 'F = S × (1 + r_quote × t) ÷ (1 + r_base × t).'],
        ['question' => 'What is the forward rate for spot rate 1.1, quote currency interest rate 4%, base currency interest rate 3%, days 180, day count 360 days?', 'answer' => '1.105. Forward points (× 10,000): 54.19.'],
        ['question' => 'And for spot rate 150, quote currency interest rate 0.5%, base currency interest rate 4.5%, days 90, day count 360 days?', 'answer' => '148.52. Forward points (× 10,000): −14,833.13.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The higher-rate currency trades at a forward discount.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spot" label="Spot rate (quote per base)" value="1.1" step="any" />
        <x-calc.field name="rd" label="Quote currency interest rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rf" label="Base currency interest rate" value="3" step="any" suffix="%" />
        <x-calc.field name="days" label="Days" value="180" min="0" step="any" suffix="days" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['360' => '360 days', '365' => '365 days']" selected="360" />
    </div>

    <x-calc.result label="Forward rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['spot' => 1.1, 'rd' => 4, 'rf' => 3, 'days' => 180, 'basis' => '360'],
        'Example B' => ['spot' => 150, 'rd' => 0.5, 'rf' => 4.5, 'days' => 90, 'basis' => '360'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Forward points (× 10,000)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = S × (1 + r_quote × t) ÷ (1 + r_base × t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
