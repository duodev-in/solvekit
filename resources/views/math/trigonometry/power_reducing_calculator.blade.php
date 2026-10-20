<x-calc.page
    title="Power Reducing Calculator - SolveKit"
    description="Free power reducing calculator: sin²θ, cos²θ and tan²θ rewritten with cos 2θ, plus fourth powers."
    lede="Apply the power-reducing formulas."
    about="sin²θ = (1 − cos 2θ)/2 and cos²θ = (1 + cos 2θ)/2 remove squares, which is how ∫sin²x dx is done. With θ = 30°: sin²θ = (1 − 1/2)/2 = 1/4."
    :calc="['engine' => 'mt-trig', 'tool' => 'power_reduce', 'fields' => ['angle', 'angle_unit']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin²30° by the power-reducing formula?', 'answer' => '0.25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="30" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="sin²θ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 30, 'angle_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sin2' => ['label' => 'sin²θ'],
            'cos2' => ['label' => 'cos²θ'],
            'tan2' => ['label' => 'tan²θ'],
            'sin4' => ['label' => 'Fourth powers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin²θ = (1 − cos 2θ) ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
