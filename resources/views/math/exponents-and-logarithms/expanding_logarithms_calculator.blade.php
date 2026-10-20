<x-calc.page
    title="Expanding Logarithms Calculator - SolveKit"
    description="Free expanding logarithms calculator: expand log(x²y/z³) into a sum of simple logs with the product, quotient and power rules."
    lede="Expand a logarithm."
    about="Three rules expand a logarithm: log(ab) = log a + log b, log(a/b) = log a − log b and log(aⁿ) = n log a. log(x²√y/z³) = 2 log x + ½ log y − 3 log z. Roots are powers: √y = y^(1/2)."
    :calc="['engine' => 'mt-explog', 'tool' => 'expand_log', 'fields' => ['expr', 'base']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Expand log(x²√y/z³).', 'answer' => '2log x + (1/2)log y − 3log z.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expr" label="Argument of the log" value="x^2 sqrt(y) / z^3" type="text" inputmode="text" />
        <x-calc.field name="base" label="Base" value="10" type="text" help="10, e, 2 or any number" inputmode="decimal" />
    </div>

    <x-calc.result label="Expanded" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => 'x^2 sqrt(y) / z^3', 'base' => '10'],
        'Natural' => ['expr' => '(a b)^3 / c', 'base' => 'e'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'terms' => ['label' => 'Terms'],
            'rules' => ['label' => 'Rules used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>log(ab) = log a + log b</li>
            <li>log(a/b) = log a − log b</li>
            <li>log(aⁿ) = n log a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
