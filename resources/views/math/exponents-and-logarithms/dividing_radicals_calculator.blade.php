<x-calc.page
    title="Dividing Radicals Calculator - SolveKit"
    description="Free dividing radicals calculator: a·ᵏ√x ÷ b·ᵏ√y simplified, with the denominator rationalized."
    lede="Divide radicals."
    about="Radicals with the same index divide under one root: √x ÷ √y = √(x/y). Simplify and rationalize the denominator so no root remains below the line: 6√10 ÷ 3√2 = 2√5."
    :calc="['engine' => 'mt-explog', 'tool' => 'radicals', 'fields' => ['c1', 'r1', 'c2', 'r2', 'index'], 'op' => 'divide']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 6√10 ÷ 3√2?', 'answer' => '2√5.'],
        ['question' => 'What is √3 ÷ √8?', 'answer' => '√6/4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="c1" label="Coefficient a" value="6" type="text" inputmode="decimal" />
        <x-calc.field name="r1" label="Radicand x" value="10" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="c2" label="Coefficient b" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="r2" label="Radicand y" value="2" type="text" inputmode="decimal" />
    </div>

    <x-calc.field name="index" label="Root index k" value="2" min="2" max="20" step="1" />

    <x-calc.result label="Quotient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['c1' => '6', 'r1' => '10', 'c2' => '3', 'r2' => '2', 'index' => 2],
        'Rationalize' => ['c1' => '1', 'r1' => '3', 'c2' => '1', 'r2' => '8', 'index' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ᵏ√x ÷ ᵏ√y = ᵏ√(x/y)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
