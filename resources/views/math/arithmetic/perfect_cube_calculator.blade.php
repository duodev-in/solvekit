<x-calc.page
    title="Perfect Cube Calculator - SolveKit"
    description="Free perfect cube calculator: whether a whole number is a perfect cube, its cube root and the nearest cubes."
    lede="Check for a perfect cube."
    about="A perfect cube is an integer cubed: 1, 8, 27, 64, … and negatives such as −125. The integer cube root is exact."
    :calc="['engine' => 'mt-number', 'tool' => 'perfect_power', 'fields' => ['n'], 'power' => 3]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 2197 a perfect cube?', 'answer' => 'Yes, 2,197 = 13³.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="2197" type="text" inputmode="decimal" />

    <x-calc.result label="Perfect cube?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '2197'],
        'No' => ['n' => '1000001'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'root' => ['label' => 'Cube root'],
            'lower' => ['label' => 'Cube below'],
            'upper' => ['label' => 'Cube above'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = k³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
