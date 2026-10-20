<x-calc.page
    title="Trig Identities Calculator - SolveKit"
    description="Free trig identities calculator: check whether a trigonometric equation is an identity by testing it at many angles, with the standard identities listed."
    lede="Check a trig identity."
    about="Type an equation in x (or a and b). It is evaluated at 24 unrelated angles: if both sides agree everywhere to 12 digits it is almost certainly an identity; one mismatch proves it is not. This is a numerical check, not a symbolic proof."
    :calc="['engine' => 'mt-trig', 'tool' => 'identity', 'fields' => ['identity', 'angle_mode']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is sin²x + cos²x = 1 an identity?', 'answer' => 'Identity holds.'],
        ['question' => 'Is sin 2x = 2 sin x?', 'answer' => 'Not an identity.'],
    ]"
>
    <x-calc.field name="identity" label="Identity to check" value="sin(x)^2 + cos(x)^2 = 1" type="text" inputmode="text" />

    <x-calc.select name="angle_mode" label="Angles in" :options="['rad' => 'Radians', 'deg' => 'Degrees']" selected="rad" />

    <x-calc.result label="Check" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['identity' => 'sin(x)^2 + cos(x)^2 = 1', 'angle_mode' => 'rad'],
        'False' => ['identity' => 'sin(2x) = 2sin(x)', 'angle_mode' => 'rad'],
        'Two angles' => ['identity' => 'cos(a - b) = cos(a)cos(b) + sin(a)sin(b)', 'angle_mode' => 'rad'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tested' => ['label' => 'Values tested'],
            'worst' => ['label' => 'Largest difference'],
            'pythagorean' => ['label' => 'Pythagorean identities'],
            'angles' => ['label' => 'Angle formulas'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin²x + cos²x = 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
