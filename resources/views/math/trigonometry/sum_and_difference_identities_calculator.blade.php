<x-calc.page
    title="Sum and Difference Identities Calculator - SolveKit"
    description="Free sum and difference identities calculator: sin(α ± β), cos(α ± β) and tan(α ± β) with each term and exact values."
    lede="Apply the sum and difference formulas."
    about="sin(α ± β) = sin α cos β ± cos α sin β, cos(α ± β) = cos α cos β ∓ sin α sin β. They give exact values for angles such as 75° = 45° + 30°: sin 75° = (√6 + √2)/4."
    :calc="['engine' => 'mt-trig', 'tool' => 'sum_diff', 'fields' => ['alpha', 'beta', 'op', 'alpha_unit']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin(45° + 30°)?', 'answer' => '(√6 + √2)/4.'],
        ['question' => 'And sin 15° = sin(45° − 30°)?', 'answer' => '(√6 − √2)/4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="alpha" label="α" value="45" step="any" />
        <x-calc.field name="beta" label="β" value="30" step="any" />
        <x-calc.select name="op" label="Sum or difference" :options="['+' => 'α + β', '-' => 'α − β']" selected="+" />
    </div>

    <x-calc.select name="alpha_unit" label="Unit" :options="['deg' => 'Degrees', 'rad' => 'Radians', 'pi' => '× π radians']" selected="deg" />

    <x-calc.result label="sin(α ± β)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['alpha' => 45, 'beta' => 30, 'op' => '+', 'alpha_unit' => 'deg'],
        'Difference' => ['alpha' => 45, 'beta' => 30, 'op' => '-', 'alpha_unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sin' => ['label' => 'sin(α ± β)'],
            'cos' => ['label' => 'cos(α ± β)'],
            'tan' => ['label' => 'tan(α ± β)'],
            'parts' => ['label' => 'sin and cos of α and β'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin(α ± β) = sin α cos β ± cos α sin β</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
