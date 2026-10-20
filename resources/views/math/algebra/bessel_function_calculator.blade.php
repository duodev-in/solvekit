<x-calc.page
    title="Bessel Function Calculator - SolveKit"
    description="Free Bessel function calculator: Jν, Yν, Iν and Kν of real order ν, accurate to about 13 digits, with a graph."
    lede="Evaluate Bessel functions."
    about="Bessel functions solve x²y″ + xy′ + (x² − ν²)y = 0 and describe vibrating drums, heat in cylinders and wave propagation. Values come from their integral representations (DLMF 10.9 and 10.32) evaluated with adaptive Gauss–Kronrod quadrature, which stays accurate where power series cancel."
    :calc="['engine' => 'mt-alg2', 'tool' => 'special', 'fields' => ['kind', 'nu', 'x'], 'fn' => 'bessel']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is J₁(2.5)?', 'answer' => '0.4970941024643.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="kind" label="Kind" :options="['J' => 'J (first kind)', 'Y' => 'Y (second kind)', 'I' => 'I (modified, first)', 'K' => 'K (modified, second)']" selected="J" />
        <x-calc.field name="nu" label="Order ν" value="1" step="any" />
        <x-calc.field name="x" label="x" value="2.5" step="any" />
    </div>

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'J', 'nu' => 1, 'x' => 2.5],
        'Y0' => ['kind' => 'Y', 'nu' => 0, 'x' => 1],
        'K half' => ['kind' => 'K', 'nu' => 0.5, 'x' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'kind' => ['label' => 'Kind'],
            'order' => ['label' => 'Order'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x²y″ + xy′ + (x² − ν²)y = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
