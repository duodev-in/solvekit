<x-calc.page
    title="Arccos Calculator (Inverse Cosine) - SolveKit"
    description="Free arccos calculator: cos⁻¹(x) in degrees and radians with the exact angle for standard values and every solution."
    lede="Find the inverse cosine."
    about="arccos(x) is the angle whose cosine is x, taken in the principal range. It accepts between −1 and 1. Exact values such as √3/2 give exact angles; the general solution lists every angle with that cosine. Also known as inverse cosine calculator, cos-1 calculator and cos inverse calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'inverse', 'fields' => ['x'], 'fn' => 'acos']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is cos⁻¹(−1/2)?', 'answer' => '120° = 2π/3.'],
    ]"
>
    <x-calc.field name="x" label="Value x" value="-1/2" type="text" inputmode="text" />

    <x-calc.result label="cos⁻¹(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '-1/2'],
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
            <li>θ = cos⁻¹(x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
