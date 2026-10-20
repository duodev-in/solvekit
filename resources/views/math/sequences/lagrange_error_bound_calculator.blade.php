<x-calc.page
    title="Lagrange Error Bound Calculator - SolveKit"
    description="Free Lagrange error bound calculator: the maximum error of a Taylor polynomial, M|x − a|ⁿ⁺¹/(n + 1)!."
    lede="Bound a Taylor polynomial's error."
    about="If |f⁽ⁿ⁺¹⁾| ≤ M between a and x, the error of the degree-n Taylor polynomial is at most M|x − a|ⁿ⁺¹/(n + 1)!. For eˣ at x = 1 around 0 with n = 5 and M = e < 3, the error is below 3/720 ≈ 0.0042."
    :calc="['engine' => 'mt-seq', 'tool' => 'lagrange', 'fields' => ['m', 'n', 'a', 'x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How accurate is the 5th-degree Maclaurin polynomial of eˣ at x = 1?', 'answer' => 'The error is at most 0.004166666667.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="M (max of |f⁽ⁿ⁺¹⁾|)" value="3" step="any" />
        <x-calc.field name="n" label="Degree n" value="5" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Centre a" value="0" step="any" />
        <x-calc.field name="x" label="Point x" value="1" step="any" />
    </div>

    <x-calc.result label="Error bound" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m' => 3, 'n' => 5, 'a' => 0, 'x' => 1],
        'sin' => ['m' => 1, 'n' => 7, 'a' => 0, 'x' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'factorial' => ['label' => '(n + 1)!'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|Rₙ(x)| ≤ M|x − a|ⁿ⁺¹/(n + 1)!</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
