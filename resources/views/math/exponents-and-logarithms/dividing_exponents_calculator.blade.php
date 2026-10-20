<x-calc.page
    title="Dividing Exponents Calculator - SolveKit"
    description="Free dividing exponents calculator: aᵐ ÷ aⁿ = aᵐ⁻ⁿ with the rule and the value."
    lede="Divide powers with the same base."
    about="When powers with the same base are divided, subtract the exponents: x⁷ ÷ x³ = x⁴ and 3² ÷ 3⁵ = 3⁻³ = 1/27. This is why a⁰ = 1: aⁿ ÷ aⁿ = a⁰."
    :calc="['engine' => 'mt-explog', 'tool' => 'rule', 'fields' => ['base', 'm', 'n'], 'rule' => 'divide']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is x⁷ ÷ x³?', 'answer' => 'x⁴.'],
        ['question' => 'What is 3² ÷ 3⁵?', 'answer' => '3⁻³ (= 1/27).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="base" label="Base" value="x" type="text" inputmode="text" />
        <x-calc.field name="m" label="Exponent m" value="7" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="Exponent n" value="3" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => 'x', 'm' => '7', 'n' => '3'],
        'Number' => ['base' => '3', 'm' => '2', 'n' => '5'],
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
            <li>aᵐ ÷ aⁿ = aᵐ⁻ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
