<x-calc.page
    title="Fermat's Little Theorem Calculator - SolveKit"
    description="Free Fermat's little theorem calculator: check a^(p−1) ≡ 1 (mod p), find inverses and spot Fermat pseudoprimes."
    lede="Apply Fermat's little theorem."
    about="If p is prime and does not divide a, then a^(p−1) ≡ 1 (mod p). If the result is not 1, p is certainly composite. Some composites still pass for some bases (561 = 3 × 11 × 17 passes for every coprime base: a Carmichael number)."
    :calc="['engine' => 'mt-number', 'tool' => 'fermat', 'fields' => ['a', 'p']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 2¹² mod 13?', 'answer' => '2^12 ≡ 1 (mod 13).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Base a" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="p" label="Modulus p" value="13" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2', 'p' => '13'],
        'Carmichael' => ['a' => '2', 'p' => '561'],
        'Composite' => ['a' => '2', 'p' => '15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'prime' => ['label' => 'Is p prime'],
            'inverse' => ['label' => 'Inverse of a'],
            'theorem' => ['label' => 'Theorem'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a^(p−1) ≡ 1 (mod p)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
