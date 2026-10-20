<x-calc.page
    title="Exact Value of Trig Functions Calculator - SolveKit"
    description="Free exact trig values calculator: exact sin, cos, tan, csc, sec and cot for multiples of 15°, 18° and 22.5°."
    lede="Find exact trig values."
    about="Many angles have exact trig values in roots: sin 15° = (√6 − √2)/4, cos 36° = (√5 + 1)/4, tan 22.5° = √2 − 1. The reference angle and quadrant sign give the value at any coterminal angle."
    :calc="['engine' => 'mt-trig', 'tool' => 'unit_circle', 'fields' => ['angle', 'angle_unit'], 'want' => 'exact']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the exact values at 210°?', 'answer' => 'sin = −1/2, cos = −√3/2.'],
        ['question' => 'And sin 18°?', 'answer' => '(√5 − 1)/4 ≈ 0.309016994375.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="210" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Exact values" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 210, 'angle_unit' => 'deg'],
        'Golden' => ['angle' => 18, 'angle_unit' => 'deg'],
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
            <li>reference angle and sign</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
