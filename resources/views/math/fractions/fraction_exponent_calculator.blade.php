<x-calc.page
    title="Fraction Exponent Calculator - SolveKit"
    description="Free fraction exponent calculator: evaluate a number raised to a fractional (rational) exponent, exactly when possible, with the radical form."
    lede="Evaluate a fractional exponent."
    about="A fractional exponent is a root and a power: a^(m/n) = (ⁿ√a)^m. So 8^(2/3) = (∛8)² = 4 and 16^(−3/4) = 1/8. When the root is not exact the radical form and a decimal are shown. Also known as rational exponents calculator."
    :calc="['engine' => 'mt-frac', 'tool' => 'exponent', 'fields' => ['base', 'exp']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 8^(2/3)?', 'answer' => '4.'],
        ['question' => 'And 2^(1/2)?', 'answer' => '1.41421356237.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="base" label="Base" value="8" type="text" inputmode="text" />
        <x-calc.field name="exp" label="Exponent" value="2/3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => '8', 'exp' => '2/3'],
        'Negative exponent' => ['base' => '16', 'exp' => '-3/4'],
        'Irrational' => ['base' => '2', 'exp' => '1/2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'radical' => ['label' => 'Radical form'],
            'decimal' => ['label' => 'Decimal'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a^(m/n) = (ⁿ√a)^m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
