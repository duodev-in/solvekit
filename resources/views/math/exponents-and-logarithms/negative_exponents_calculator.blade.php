<x-calc.page
    title="Negative Exponents Calculator - SolveKit"
    description="Free negative exponents calculator: a⁻ⁿ = 1/aⁿ as an exact fraction and decimal."
    lede="Evaluate a negative exponent."
    about="A negative exponent means the reciprocal of the positive power: a⁻ⁿ = 1/aⁿ, so 5⁻² = 1/25 = 0.04. It never makes the answer negative; (2/3)⁻² = 9/4."
    :calc="['engine' => 'mt-explog', 'tool' => 'power', 'fields' => ['solve', 'base', 'exp', 'result']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 5⁻²?', 'answer' => '1/25 (0.04).'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['result' => 'The result aⁿ', 'exp' => 'The exponent n', 'base' => 'The base a']" selected="result" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:result,exp">
            <x-calc.field name="base" label="Base a" value="5" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:result,base">
            <x-calc.field name="exp" label="Exponent n" value="-2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:exp,base" hidden>
            <x-calc.field name="result" label="Result" value="1024" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'result', 'base' => '5', 'exp' => '-2', 'result' => '1024'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact value'],
            'decimal' => ['label' => 'Decimal'],
            'scientific' => ['label' => 'Scientific'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>aⁿ = a × a × … × a</li>
            <li>a⁻ⁿ = 1/aⁿ</li>
            <li>a^(m/n) = (ⁿ√a)ᵐ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
