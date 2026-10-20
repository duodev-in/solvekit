<x-calc.page
    title="Cosine Calculator - SolveKit"
    description="Free cosine calculator: cos θ in degrees, radians or multiples of π, exact for standard angles."
    lede="Find the cosine of an angle."
    about="cos θ = adjacent ÷ hypotenuse, the x-coordinate on the unit circle. cos 60° = 1/2, cos 135° = −√2/2."
    :calc="['engine' => 'mt-trig', 'tool' => 'trig_fn', 'fields' => ['angle', 'angle_unit'], 'fn' => 'cos']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is cos 135°?', 'answer' => '−√2/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="135" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="cos(θ)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 135, 'angle_unit' => 'deg'],
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
            <li>cos θ = adjacent ÷ hypotenuse</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
