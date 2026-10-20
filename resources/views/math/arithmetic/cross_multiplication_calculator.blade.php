<x-calc.page
    title="Cross Multiplication Calculator - SolveKit"
    description="Free cross multiplication calculator: solve a/b = c/x by cross-multiplying, with fractions allowed."
    lede="Solve by cross-multiplication."
    about="If a/b = c/x then a·x = b·c, so x = bc ÷ a. For 4/10 = 6/x, x = 10 × 6 ÷ 4 = 15."
    :calc="['engine' => 'mt-frac', 'tool' => 'cross', 'fields' => ['a', 'b', 'c']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Solve 4/10 = 6/x.', 'answer' => '15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="4" type="text" inputmode="text" />
        <x-calc.field name="b" label="b" value="10" type="text" inputmode="text" />
        <x-calc.field name="c" label="c" value="6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="x" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '4', 'b' => '10', 'c' => '6'],
        'Fractions' => ['a' => '3/4', 'b' => '2', 'c' => '5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Check'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = bc ÷ a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
