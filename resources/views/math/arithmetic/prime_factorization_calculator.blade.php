<x-calc.page
    title="Prime Factorization Calculator - SolveKit"
    description="Free prime factorization calculator: break any whole number (up to 40 digits) into primes, with the factor tree."
    lede="Factor a number into primes."
    about="Every whole number above 1 is a unique product of primes (the fundamental theorem of arithmetic). Small factors are found by trial division and large ones by Pollard's rho method, with each prime checked by the Miller–Rabin test."
    :calc="['engine' => 'mt-number', 'tool' => 'prime_factors', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the prime factorisation of 5040?', 'answer' => '2⁴ × 3² × 5 × 7.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="5040" type="text" inputmode="decimal" />

    <x-calc.result label="Prime factorisation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '5040'],
        'Large' => ['n' => '600851475143'],
        'Semiprime' => ['n' => '1000000016000000063'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'list' => ['label' => 'As a product'],
            'distinct' => ['label' => 'Distinct primes'],
            'count' => ['label' => 'Number of divisors'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = p₁^e₁ × p₂^e₂ × …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
