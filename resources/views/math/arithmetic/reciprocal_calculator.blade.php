<x-calc.page
    title="Reciprocal Calculator - SolveKit"
    description="Free reciprocal calculator: 1/x of a number or fraction, exactly, with the decimal."
    lede="Find the reciprocal."
    about="The reciprocal of x is 1/x: flip a fraction upside down (2/3 → 3/2). A number times its reciprocal is 1. Zero has no reciprocal."
    :calc="['engine' => 'mt-number', 'tool' => 'reciprocal', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the reciprocal of 2/3?', 'answer' => '3/2.'],
    ]"
>
    <x-calc.field name="x" label="Number or fraction" value="2/3" type="text" inputmode="text" />

    <x-calc.result label="Reciprocal" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '2/3'],
        'Decimal' => ['x' => '0.125'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
            'mixed' => ['label' => 'Mixed number'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1/x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
