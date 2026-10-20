<x-calc.page
    title="Chinese Remainder Theorem Calculator - SolveKit"
    description="Free Chinese remainder theorem calculator: solve a system of congruences x ≡ aᵢ (mod mᵢ), even when the moduli are not coprime."
    lede="Solve simultaneous congruences."
    about="The Chinese remainder theorem says congruences with pairwise coprime moduli have exactly one solution modulo their product. The classic puzzle x ≡ 2 (mod 3), x ≡ 3 (mod 5), x ≡ 2 (mod 7) gives x = 23 (mod 105)."
    :calc="['engine' => 'mt-number', 'tool' => 'crt', 'fields' => ['system']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Solve x ≡ 2 (mod 3), x ≡ 3 (mod 5), x ≡ 2 (mod 7).', 'answer' => 'x ≡ 23 (mod 105).'],
    ]"
>
    <x-calc.textarea name="system" label="Congruences (one per line: remainder mod modulus)" value="2 mod 3
3 mod 5
2 mod 7" rows="4" />

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['system' => '2 mod 3
3 mod 5
2 mod 7'],
        'Not coprime' => ['system' => '3 mod 4
1 mod 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'modulus' => ['label' => 'Combined modulus'],
            'smallest' => ['label' => 'Smallest solution'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x ≡ aᵢ (mod mᵢ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
