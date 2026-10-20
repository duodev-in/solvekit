<x-calc.page
    title="Cos 2 Theta Calculator - SolveKit"
    description="Free cos 2θ calculator: cos 2θ = cos²θ − sin²θ = 2cos²θ − 1 = 1 − 2sin²θ."
    lede="Find cos 2θ."
    about="Three equivalent forms: cos²θ − sin²θ, 2cos²θ − 1 and 1 − 2sin²θ. With θ = 15°, cos 2θ = cos 30° = √3/2."
    :calc="['engine' => 'mt-trig', 'tool' => 'double', 'fields' => ['angle', 'angle_unit'], 'want' => 'cos']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is cos 2θ for θ = 15°?', 'answer' => '√3/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="15" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="cos 2θ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 15, 'angle_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sin' => ['label' => 'sin 2θ'],
            'cos' => ['label' => 'cos 2θ'],
            'tan' => ['label' => 'tan 2θ'],
            'given' => ['label' => 'From θ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cos 2θ = 1 − 2sin²θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
