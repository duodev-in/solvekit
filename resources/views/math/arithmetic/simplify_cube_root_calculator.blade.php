<x-calc.page
    title="Simplify Cube Root Calculator - SolveKit"
    description="Free simplify cube root calculator: write ∛x in simplest form by taking out perfect cubes."
    lede="Simplify a cube root."
    about="Pull out the largest perfect cube factor: ∛250 = ∛(125 × 2) = 5∛2; ∛432 = ∛(216 × 2) = 6∛2."
    :calc="['engine' => 'mt-number', 'tool' => 'radical', 'fields' => ['coef', 'index', 'radicand']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Simplify ∛250.', 'answer' => '5∛2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coef" label="Coefficient" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="index" label="Index n" value="3" min="3" max="3" step="1" />
        <x-calc.field name="radicand" label="Radicand" value="250" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['coef' => '1', 'index' => 3, 'radicand' => '250'],
        'Large' => ['coef' => '2', 'index' => 3, 'radicand' => '432'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'factor' => ['label' => 'Factorisation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>∛(a³b) = a∛b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
