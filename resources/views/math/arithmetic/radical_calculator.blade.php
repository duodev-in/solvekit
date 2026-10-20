<x-calc.page
    title="Radical Calculator - SolveKit"
    description="Free radical calculator: simplify square, cube and higher roots, with decimal values."
    lede="Work with radicals."
    about="A radical ⁿ√x is in simplest form when the radicand has no perfect n-th power factor. The decimal value is shown alongside: 2√18 = 6√2 ≈ 8.4853."
    :calc="['engine' => 'mt-number', 'tool' => 'radical', 'fields' => ['coef', 'index', 'radicand']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Simplify 2√18.', 'answer' => '6√2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coef" label="Coefficient" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="index" label="Index n" value="2" min="2" max="20" step="1" />
        <x-calc.field name="radicand" label="Radicand" value="18" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['coef' => '2', 'index' => 2, 'radicand' => '18'],
        'Fourth root' => ['coef' => '1', 'index' => 4, 'radicand' => '162'],
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
