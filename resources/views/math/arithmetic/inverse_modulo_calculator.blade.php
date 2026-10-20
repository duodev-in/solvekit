<x-calc.page
    title="Inverse Modulo Calculator - SolveKit"
    description="Free inverse modulo calculator: the modular inverse a⁻¹ mod m by the extended Euclidean algorithm."
    lede="Find a modular inverse."
    about="The inverse of a modulo m is the number x with a × x ≡ 1 (mod m). It exists only when a and m are coprime and is found by the extended Euclidean algorithm: 3⁻¹ mod 11 = 4 because 3 × 4 = 12 ≡ 1."
    :calc="['engine' => 'mt-number', 'tool' => 'mod_inverse', 'fields' => ['a', 'm']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3⁻¹ mod 11?', 'answer' => '4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Number a" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="m" label="Modulus m" value="11" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Inverse" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3', 'm' => '11'],
        'None' => ['a' => '6', 'm' => '9'],
        'Large' => ['a' => '17', 'm' => '3120'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gcd' => ['label' => 'gcd(a, m)'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a·x ≡ 1 (mod m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
