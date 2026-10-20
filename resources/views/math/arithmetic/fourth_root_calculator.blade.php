<x-calc.page
    title="Fourth Root Calculator - SolveKit"
    description="Free fourth root calculator: ⁴√x exactly when it is rational and as a simplified radical otherwise."
    lede="Find a fourth root."
    about="The fourth root of x is the number whose fourth power is x: ⁴√81 = 3 because 3⁴ = 81. It equals the square root of the square root. Negative numbers have no real fourth root."
    :calc="['engine' => 'mt-number', 'tool' => 'roots', 'fields' => ['x', 'index']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the fourth root of 81?', 'answer' => '3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number" value="81" type="text" inputmode="text" />
        <x-calc.field name="index" label="Root (n)" value="4" min="2" max="100" step="1" />
    </div>

    <x-calc.result label="Root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '81', 'index' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact form'],
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ⁿ√x = x^(1/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
