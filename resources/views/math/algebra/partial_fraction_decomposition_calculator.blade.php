<x-calc.page
    title="Partial Fraction Decomposition Calculator - SolveKit"
    description="Free partial fraction decomposition calculator: split a rational function into partial fractions with linear, repeated and quadratic factors."
    lede="Decompose into partial fractions."
    about="A proper rational function N(x)/D(x) splits into simpler fractions, one A/(x − r)ᵏ for each linear factor power and one (Bx + C)/qᵏ for each irreducible quadratic factor. Improper fractions are divided first. This tool handles denominators that factor over the rationals into linear and quadratic factors, as in textbook and integration problems."
    :calc="['engine' => 'mt-algebra', 'tool' => 'partial_fractions', 'fields' => ['num', 'den']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Decompose (5x − 4)/(x² − x − 2).', 'answer' => '3/(x + 1) + 2/(x − 2).'],
        ['question' => 'And 1/((x − 1)²(x + 2))?', 'answer' => '−1/(9(x − 1)) + 1/(3(x − 1)²) + 1/(9(x + 2)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="num" label="Numerator" value="5x - 4" type="text" inputmode="text" />
        <x-calc.field name="den" label="Denominator" value="x^2 - x - 2" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Partial fractions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['num' => '5x - 4', 'den' => 'x^2 - x - 2'],
        'Repeated' => ['num' => '1', 'den' => '(x-1)^2 (x+2)'],
        'Quadratic' => ['num' => '3x^2 + 2', 'den' => 'x^3 + x'],
        'Improper' => ['num' => 'x^3', 'den' => 'x^2 - 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'factored' => ['label' => 'Factored denominator'],
            'coefficients' => ['label' => 'Coefficients'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N/D = Σ A/(x − r)ᵏ + Σ (Bx + C)/qᵏ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
