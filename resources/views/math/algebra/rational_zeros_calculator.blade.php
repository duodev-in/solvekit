<x-calc.page
    title="Rational Zeros Calculator - SolveKit"
    description="Free rational zeros calculator: list the rational root candidates ±p/q of a polynomial and test each one."
    lede="Find rational zeros."
    about="The rational root theorem says any rational root p/q (in lowest terms) of a polynomial with integer coefficients has p dividing the constant term and q dividing the leading coefficient. Testing each candidate finds every rational zero."
    :calc="['engine' => 'mt-algebra', 'tool' => 'rational_zeros', 'fields' => ['p1']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the rational zeros of 2x³ − 3x² − 11x + 6?', 'answer' => '1/2, −2, 3.'],
    ]"
>
    <x-calc.field name="p1" label="Polynomial" value="2x^3 - 3x^2 - 11x + 6" type="text" inputmode="text" />

    <x-calc.result label="Rational zeros" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p1' => '2x^3 - 3x^2 - 11x + 6'],
        'None' => ['p1' => 'x^3 - 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'candidates' => ['label' => 'Candidates'],
            'factored' => ['label' => 'Factored form'],
            'degree' => ['label' => 'Degree'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p | a₀, q | aₙ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
