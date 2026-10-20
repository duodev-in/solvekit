<x-calc.page
    title="Square Root Calculator - SolveKit"
    description="Free square root calculator: √x exactly for perfect squares and fractions, as a simplified radical otherwise, and the imaginary root of negatives."
    lede="Find a square root."
    about="The square root of x is the non-negative number whose square is x. √144 = 12; √50 = 5√2 ≈ 7.0711 (pull out the largest square factor); √(9/16) = 3/4; √−4 = 2i."
    :calc="['engine' => 'mt-number', 'tool' => 'roots', 'fields' => ['x'], 'index' => 2]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is √50?', 'answer' => '7.07106781187 (Exact form 5√2).'],
    ]"
>
    <x-calc.field name="x" label="Number" value="50" type="text" inputmode="text" />

    <x-calc.result label="Square root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '50'],
        'Perfect' => ['x' => '144'],
        'Fraction' => ['x' => '9/16'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact form'],
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>√x = x^(1/2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
