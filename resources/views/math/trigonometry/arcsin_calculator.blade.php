<x-calc.page
    title="Arcsin Calculator (Inverse Sine) - SolveKit"
    description="Free arcsin calculator: sin⁻¹(x) in degrees and radians with the exact angle for standard values and every solution."
    lede="Find the inverse sine."
    about="arcsin(x) is the angle whose sine is x, taken in the principal range. It accepts between −1 and 1. Exact values such as √3/2 give exact angles; the general solution lists every angle with that sine. Also known as inverse sine calculator and sin-1 calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'inverse', 'fields' => ['x'], 'fn' => 'asin']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin⁻¹(√3/2)?', 'answer' => '60° = π/3.'],
    ]"
>
    <x-calc.field name="x" label="Value x" value="√3/2" type="text" inputmode="text" />

    <x-calc.result label="sin⁻¹(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '√3/2'],
        'Decimal' => ['x' => '0.3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'degrees' => ['label' => 'Degrees'],
            'radians' => ['label' => 'Radians'],
            'check' => ['label' => 'Check'],
            'general' => ['label' => 'All solutions'],
            'range' => ['label' => 'Principal range'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = sin⁻¹(x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
