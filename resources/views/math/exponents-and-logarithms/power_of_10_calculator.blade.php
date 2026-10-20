<x-calc.page
    title="Power of 10 Calculator - SolveKit"
    description="Free power of 10 calculator: 10ⁿ for any whole or negative n, with its name and scientific notation."
    lede="Raise 10 to a power."
    about="Powers of ten move the decimal point: 10³ = 1,000, 10⁻³ = 0.001. They are the basis of scientific notation and of SI prefixes (kilo = 10³, micro = 10⁻⁶)."
    :calc="['engine' => 'mt-explog', 'tool' => 'power', 'fields' => ['solve', 'base', 'exp', 'result']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 10⁶?', 'answer' => '1,000,000.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['result' => 'The result aⁿ', 'exp' => 'The exponent n', 'base' => 'The base a']" selected="result" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:result,exp">
            <x-calc.field name="base" label="Base a" value="10" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:result,base">
            <x-calc.field name="exp" label="Exponent n" value="6" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:exp,base" hidden>
            <x-calc.field name="result" label="Result" value="1024" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'result', 'base' => '10', 'exp' => '6', 'result' => '1024'],
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
