<x-calc.page
    title="Normal Approximation Calculator - SolveKit"
    description="Free normal approximation calculator: approximate binomial or Poisson probabilities with the continuity correction, compared with the exact value."
    lede="Approximate with the normal curve."
    about="For large n the binomial and Poisson distributions look normal, so their probabilities can be approximated by areas under a normal curve."
    :calc="['engine' => 'st-inf', 'tool' => 'normal_approx', 'fields' => ['dist', 'n', 'p', 'lambda', 'mode', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does the approximation give in the example?', 'answer' => '0.859956 (exact 0.85944).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Distribution" :options="['binomial' => 'Binomial (n, p)', 'poisson' => 'Poisson (λ)']" selected="binomial" />
        <div data-show-when="dist:binomial">
            <x-calc.field name="n" label="Trials n" value="50" min="1" step="any" />
        </div>
        <div data-show-when="dist:binomial">
            <x-calc.field name="p" label="Probability p" value="0.3" min="0" step="any" />
        </div>
        <div data-show-when="dist:poisson">
            <x-calc.field name="lambda" label="Rate λ" value="20" min="0" step="any" />
        </div>
        <x-calc.select name="mode" label="Find" :options="['le' => 'P(X ≤ k)', 'ge' => 'P(X ≥ k)', 'eq' => 'P(X = k)']" selected="le" />
        <x-calc.field name="k" label="k" value="18" step="any" />
    </div>

    <x-calc.result label="Normal approximation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dist' => 'binomial', 'n' => 50, 'p' => 0.3, 'lambda' => 20, 'mode' => 'le', 'k' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact probability'],
            'error' => ['label' => 'Approximation error'],
            'params' => ['label' => 'μ and σ used'],
            'ok' => ['label' => 'Conditions'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
