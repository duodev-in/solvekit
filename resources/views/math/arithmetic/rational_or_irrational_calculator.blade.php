<x-calc.page
    title="Rational or Irrational Calculator - SolveKit"
    description="Free rational or irrational calculator: decide whether a number, fraction, decimal or root is rational, with the reason."
    lede="Is it rational?"
    about="A rational number can be written as p/q with whole numbers p and q ≠ 0; its decimal terminates or repeats. √2, π and e are irrational. Roots of whole numbers are rational only when the number is a perfect power."
    :calc="['engine' => 'mt-number', 'tool' => 'rational', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is √18/√2 rational?', 'answer' => 'Rational: The roots cancel: it equals 3 (checked to 13 significant digits).'],
        ['question' => 'Is √2 rational?', 'answer' => 'Irrational.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="sqrt(18)/sqrt(2)" type="text" help="Fractions, repeating decimals 0.(3), roots, π" inputmode="text" />

    <x-calc.result label="Rational or irrational" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 'sqrt(18)/sqrt(2)'],
        'Root two' => ['x' => 'sqrt(2)'],
        'Repeating' => ['x' => '0.(142857)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'definition' => ['label' => 'Definition'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p/q with q ≠ 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
