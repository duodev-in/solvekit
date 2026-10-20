<x-calc.page
    title="Interval Notation Calculator - SolveKit"
    description="Free interval notation calculator: union, intersection, difference and complement of intervals, with set-builder notation and a number line."
    lede="Combine intervals."
    about="Intervals can be combined like sets: (−∞, 3] ∪ [5, 7) ∩ [2, 6] = [2, 3] ∪ [5, 6]. Type intervals with brackets and ∪ (or U); use inf for infinity."
    :calc="['engine' => 'mt-alg2', 'tool' => 'intervals', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is ((−∞, 3] ∪ [5, 7)) ∩ [2, 6]?', 'answer' => '[2, 3] ∪ [5, 6].'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Interval A" value="(-inf, 3] U [5, 7)" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['union' => 'A ∪ B', 'intersection' => 'A ∩ B', 'difference' => 'A − B', 'complement' => 'Complement of A']" selected="intersection" />
        <x-calc.field name="b" label="Interval B" value="[2, 6]" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '(-inf, 3] U [5, 7)', 'op' => 'intersection', 'b' => '[2, 6]'],
        'Complement' => ['a' => '[0, 1)', 'op' => 'complement', 'b' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Number line" name="line" />
        <x-calc.rows heading="Details" :rows="[
            'interval' => ['label' => 'Interval notation'],
            'builder' => ['label' => 'Set-builder notation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>set operations on intervals</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
