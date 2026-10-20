<x-calc.page
    title="Order of Magnitude Calculator - SolveKit"
    description="Free order of magnitude calculator: the power of ten of a number and its nearest power of ten."
    lede="Find the order of magnitude."
    about="The order of magnitude is the exponent of 10 in scientific notation: 4,700 = 4.7 × 10³ has order 3. Rounded to the nearest power of ten (switching at √10 ≈ 3.16), it is 10⁴."
    :calc="['engine' => 'mt-number', 'tool' => 'order_magnitude', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the order of magnitude of 4,700?', 'answer' => '3.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="4700" type="text" inputmode="decimal" />

    <x-calc.result label="Order of magnitude" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '4700'],
        'Small' => ['x' => '0.0003'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'scientific' => ['label' => 'Scientific notation'],
            'nearest' => ['label' => 'Nearest power of ten'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>⌊log₁₀|x|⌋</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
