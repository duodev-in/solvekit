<x-calc.page
    title="Multiplying Exponents Calculator - SolveKit"
    description="Free multiplying exponents calculator: aᵐ × aⁿ = aᵐ⁺ⁿ with the rule and the value."
    lede="Multiply powers with the same base."
    about="When powers with the same base are multiplied, add the exponents: x³ × x⁴ = x⁷ and 2⁵ × 2⁻² = 2³ = 8. Different bases with the same exponent combine the other way: aⁿbⁿ = (ab)ⁿ."
    :calc="['engine' => 'mt-explog', 'tool' => 'rule', 'fields' => ['base', 'm', 'n'], 'rule' => 'multiply']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is x³ × x⁴?', 'answer' => 'x⁷.'],
        ['question' => 'What is 2⁵ × 2⁻²?', 'answer' => '2³ (= 8).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="base" label="Base" value="x" type="text" inputmode="text" />
        <x-calc.field name="m" label="Exponent m" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="Exponent n" value="4" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => 'x', 'm' => '3', 'n' => '4'],
        'Number' => ['base' => '2', 'm' => '5', 'n' => '-2'],
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
            <li>aᵐ × aⁿ = aᵐ⁺ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
