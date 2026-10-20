<x-calc.page
    title="Unit Circle Calculator - SolveKit"
    description="Free unit circle calculator: the point (cos θ, sin θ) for any angle, exact for standard angles, with all six functions."
    lede="Find a point on the unit circle."
    about="The unit circle has radius 1, so the point at angle θ is (cos θ, sin θ). Standard angles have exact coordinates: 120° gives (−1/2, √3/2). The quadrant decides the signs (All Students Take Calculus)."
    :calc="['engine' => 'mt-trig', 'tool' => 'unit_circle', 'fields' => ['angle', 'angle_unit']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Where is 120° on the unit circle?', 'answer' => '(−1/2, √3/2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="120" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Point (cos θ, sin θ)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 120, 'angle_unit' => 'deg'],
        'Radians' => ['angle' => 1.25, 'angle_unit' => 'pi'],
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
            'point' => ['label' => 'Point'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(cos θ, sin θ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
