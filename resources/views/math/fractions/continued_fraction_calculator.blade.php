<x-calc.page
    title="Continued Fraction Calculator - SolveKit"
    description="Free continued fraction calculator: the continued fraction of a fraction, decimal or square root, with its convergents."
    lede="Find a continued fraction."
    about="Every rational number has a finite continued fraction [a₀; a₁, a₂, …] from Euclid's algorithm: 415/93 = [4; 2, 6, 7]. Square roots of non-squares repeat forever: √2 = [1; (2)]. The convergents are the best rational approximations."
    :calc="['engine' => 'mt-frac', 'tool' => 'continued', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 415/93 as a continued fraction?', 'answer' => '[4; 2, 6, 7].'],
        ['question' => 'And √7?', 'answer' => '[2; (1, 1, 1, 4)].'],
    ]"
>
    <x-calc.field name="value" label="Number" value="415/93" type="text" help="A fraction, a decimal or sqrt(n)" inputmode="text" />

    <x-calc.result label="Continued fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '415/93'],
        'Root' => ['value' => 'sqrt(7)'],
        'Decimal' => ['value' => '3.14159'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'notation' => ['label' => 'Expanded'],
            'convergents' => ['label' => 'Convergents'],
            'period' => ['label' => 'Repeating block'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = a₀ + 1/(a₁ + 1/(a₂ + …))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
