<x-calc.page
    title="Powers of i Calculator - SolveKit"
    description="Free powers of i calculator: iⁿ for any whole number n, using the four-step cycle."
    lede="Calculate iⁿ."
    about="The powers of i repeat every four: i⁰ = 1, i¹ = i, i² = −1, i³ = −i. So iⁿ depends only on n mod 4: i^2026 = i² = −1. Negative powers work too: i⁻¹ = −i. Also known as i calculator."
    :calc="['engine' => 'mt-number', 'tool' => 'powers_i', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is i^2026?', 'answer' => '−1.'],
    ]"
>
    <x-calc.field name="n" label="Power n" value="2026" type="text" inputmode="decimal" />

    <x-calc.result label="iⁿ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '2026'],
        'Negative' => ['n' => '-3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cycle' => ['label' => 'Cycle'],
            'remainder' => ['label' => 'n mod 4'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>iⁿ = i^(n mod 4)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
