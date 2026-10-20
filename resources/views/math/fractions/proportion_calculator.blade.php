<x-calc.page
    title="Proportion Calculator - SolveKit"
    description="Free proportion calculator: solve a : b = c : d for the missing value by cross-multiplication."
    lede="Solve a proportion."
    about="A proportion states that two ratios are equal: a/b = c/d. Cross-multiplying gives ad = bc, so the missing value follows. Leave one box empty (or type x): 3/4 = x/20 gives x = 15."
    :calc="['engine' => 'mt-frac', 'tool' => 'proportion', 'fields' => ['a', 'b', 'c', 'd']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Solve 3 : 4 = x : 20.', 'answer' => '15.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="a" label="A" value="3" type="text" inputmode="text" />
        <x-calc.field name="b" label="B" value="4" type="text" inputmode="text" />
        <x-calc.field name="c" label="C" value="" type="text" placeholder="x" inputmode="text" />
        <x-calc.field name="d" label="D" value="20" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Missing value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3', 'b' => '4', 'c' => '', 'd' => '20'],
        'Fractions' => ['a' => '2/3', 'b' => '5', 'c' => '4', 'd' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Cross products'],
            'ratio' => ['label' => 'Ratio'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A/B = C/D ⇔ AD = BC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
