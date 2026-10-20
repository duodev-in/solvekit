<x-calc.page
    title="Triangle Inequality Theorem Calculator - SolveKit"
    description="Free triangle inequality theorem calculator: check whether three lengths can form a triangle and the range for the third side."
    lede="Check the triangle inequality."
    about="Three lengths form a triangle only if each is less than the sum of the other two. If two sides are 3 and 7, the third must be between 4 and 10. Equality gives a flat (degenerate) triangle."
    :calc="['engine' => 'mt-tri', 'tool' => 'sides_check', 'fields' => ['a', 'b', 'c'], 'mode' => 'inequality']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Can 3, 7 and 5 form a triangle?', 'answer' => 'Yes, these sides form a triangle.'],
        ['question' => 'And 2, 3 and 6?', 'answer' => 'No triangle.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Side a" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Side b" value="7" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="Side c" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Can they form a triangle?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3', 'b' => '7', 'c' => '5'],
        'No' => ['a' => '2', 'b' => '3', 'c' => '6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'checks' => ['label' => 'Checks'],
            'range' => ['label' => 'Range for the third side'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a + b > c</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
