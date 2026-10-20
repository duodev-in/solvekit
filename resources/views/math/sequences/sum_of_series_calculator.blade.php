<x-calc.page
    title="Sum of Series Calculator - SolveKit"
    description="Free sum of series calculator: Σ f(n) from a start to an end (exact for finite sums) or to infinity with convergence tests."
    lede="Sum a series."
    about="Type the general term in n, such as 1/n^2 or (-1)^(n+1)/n. Finite sums are added exactly with fractions. For infinite series the calculator applies the divergence, ratio, p-series and alternating series tests and estimates the sum when it converges. Also known as summation calculator and sigma notation calculator."
    :calc="['engine' => 'mt-seq', 'tool' => 'series', 'fields' => ['term', 'start', 'end']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is Σ 1/n² from 1 to ∞?', 'answer' => '1.6449290681.'],
        ['question' => 'What is 1 + 2 + … + 10 squared terms, Σ n²?', 'answer' => '385.'],
    ]"
>
    <x-calc.field name="term" label="Term f(n)" value="1/n^2" type="text" inputmode="text" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="From n =" value="1" step="1" />
        <x-calc.field name="end" label="To (number or inf)" value="inf" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Sum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['term' => '1/n^2', 'start' => 1, 'end' => 'inf'],
        'Squares' => ['term' => 'n^2', 'start' => 1, 'end' => '10'],
        'Geometric' => ['term' => '(1/2)^n', 'start' => 0, 'end' => 'inf'],
        'Harmonic' => ['term' => '1/n', 'start' => 1, 'end' => 'inf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'partial' => ['label' => 'Partial sums'],
            'test' => ['label' => 'Convergence'],
            'terms' => ['label' => 'First terms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ f(n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
