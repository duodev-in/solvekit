<x-calc.page
    title="Modulo Calculator - SolveKit"
    description="Free modulo calculator: a mod n for positive and negative numbers, with the quotient and both remainder conventions."
    lede="Calculate a mod n."
    about="a mod n is the remainder after dividing a by n. For negative numbers the conventions differ: mathematics (and Python) use the floored remainder (−7 mod 3 = 2), while C and JavaScript give the truncated remainder (−1). Modular addition and multiplication can be reduced at any step, which is why modulo is associative and distributive in the same way as ordinary arithmetic."
    :calc="['engine' => 'mt-number', 'tool' => 'modulo', 'fields' => ['a', 'm'], 'kind' => 'mod']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is −7 mod 3?', 'answer' => '2.'],
        ['question' => 'How do negative numbers work with modulo?', 'answer' => 'Floored modulo gives a remainder with the sign of the divisor: −7 = −3 × 3 + 2. Truncated division gives −7 = −2 × 3 − 1.'],
        ['question' => 'Where does modulo come in the order of operations?', 'answer' => 'Most programming languages give % the same rank as × and ÷, evaluated left to right.'],
        ['question' => 'Is modulo arithmetic associative and distributive?', 'answer' => '(a + b) mod n = ((a mod n) + (b mod n)) mod n, and the same for ×, so modular addition and multiplication are associative, commutative and distributive.'],
        ['question' => 'What is modulo used for?', 'answer' => 'Clocks (14:00 is 2 pm), days of the week, check digits, hashing, cryptography and alternating patterns (n mod 2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Number a" value="-7" type="text" inputmode="decimal" />
        <x-calc.field name="m" label="Modulus n" value="3" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="a mod n" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '-7', 'm' => '3'],
        'Positive' => ['a' => '2026', 'm' => '7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'quotient' => ['label' => 'Quotient (floored)'],
            'remainder' => ['label' => 'Remainder'],
            'truncated' => ['label' => 'Truncated remainder'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a mod n = a − n⌊a/n⌋</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
