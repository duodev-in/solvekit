<x-calc.page
    title="Consecutive Integers Calculator - SolveKit"
    description="Free consecutive integers calculator: find consecutive (or consecutive even or odd) integers with a given sum."
    lede="Find consecutive integers from their sum."
    about="n consecutive integers starting at a add up to n·a + n(n − 1)/2 (or n(n − 1) for even or odd ones, which step by 2). So three consecutive integers adding to 72 are 23, 24, 25."
    :calc="['engine' => 'mt-arith', 'tool' => 'consecutive', 'fields' => ['sum', 'count', 'kind']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Which three consecutive integers add to 72?', 'answer' => '23, 24, 25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sum" label="Sum" value="72" type="text" inputmode="decimal" />
        <x-calc.field name="count" label="How many" value="3" type="text" inputmode="decimal" />
        <x-calc.select name="kind" label="Type" :options="['any' => 'Consecutive', 'even' => 'Consecutive even', 'odd' => 'Consecutive odd']" selected="any" />
    </div>

    <x-calc.result label="Integers" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sum' => '72', 'count' => '3', 'kind' => 'any'],
        'Odd' => ['sum' => '75', 'count' => '5', 'kind' => 'odd'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First integer'],
            'formula' => ['label' => 'Equation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>na + d·n(n − 1)/2 = S</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
