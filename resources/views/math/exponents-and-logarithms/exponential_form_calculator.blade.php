<x-calc.page
    title="Exponential Form Calculator - SolveKit"
    description="Free exponential form calculator: rewrite a logarithm as an exponential equation and back."
    lede="Convert between log and exponential form."
    about="log_b(x) = y and bʸ = x say the same thing: log₂(8) = 3 means 2³ = 8. Rewriting in exponential form is often the first step when solving a log equation."
    :calc="['engine' => 'mt-explog', 'tool' => 'exp_form', 'fields' => ['b', 'x', 'y']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Write log₂(8) = 3 in exponential form.', 'answer' => '2³ = 8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="b" label="Base b" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="x" label="Number x" value="8" type="text" inputmode="decimal" />
        <x-calc.field name="y" label="Exponent y" value="3" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Exponential form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['b' => '2', 'x' => '8', 'y' => '3'],
        'Fraction' => ['b' => '9', 'x' => '3', 'y' => '1/2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'log' => ['label' => 'Logarithmic form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>log_b(x) = y ⇔ bʸ = x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
