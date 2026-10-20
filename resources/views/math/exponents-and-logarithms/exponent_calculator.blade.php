<x-calc.page
    title="Exponent Calculator - SolveKit"
    description="Free exponent calculator: aⁿ exactly for whole, negative and fractional exponents, or solve for the base or the exponent."
    lede="Raise a number to a power, or solve for the base or exponent."
    about="An exponent says how many times the base is multiplied by itself: 2⁵ = 32. A negative exponent means a reciprocal (2⁻³ = 1/8) and a fractional exponent a root (8^(2/3) = (∛8)² = 4). Large powers are exact: 2¹⁰⁰ has 31 digits. Also known as math power calculator, power function calculator and to the power of calculator."
    :calc="['engine' => 'mt-explog', 'tool' => 'power', 'fields' => ['solve', 'base', 'exp', 'result']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 2¹⁰?', 'answer' => '1,024.'],
        ['question' => 'What is 8^(2/3)?', 'answer' => '4.'],
        ['question' => 'What is 2⁻³?', 'answer' => '1/8 (0.125).'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['result' => 'The result aⁿ', 'exp' => 'The exponent n', 'base' => 'The base a']" selected="result" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:result,exp" hidden>
            <x-calc.field name="base" label="Base a" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:result,base" hidden>
            <x-calc.field name="exp" label="Exponent n" value="10" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:exp,base" hidden>
            <x-calc.field name="result" label="Result" value="1024" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'result', 'base' => '2', 'exp' => '10', 'result' => '1024'],
        'Fractional' => ['solve' => 'result', 'base' => '8', 'exp' => '2/3', 'result' => '4'],
        'Negative' => ['solve' => 'result', 'base' => '2', 'exp' => '-3', 'result' => '1'],
        'Solve exponent' => ['solve' => 'exp', 'base' => '3', 'exp' => '1', 'result' => '243'],
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
