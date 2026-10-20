<x-calc.page
    title="Factor Calculator - SolveKit"
    description="Free factor calculator: all factors (divisors) of a number, factor pairs, the count and sum of divisors."
    lede="List all factors of a number."
    about="A factor divides a number exactly. All factors come from the prime factorisation: 360 = 2³ × 3² × 5 has (3 + 1)(2 + 1)(1 + 1) = 24 factors. The sum of proper divisors says whether a number is perfect, abundant or deficient. Also known as divisor calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'factors', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the factors of 360?', 'answer' => '1, 2, 3, 4, 5, 6, 8, 9, 10, 12, 15, 18, 20, 24, 30, 36, 40, 45, 60, 72, 90, 120, 180, 360.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="360" type="text" inputmode="decimal" />

    <x-calc.result label="Factors" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '360'],
        'Perfect' => ['n' => '28'],
        'Prime' => ['n' => '97'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Number of factors'],
            'pairs' => ['label' => 'Factor pairs'],
            'prime' => ['label' => 'Prime factorisation'],
            'sum' => ['label' => 'Sum of factors'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d(n) = Π(eᵢ + 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
