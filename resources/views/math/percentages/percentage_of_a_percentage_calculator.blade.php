<x-calc.page
    title="Percentage of a Percentage Calculator - SolveKit"
    description="Free percentage of a percentage calculator: what p% of q% is, and applied to a number."
    lede="Find a percentage of a percentage."
    about="Taking a percentage of a percentage multiplies the two as decimals: 20% of 50% = 0.2 × 0.5 = 0.1 = 10%. For example, if 50% of a class are girls and 20% of the girls play chess, 10% of the class are chess-playing girls."
    :calc="['engine' => 'mt-percent', 'tool' => 'pct_of_pct', 'fields' => ['a', 'b', 'base']]"
    :how-to="[
        ['name' => 'Enter the two percentages', 'text' => ''],
        ['name' => 'Add a number', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'What is 20% of 50%?', 'answer' => '10%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First percentage" value="20" type="text" suffix="%" inputmode="decimal" />
        <x-calc.field name="b" label="Second percentage" value="50" type="text" suffix="%" inputmode="decimal" />
        <x-calc.field name="base" label="Of a number (optional)" value="300" type="text" placeholder="Optional" inputmode="decimal" />
    </div>

    <x-calc.result label="Combined percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '20', 'b' => '50', 'base' => '300'],
        'Tax on discount' => ['a' => '8', 'b' => '75', 'base' => '120'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'As a decimal'],
            'ofBase' => ['label' => 'Of your number'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p₁% of p₂% = p₁ × p₂ ÷ 100 %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
