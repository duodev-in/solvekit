<x-calc.page
    title="Tangent Calculator - SolveKit"
    description="Free tangent calculator: tan θ = sin θ ÷ cos θ, exact for standard angles and undefined at 90° + 180°k."
    lede="Find the tangent of an angle."
    about="tan θ = opposite ÷ adjacent = sin θ ÷ cos θ, the slope of the line at angle θ. tan 60° = √3; tan 90° is undefined. Also known as tangent ratio calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'trig_fn', 'fields' => ['angle', 'angle_unit'], 'fn' => 'tan']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is tan 60°?', 'answer' => '√3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle θ" value="60" step="any" />
        <x-calc.select name="angle_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />
    </div>

    <x-calc.result label="tan(θ)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['angle' => 60, 'angle_unit' => 'deg'],
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
            <li>tan θ = sin θ ÷ cos θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
