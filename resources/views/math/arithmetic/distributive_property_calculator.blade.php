<x-calc.page
    title="Distributive Property Calculator - SolveKit"
    description="Free distributive property calculator: show a(b + c) = ab + ac with your numbers."
    lede="Check the distributive property."
    about="Multiplication distributes over addition: a(b + c) = ab + ac. It is behind mental tricks such as 7 × 98 = 7 × 100 − 7 × 2 = 686 and behind expanding brackets in algebra."
    :calc="['engine' => 'mt-arith', 'tool' => 'property', 'fields' => ['a', 'b', 'c'], 'prop' => 'distributive']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Show 7(100 − 2) = 7 × 100 − 7 × 2.', 'answer' => '686 = 686.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="7" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="100" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="-2" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="a(b + c) = ab + ac" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '7', 'b' => '100', 'c' => '-2'],
        'Fractions' => ['a' => '1/2', 'b' => '6', 'c' => '3/4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'left' => ['label' => 'a(b + c)'],
            'right' => ['label' => 'ab + ac'],
            'holds' => ['label' => 'Holds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a(b + c) = ab + ac</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
