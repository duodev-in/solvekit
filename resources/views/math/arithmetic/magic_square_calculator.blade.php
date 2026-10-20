<x-calc.page
    title="Magic Square Calculator - SolveKit"
    description="Free magic square calculator: a magic square of any order from 3 to 12 and its magic constant."
    lede="Build a magic square."
    about="In a magic square of order n every row, column and both diagonals add up to the magic constant n(n² + 1)/2 (15 for 3 × 3, 34 for 4 × 4). Odd orders use the Siamese method, multiples of 4 a diagonal pattern, and the rest Conway's LUX method."
    :calc="['engine' => 'mt-arith', 'tool' => 'magic', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What does a 4 × 4 magic square add up to?', 'answer' => '34.'],
    ]"
>
    <x-calc.field name="n" label="Order n" value="3" min="3" max="12" step="1" />

    <x-calc.result label="Magic constant" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 3],
        'Four' => ['n' => 4],
        'Six' => ['n' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'method' => ['label' => 'Method'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Square" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = n(n² + 1)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
