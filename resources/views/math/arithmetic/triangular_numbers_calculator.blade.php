<x-calc.page
    title="Triangular Numbers Calculator - SolveKit"
    description="Free triangular numbers calculator: the n-th triangular number, a test for whether a number is triangular, and the dot triangle."
    lede="Find triangular numbers."
    about="Triangular numbers count dots in a triangle: 1, 3, 6, 10, 15 … with Tₙ = n(n + 1)/2. A number m is triangular when 8m + 1 is a perfect square."
    :calc="['engine' => 'mt-arith', 'tool' => 'triangular', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the 7th triangular number?', 'answer' => '28.'],
    ]"
>
    <x-calc.field name="n" label="n" value="7" type="text" inputmode="decimal" />

    <x-calc.result label="Tₙ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '7'],
        'Large' => ['n' => '1000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'test' => ['label' => 'Is n triangular'],
            'next' => ['label' => 'Next'],
            'sequence' => ['label' => 'First ten'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Tₙ = n(n + 1)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
