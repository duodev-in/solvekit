<x-calc.page
    title="Half Angle Calculator - SolveKit"
    description="Free half angle calculator: sin(θ/2), cos(θ/2) and tan(θ/2) with the signs fixed by the quadrant of θ/2."
    lede="Apply the half angle formulas."
    about="sin(θ/2) = ±√((1 − cos θ)/2) and cos(θ/2) = ±√((1 + cos θ)/2), with the sign set by the quadrant of θ/2; tan(θ/2) = sin θ/(1 + cos θ) needs no sign choice. With θ = 60°: sin 30° = 1/2."
    :calc="['engine' => 'mt-trig', 'tool' => 'half', 'fields' => ['angle', 'angle_unit']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin(θ/2) for θ = 60°?', 'answer' => '1/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="60" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="sin(θ/2)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 60, 'angle_unit' => 'deg'],
        '45°' => ['angle' => 45, 'angle_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sin' => ['label' => 'sin(θ/2)'],
            'cos' => ['label' => 'cos(θ/2)'],
            'tan' => ['label' => 'tan(θ/2)'],
            'given' => ['label' => 'From θ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin(θ/2) = ±√((1 − cos θ)/2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
