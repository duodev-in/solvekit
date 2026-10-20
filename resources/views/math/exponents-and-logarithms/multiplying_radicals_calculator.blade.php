<x-calc.page
    title="Multiplying Radicals Calculator - SolveKit"
    description="Free multiplying radicals calculator: a·ᵏ√x × b·ᵏ√y simplified to simplest radical form."
    lede="Multiply radicals."
    about="Radicals with the same index multiply under one root: √x × √y = √(xy). Multiply the coefficients, multiply the radicands, then simplify: 2√6 × 3√10 = 6√60 = 12√15."
    :calc="['engine' => 'mt-explog', 'tool' => 'radicals', 'fields' => ['c1', 'r1', 'c2', 'r2', 'index'], 'op' => 'multiply']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 2√6 × 3√10?', 'answer' => '12√15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="c1" label="Coefficient a" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="r1" label="Radicand x" value="6" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="c2" label="Coefficient b" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="r2" label="Radicand y" value="10" type="text" inputmode="decimal" />
    </div>

    <x-calc.field name="index" label="Root index k" value="2" min="2" max="20" step="1" />

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['c1' => '2', 'r1' => '6', 'c2' => '3', 'r2' => '10', 'index' => 2],
        'Cube roots' => ['c1' => '1', 'r1' => '4', 'c2' => '1', 'r2' => '6', 'index' => 3],
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
            <li>ᵏ√x × ᵏ√y = ᵏ√(xy)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
