<x-calc.page
    title="Greater Than Or Less Than Calculator - SolveKit"
    description="Free greater than or less than calculator: compare two numbers, fractions or expressions with <, = or >."
    lede="Compare two numbers."
    about="Comparisons are exact for fractions and decimals (2/3 > 0.666) and numerical for roots and π. The difference is shown too."
    :calc="['engine' => 'mt-arith', 'tool' => 'compare', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Which is bigger, 2/3 or 0.666?', 'answer' => '2/3 > 0.666.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First" value="2/3" type="text" inputmode="text" />
        <x-calc.field name="b" label="Second" value="0.666" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Comparison" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2/3', 'b' => '0.666'],
        'Roots' => ['a' => 'sqrt(10)', 'b' => 'pi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'difference' => ['label' => 'Difference'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a − b sign</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
