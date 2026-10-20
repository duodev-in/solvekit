<x-calc.page
    title="Cosecant Calculator - SolveKit"
    description="Free cosecant calculator: csc θ = 1 ÷ sin θ, exact for standard angles."
    lede="Find the cosecant."
    about="The cosecant is the reciprocal of the sine: csc 30° = 2. It is undefined where sin θ = 0 (0°, 180°, …)."
    :calc="['engine' => 'mt-trig', 'tool' => 'trig_fn', 'fields' => ['angle', 'angle_unit'], 'fn' => 'csc']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is csc 30°?', 'answer' => '2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="30" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="csc(θ)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 30, 'angle_unit' => 'deg'],
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
            <li>csc θ = 1 ÷ sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
