<x-calc.page
    title="RSA Calculator - SolveKit"
    description="Free RSA calculator: build a textbook RSA key pair from two primes, then encrypt and decrypt a number or short text (for learning only)."
    lede="Try RSA encryption."
    about="Pick primes p and q; n = pq and φ = (p − 1)(q − 1). The public exponent e must be coprime to φ, and the private d is its inverse mod φ. Encrypt with c = mᵉ mod n, decrypt with m = cᵈ mod n. With p = 61, q = 53, e = 17: d = 2,753, and 65 encrypts to 2,790."
    :calc="['engine' => 'mt-other', 'tool' => 'rsa', 'fields' => ['p', 'q', 'e', 'm']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'With p = 61, q = 53 and e = 17, what is d?', 'answer' => '(d, n) = (2,753, 3,233).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="p" label="Prime p" value="61" type="text" inputmode="numeric" />
        <x-calc.field name="q" label="Prime q" value="53" type="text" inputmode="numeric" />
        <x-calc.field name="e" label="Public exponent e" value="17" type="text" inputmode="numeric" />
    </div>

    <x-calc.field name="m" label="Message (a number below n, or short text)" value="65" type="text" inputmode="text" />

    <x-calc.result label="Ciphertext" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => '61', 'q' => '53', 'e' => '17', 'm' => '65'],
        'Text' => ['p' => '1009', 'q' => '1013', 'e' => '65537', 'm' => 'Hi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Modulus n'],
            'phi' => ['label' => 'φ(n)'],
            'public' => ['label' => 'Public key'],
            'private' => ['label' => 'Private key'],
            'cipher' => ['label' => 'Encryption'],
            'decrypted' => ['label' => 'Decryption'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c = mᵉ mod n</li>
            <li>m = cᵈ mod n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
