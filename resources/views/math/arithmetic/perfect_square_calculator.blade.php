<x-calc.page
    title="Perfect Square Calculator - SolveKit"
    description="Free perfect square calculator: whether a whole number is a perfect square, its root, and the nearest squares."
    lede="Check for a perfect square."
    about="A perfect square is an integer squared: 1, 4, 9, 16, …. The integer square root is computed exactly, so even 30-digit numbers are checked without rounding."
    :calc="['engine' => 'mt-number', 'tool' => 'perfect_power', 'fields' => ['n'], 'power' => 2]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 1849 a perfect square?', 'answer' => 'Yes, 1,849 = 43².'],
    ]"
>
    <x-calc.field name="n" label="Number" value="1849" type="text" inputmode="decimal" />

    <x-calc.result label="Perfect square?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '1849'],
        'No' => ['n' => '2000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'root' => ['label' => 'Square root'],
            'lower' => ['label' => 'Square below'],
            'upper' => ['label' => 'Square above'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = k²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
