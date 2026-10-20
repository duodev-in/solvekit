<x-calc.page
    title="Double Angle Formula Calculator - SolveKit"
    description="Free double angle calculator: sin 2θ, cos 2θ and tan 2θ from θ with the formulas and exact values."
    lede="Apply the double angle formulas."
    about="sin 2θ = 2 sin θ cos θ, cos 2θ = cos²θ − sin²θ = 2cos²θ − 1 = 1 − 2sin²θ and tan 2θ = 2 tan θ/(1 − tan²θ). With θ = 22.5°, sin 2θ = sin 45° = √2/2. Also known as double angle calculator and double angle identities calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'double', 'fields' => ['angle', 'angle_unit'], 'want' => 'sin']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin 2θ when θ = 22.5°?', 'answer' => '√2/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="22.5" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="sin 2θ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 22.5, 'angle_unit' => 'deg'],
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
