<x-calc.page
    title="Sin 2 Theta Calculator - SolveKit"
    description="Free sin 2θ calculator: sin 2θ = 2 sin θ cos θ, exact for standard angles."
    lede="Find sin 2θ."
    about="sin 2θ = 2 sin θ cos θ. With θ = 15°, 2 × (√6 − √2)/4 × (√6 + √2)/4 = 1/2 = sin 30°."
    :calc="['engine' => 'mt-trig', 'tool' => 'double', 'fields' => ['angle', 'angle_unit'], 'want' => 'sin']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin 2θ for θ = 15°?', 'answer' => '1/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="15" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="sin 2θ" />

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
            <li>sin 2θ = 2 sin θ cos θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
