<x-calc.page
    title="Trigonometric Functions Calculator - SolveKit"
    description="Free trigonometric functions calculator: sin, cos, tan, csc, sec and cot of any angle at once, exact for standard angles."
    lede="Find all six trig functions."
    about="All six functions come from the point (cos θ, sin θ) on the unit circle; the quadrant gives the signs and the reference angle the size. Also known as sine cosine tangent calculator, trig degree calculator and trig function calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'trig_fn', 'fields' => ['angle', 'angle_unit'], 'fn' => 'all']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What are the trig functions of 225°?', 'answer' => 'sin −√2/2 ≈ −0.707106781187, cos −√2/2 ≈ −0.707106781187.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="225" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Trig functions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 225, 'angle_unit' => 'deg'],
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
            <li>sin, cos, tan, csc, sec, cot</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
