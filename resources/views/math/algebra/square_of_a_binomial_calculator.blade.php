<x-calc.page
    title="Square of a Binomial Calculator - SolveKit"
    description="Free square of a binomial calculator: (a ± b)² = a² ± 2ab + b² expanded with your terms."
    lede="Square a binomial."
    about="The square of a binomial is (a + b)² = a² + 2ab + b², not a² + b². For (3x − 5)²: a = 3x, b = −5, so 9x² − 30x + 25."
    :calc="['engine' => 'mt-algebra', 'tool' => 'square_binomial', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Expand (3x − 5)².', 'answer' => '9x² − 30x + 25.'],
    ]"
>
    <x-calc.field name="p1" label="Binomial" value="3x - 5" type="text" inputmode="text" />

    <x-calc.result label="Square" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '3x - 5'],
        'Fraction' => ['p1' => 'x + 1/2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'degree' => ['label' => 'Degree'],
            'terms' => ['label' => 'Terms'],
            'factored' => ['label' => 'Factored form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a + b)² = a² + 2ab + b²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
