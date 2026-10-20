<x-calc.page
    title="Factoring Trinomials Calculator - SolveKit"
    description="Free factoring trinomials calculator: factor ax² + bx + c over the integers with the AC method, or show that it is prime."
    lede="Factor a trinomial."
    about="To factor ax² + bx + c, find two numbers that multiply to ac and add to b, split the middle term and factor by grouping: 6x² + 11x − 10 → ac = −60, numbers 15 and −4 → (3x − 2)(2x + 5). If no such integers exist, the trinomial is prime over the integers."
    :calc="['engine' => 'mt-algebra', 'tool' => 'factor', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Factor 6x² + 11x − 10.', 'answer' => '(3x − 2)(2x + 5).'],
    ]"
>
    <x-calc.field name="p1" label="Trinomial" value="6x^2 + 11x - 10" type="text" inputmode="text" />

    <x-calc.result label="Factored form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '6x^2 + 11x - 10'],
        'Prime' => ['p1' => 'x^2 + x + 1'],
        'Common factor' => ['p1' => '2x^2 - 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'expanded' => ['label' => 'Expanded'],
            'roots' => ['label' => 'Rational roots'],
            'degree' => ['label' => 'Degree'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ac method</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
