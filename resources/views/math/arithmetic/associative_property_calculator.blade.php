<x-calc.page
    title="Associative Property Calculator - SolveKit"
    description="Free associative property calculator: compare (a ∘ b) ∘ c with a ∘ (b ∘ c) for addition, subtraction, multiplication and division."
    lede="Check the associative property."
    about="Addition and multiplication are associative: the grouping does not matter, (2 + 3) + 4 = 2 + (3 + 4). Subtraction and division are not: (10 − 4) − 3 = 3 but 10 − (4 − 3) = 9."
    :calc="['engine' => 'mt-arith', 'tool' => 'property', 'fields' => ['a', 'b', 'c', 'op'], 'prop' => 'associative']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is (10 − 4) − 3 equal to 10 − (4 − 3)?', 'answer' => 'Not equal.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="a" label="a" value="10" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="3" type="text" inputmode="decimal" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="-" />
    </div>

    <x-calc.result label="Associative?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '10', 'b' => '4', 'c' => '3', 'op' => '-'],
        'Addition' => ['a' => '10', 'b' => '4', 'c' => '3', 'op' => '+'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'left' => ['label' => '(a ∘ b) ∘ c'],
            'right' => ['label' => 'a ∘ (b ∘ c)'],
            'holds' => ['label' => 'Holds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a ∘ b) ∘ c = a ∘ (b ∘ c)?</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
