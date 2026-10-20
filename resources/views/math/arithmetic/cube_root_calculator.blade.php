<x-calc.page
    title="Cube Root Calculator - SolveKit"
    description="Free cube root calculator: ∛x for any real number, exactly for perfect cubes and simplified otherwise."
    lede="Find a cube root."
    about="The cube root of x is the number whose cube is x. Unlike square roots, negative numbers have real cube roots: ∛−27 = −3. Non-perfect cubes are simplified: ∛54 = 3∛2."
    :calc="['engine' => 'mt-number', 'tool' => 'roots', 'fields' => ['x'], 'index' => 3]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is ∛54?', 'answer' => '3.77976314968 (Exact form 3∛2).'],
    ]"
>
    <x-calc.field name="x" label="Number" value="54" type="text" inputmode="text" />

    <x-calc.result label="Cube root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '54'],
        'Negative' => ['x' => '-27'],
        'Perfect' => ['x' => '1728'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact form'],
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>∛x = x^(1/3)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
