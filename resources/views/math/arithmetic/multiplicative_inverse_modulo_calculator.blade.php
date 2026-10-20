<x-calc.page
    title="Multiplicative Inverse Modulo Calculator - SolveKit"
    description="Free multiplicative inverse modulo calculator: x with a·x ≡ 1 (mod m), used in RSA and modular division."
    lede="Find the multiplicative inverse mod m."
    about="Dividing by a modulo m means multiplying by its multiplicative inverse. In RSA the private exponent d is the inverse of e modulo φ(n): 17⁻¹ mod 3120 = 2753."
    :calc="['engine' => 'mt-number', 'tool' => 'mod_inverse', 'fields' => ['a', 'm']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 17⁻¹ mod 3120?', 'answer' => '2,753.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Number a" value="17" type="text" inputmode="decimal" />
        <x-calc.field name="m" label="Modulus m" value="3120" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Inverse" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '17', 'm' => '3120'],
        'Small' => ['a' => '7', 'm' => '26'],
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
