<x-calc.page
    title="Error Function Calculator - SolveKit"
    description="Free error function calculator: erf(x), erfc(x) and the inverse error function, accurate to 15 digits."
    lede="Evaluate the error function."
    about="erf(x) = (2/√π)∫₀ˣ e^(−t²) dt. It gives normal probabilities: P(|Z| < z) = erf(z/√2). erfc = 1 − erf is computed directly for large x so tiny tails stay accurate."
    :calc="['engine' => 'mt-alg2', 'tool' => 'special', 'fields' => ['x'], 'fn' => 'erf']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is erf(1)?', 'answer' => '0.84270079294971.'],
    ]"
>
    <x-calc.field name="x" label="x" value="1" step="any" />

    <x-calc.result label="erf(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 1],
        'Tail' => ['x' => 4],
        'Inverse' => ['x' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph of erf" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'erfc' => ['label' => 'erfc(x)'],
            'inverse' => ['label' => 'Inverse'],
            'normal' => ['label' => 'Normal distribution'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>erf x = (2/√π)∫₀ˣ e^(−t²) dt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
