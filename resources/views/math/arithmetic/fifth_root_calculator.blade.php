<x-calc.page
    title="Fifth Root Calculator - SolveKit"
    description="Free fifth root calculator: ⁵√x, including negative numbers, exactly or as a simplified radical."
    lede="Find a fifth root."
    about="The fifth root undoes the fifth power: ⁵√32 = 2 and ⁵√−243 = −3 (odd roots of negatives are real)."
    :calc="['engine' => 'mt-number', 'tool' => 'roots', 'fields' => ['x', 'index']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the fifth root of −243?', 'answer' => '−3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number" value="-243" type="text" inputmode="text" />
        <x-calc.field name="index" label="Root (n)" value="5" min="2" max="100" step="1" />
    </div>

    <x-calc.result label="Root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '-243', 'index' => 5],
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
