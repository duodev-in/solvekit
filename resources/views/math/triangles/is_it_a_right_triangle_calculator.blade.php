<x-calc.page
    title="Is it a Right Triangle Calculator - SolveKit"
    description="Free right triangle checker: test whether three sides satisfy a² + b² = c² exactly (fractions allowed), and whether the triangle is acute or obtuse."
    lede="Check for a right triangle."
    about="By the converse of Pythagoras, a triangle is right-angled exactly when the two shorter sides satisfy a² + b² = c². If a² + b² > c² it is acute; if smaller, obtuse. The test is done with exact fractions, so 0.3, 0.4, 0.5 is recognised."
    :calc="['engine' => 'mt-tri', 'tool' => 'sides_check', 'fields' => ['a', 'b', 'c'], 'mode' => 'right']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Is 5, 12, 13 a right triangle?', 'answer' => 'Yes, a right triangle.'],
        ['question' => 'And 6, 7, 9?', 'answer' => 'No: Acute (a² + b² > c²).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Side a" value="5" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Side b" value="12" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="Side c" value="13" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Is it a right triangle?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '5', 'b' => '12', 'c' => '13'],
        'No' => ['a' => '6', 'b' => '7', 'c' => '9'],
        'Decimals' => ['a' => '0.3', 'b' => '0.4', 'c' => '0.5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lhs' => ['label' => 'a² + b²'],
            'rhs' => ['label' => 'c²'],
            'kind' => ['label' => 'Type'],
            'valid' => ['label' => 'Triangle inequality'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a² + b² = c²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
