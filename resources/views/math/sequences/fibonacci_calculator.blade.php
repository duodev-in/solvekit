<x-calc.page
    title="Fibonacci Calculator - SolveKit"
    description="Free Fibonacci calculator: the n-th Fibonacci number exactly (even n = 10,000), the next term and the golden ratio."
    lede="Find a Fibonacci number."
    about="Each Fibonacci number is the sum of the previous two: 0, 1, 1, 2, 3, 5, 8, 13, … The ratio of consecutive terms tends to the golden ratio φ ≈ 1.618. The fast-doubling method gives huge terms exactly."
    :calc="['engine' => 'mt-seq', 'tool' => 'fibonacci', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 50th Fibonacci number?', 'answer' => '12,586,269,025.'],
    ]"
>
    <x-calc.field name="n" label="n" value="50" type="text" inputmode="decimal" />

    <x-calc.result label="Fₙ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '50'],
        'Large' => ['n' => '300'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'next' => ['label' => 'Fₙ₊₁'],
            'ratio' => ['label' => 'Fₙ₊₁ ÷ Fₙ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Fₙ = Fₙ₋₁ + Fₙ₋₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
