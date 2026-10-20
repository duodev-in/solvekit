<x-calc.page
    title="Union and Intersection Calculator - SolveKit"
    description="Free union and intersection calculator: A ∪ B, A ∩ B, differences, symmetric difference and complement of finite sets."
    lede="Combine two sets."
    about="The union A ∪ B holds everything in A or B; the intersection A ∩ B only what is in both. The inclusion–exclusion principle |A ∪ B| = |A| + |B| − |A ∩ B| avoids double counting."
    :calc="['engine' => 'mt-alg2', 'tool' => 'set_ops', 'fields' => ['a', 'b', 'u']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the union and intersection of {1, 2, 3, 4} and {3, 4, 5}?', 'answer' => '{1, 2, 3, 4, 5} and A ∩ B = {3, 4}.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Set A" value="1, 2, 3, 4" type="text" inputmode="text" />
        <x-calc.field name="b" label="Set B" value="3, 4, 5" type="text" inputmode="text" />
        <x-calc.field name="u" label="Universal set (optional)" value="1, 2, 3, 4, 5, 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="A ∪ B" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1, 2, 3, 4', 'b' => '3, 4, 5', 'u' => '1, 2, 3, 4, 5, 6'],
        'Words' => ['a' => 'red, green, blue', 'b' => 'blue, yellow', 'u' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'union' => ['label' => 'A ∪ B'],
            'inter' => ['label' => 'A ∩ B'],
            'diff' => ['label' => 'Differences'],
            'sym' => ['label' => 'Symmetric difference'],
            'comp' => ['label' => 'Complement of A'],
            'sizes' => ['label' => 'Counting'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|A ∪ B| = |A| + |B| − |A ∩ B|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
