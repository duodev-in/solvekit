<x-calc.page
    title="Prime Number Calculator - SolveKit"
    description="Free prime number calculator: test whether a number is prime, with the next and previous primes and the smallest factor."
    lede="Check if a number is prime."
    about="A prime has exactly two factors, 1 and itself. The test used is the deterministic Miller–Rabin test, exact for every number below 3.3 × 10²⁴ and with negligible error above. 1 is neither prime nor composite."
    :calc="['engine' => 'mt-number', 'tool' => 'prime', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 97 prime?', 'answer' => 'Prime.'],
        ['question' => 'Is 2³¹ − 1 prime?', 'answer' => 'Prime.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="97" type="text" inputmode="decimal" />

    <x-calc.result label="Prime or composite" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '97'],
        'Composite' => ['n' => '221'],
        'Mersenne' => ['n' => '2147483647'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'next' => ['label' => 'Next prime'],
            'previous' => ['label' => 'Previous prime'],
            'factor' => ['label' => 'Smallest factor'],
            'test' => ['label' => 'Test'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Miller–Rabin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
