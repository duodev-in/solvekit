<x-calc.page
    title="Sine Calculator - SolveKit"
    description="Free sine calculator: sin θ in degrees, radians or multiples of π, exact for standard angles (sin 30° = 1/2, sin 45° = √2/2)."
    lede="Find the sine of an angle."
    about="In a right triangle sin θ = opposite ÷ hypotenuse; on the unit circle it is the y-coordinate. Exact values are given for multiples of 15°, 18° and 22.5° (for example sin 75° = (√6 + √2)/4); other angles are computed to 14 digits. Also known as sin degrees calculator, sine function calculator and sin theta calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'trig_fn', 'fields' => ['angle', 'angle_unit'], 'fn' => 'sin']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin 150°?', 'answer' => '1/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="150" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="sin(θ)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 150, 'angle_unit' => 'deg'],
        '75°' => ['angle' => 75, 'angle_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Unit circle" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'sin' => ['label' => 'sin'],
            'cos' => ['label' => 'cos'],
            'tan' => ['label' => 'tan'],
            'csc' => ['label' => 'csc'],
            'sec' => ['label' => 'sec'],
            'cot' => ['label' => 'cot'],
            'quadrant' => ['label' => 'Quadrant'],
            'reference' => ['label' => 'Reference angle'],
            'angle' => ['label' => 'Angle'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin θ = opposite ÷ hypotenuse</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
