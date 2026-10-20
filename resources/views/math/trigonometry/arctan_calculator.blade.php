<x-calc.page
    title="Arctan Calculator (Inverse Tangent) - SolveKit"
    description="Free arctan calculator: tan⁻¹(x) in degrees and radians with the exact angle for standard values and every solution."
    lede="Find the inverse tangent."
    about="arctan(x) is the angle whose tangent is x, taken in the principal range. It accepts any real number. Exact values such as √3/2 give exact angles; the general solution lists every angle with that tangent. Also known as arcus tangent calculator, inverse tangent calculator, tan-1 calculator and tan inverse calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'inverse', 'fields' => ['x'], 'fn' => 'atan']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is tan⁻¹(1)?', 'answer' => '45° = π/4.'],
    ]"
>
    <x-calc.field name="x" label="Value x" value="1" type="text" inputmode="text" />

    <x-calc.result label="tan⁻¹(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '1'],
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
            <li>θ = tan⁻¹(x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
