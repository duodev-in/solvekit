<x-calc.page
    title="Change of Base Formula Calculator - SolveKit"
    description="Free change of base formula calculator: log_b(x) = log_c(x) ÷ log_c(b), with each step."
    lede="Use the change of base formula."
    about="Calculators usually have only log (base 10) and ln (base e). The change of base formula log_b(x) = log_c(x) ÷ log_c(b) gives any base: log₇(50) = log 50 ÷ log 7 ≈ 2.0104."
    :calc="['engine' => 'mt-explog', 'tool' => 'change_base', 'fields' => ['x', 'b', 'c']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is log₇(50)?', 'answer' => '2.010382137802.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="x" label="Number x" value="50" step="any" />
        <x-calc.field name="b" label="Base b" value="7" step="any" />
        <x-calc.select name="c" label="Using base c" :options="['10' => '10', 'e' => 'e', '2' => '2']" selected="10" />
    </div>

    <x-calc.result label="log_b(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 50, 'b' => 7, 'c' => '10'],
        'Natural' => ['x' => 100, 'b' => 3, 'c' => 'e'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'top' => ['label' => 'log_c(x)'],
            'bottom' => ['label' => 'log_c(b)'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>log_b(x) = log_c(x) ÷ log_c(b)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
