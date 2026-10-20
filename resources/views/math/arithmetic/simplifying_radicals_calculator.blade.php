<x-calc.page
    title="Simplifying Radicals Calculator - SolveKit"
    description="Free simplifying radicals calculator: write k·ⁿ√x in simplest radical form by pulling out perfect powers."
    lede="Simplify a radical."
    about="To simplify ⁿ√x, factor out the largest perfect n-th power: √72 = √(36 × 2) = 6√2, and 3√48 = 3 × 4√3 = 12√3. A radical is simplest when no factor under the root is a perfect n-th power."
    :calc="['engine' => 'mt-number', 'tool' => 'radical', 'fields' => ['coef', 'index', 'radicand']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Simplify 3√48.', 'answer' => '12√3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coef" label="Coefficient" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="index" label="Index n" value="2" min="2" max="20" step="1" />
        <x-calc.field name="radicand" label="Radicand" value="48" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['coef' => '3', 'index' => 2, 'radicand' => '48'],
        'Cube' => ['coef' => '1', 'index' => 3, 'radicand' => '250'],
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
            <li>ⁿ√(aⁿb) = a·ⁿ√b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
