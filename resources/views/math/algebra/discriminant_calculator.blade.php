<x-calc.page
    title="Discriminant Calculator - SolveKit"
    description="Free discriminant calculator: Δ = b² − 4ac of a quadratic and what it says about the roots."
    lede="Find the discriminant."
    about="The discriminant Δ = b² − 4ac of ax² + bx + c tells you the roots without solving: Δ > 0 two real roots (rational if Δ is a perfect square), Δ = 0 one repeated root, Δ < 0 two complex roots."
    :calc="['engine' => 'mt-algebra', 'tool' => 'quadratic', 'fields' => ['a', 'b', 'c'], 'mode' => 'disc']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the discriminant of x² − 2x − 1?', 'answer' => '8: Positive: two real roots.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="b" value="-2" type="text" inputmode="decimal" />
        <x-calc.field name="c" label="c" value="-1" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1', 'b' => '-2', 'c' => '-1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph of y = ax² + bx + c" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'disc' => ['label' => 'Discriminant'],
            'vertex' => ['label' => 'Vertex'],
            'nature' => ['label' => 'Nature of the roots'],
            'sum' => ['label' => 'Sum of roots'],
            'product' => ['label' => 'Product of roots'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = (−b ± √(b² − 4ac)) ÷ 2a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
