<x-calc.page
    title="Power of 2 Calculator - SolveKit"
    description="Free power of 2 calculator: 2ⁿ exactly, even for large n such as 2¹⁰⁰."
    lede="Raise 2 to a power."
    about="Powers of two double each time: 2¹⁰ = 1,024, 2³² = 4,294,967,296 and 2⁶⁴ = 18,446,744,073,709,551,616. They count binary values: n bits hold 2ⁿ patterns."
    :calc="['engine' => 'mt-explog', 'tool' => 'power', 'fields' => ['solve', 'base', 'exp', 'result']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 2³²?', 'answer' => '4,294,967,296.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['result' => 'The result aⁿ', 'exp' => 'The exponent n', 'base' => 'The base a']" selected="result" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:result,exp">
            <x-calc.field name="base" label="Base a" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:result,base">
            <x-calc.field name="exp" label="Exponent n" value="32" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="solve:exp,base" hidden>
            <x-calc.field name="result" label="Result" value="1024" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'result', 'base' => '2', 'exp' => '32', 'result' => '1024'],
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
