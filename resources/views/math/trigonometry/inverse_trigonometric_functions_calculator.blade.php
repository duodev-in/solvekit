<x-calc.page
    title="Inverse Trigonometric Functions Calculator - SolveKit"
    description="Free inverse trig calculator: arcsin, arccos, arctan, arccsc, arcsec and arccot with principal values and general solutions."
    lede="Evaluate any inverse trig function."
    about="Inverse trig functions return angles. Each has a principal range so that the answer is unique: arcsin in [−90°, 90°], arccos in [0°, 180°], arctan in (−90°, 90°). All other solutions differ by whole turns (or half turns for tangent)."
    :calc="['engine' => 'mt-trig', 'tool' => 'inverse', 'fields' => ['fn', 'x']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is arcsin(1/2)?', 'answer' => '30° = π/6.'],
        ['question' => 'And arcsec(2)?', 'answer' => '60° = π/3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fn" label="Function" :options="['asin' => 'arcsin', 'acos' => 'arccos', 'atan' => 'arctan', 'acsc' => 'arccsc', 'asec' => 'arcsec', 'acot' => 'arccot']" selected="asin" />
        <x-calc.field name="x" label="Value x" value="1/2" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fn' => 'asin', 'x' => '1/2'],
        'Sec' => ['fn' => 'asec', 'x' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'degrees' => ['label' => 'Degrees'],
            'radians' => ['label' => 'Radians'],
            'check' => ['label' => 'Check'],
            'general' => ['label' => 'All solutions'],
            'range' => ['label' => 'Principal range'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = f⁻¹(x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
