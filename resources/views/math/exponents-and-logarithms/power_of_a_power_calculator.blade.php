<x-calc.page
    title="Power of a Power Calculator - SolveKit"
    description="Free power of a power calculator: (aᵐ)ⁿ = aᵐⁿ with the rule and the value."
    lede="Raise a power to a power."
    about="A power raised to a power multiplies the exponents: (x³)⁴ = x¹² and (2²)³ = 2⁶ = 64. Do not confuse it with a^(mⁿ): exponent towers are evaluated from the top down."
    :calc="['engine' => 'mt-explog', 'tool' => 'rule', 'fields' => ['base', 'm', 'n'], 'rule' => 'power']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (x³)⁴?', 'answer' => 'x¹².'],
        ['question' => 'What is (2²)³?', 'answer' => '2⁶ (= 64).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="base" label="Base" value="x" type="text" inputmode="text" />
        <x-calc.field name="m" label="Inner exponent m" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="Outer exponent n" value="4" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => 'x', 'm' => '3', 'n' => '4'],
        'Number' => ['base' => '2', 'm' => '2', 'n' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rule' => ['label' => 'Rule'],
            'exponent' => ['label' => 'Resulting exponent'],
            'value' => ['label' => 'Value'],
            'negative' => ['label' => 'Negative exponent'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(aᵐ)ⁿ = aᵐⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
