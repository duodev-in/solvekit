<x-calc.page
    title="Cofunction Calculator - SolveKit"
    description="Free cofunction calculator: sin θ = cos(90° − θ), tan θ = cot(90° − θ), sec θ = csc(90° − θ)."
    lede="Apply the cofunction identities."
    about="The two acute angles of a right triangle are complementary, so the sine of one is the cosine of the other. The same pairing links tangent with cotangent and secant with cosecant."
    :calc="['engine' => 'mt-trig', 'tool' => 'cofunction', 'fields' => ['angle', 'angle_unit']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Which cosine equals sin 20°?', 'answer' => 'sin 20° = cos 70°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="20" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="Cofunction identities" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 20, 'angle_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sin' => ['label' => 'sin'],
            'cos' => ['label' => 'cos'],
            'tan' => ['label' => 'tan'],
            'cot' => ['label' => 'cot'],
            'sec' => ['label' => 'sec'],
            'csc' => ['label' => 'csc'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin θ = cos(90° − θ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
