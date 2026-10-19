<x-calc.page
    title="Velocity of Money Calculator - SolveKit"
    description="Free Velocity of Money Calculator: V = nominal GDP ÷ money supply. Velocity is how many times a dollar is spent on final goods in a year (MV = PY)."
    lede="Work out the velocity of money from nominal GDP and money supply (M2)."
    about="Velocity is how many times a dollar is spent on final goods in a year (MV = PY). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'velocity_of_money', 'fields' => ['gdp', 'money']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal GDP, Money supply (M2).'],
        ['name' => 'Read the result', 'text' => 'The velocity of money appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the velocity of money?', 'answer' => 'V = nominal GDP ÷ money supply.'],
        ['question' => 'What is the velocity of money for nominal GDP $28,000, money supply $21,000?', 'answer' => '1.333×.'],
        ['question' => 'And for nominal GDP $12,000, money supply $6,000?', 'answer' => '2×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'US M2 velocity has been around 1.3–1.4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gdp" label="Nominal GDP" value="28000" step="0.01" suffix="$" />
        <x-calc.field name="money" label="Money supply (M2)" value="21000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Velocity of money" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['gdp' => 28000, 'money' => 21000],
        'Example B' => ['gdp' => 12000, 'money' => 6000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = nominal GDP ÷ money supply</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
