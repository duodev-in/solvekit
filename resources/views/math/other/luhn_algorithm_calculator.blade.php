<x-calc.page
    title="Luhn Algorithm Calculator - SolveKit"
    description="Free Luhn algorithm calculator: check credit card and ID numbers with the mod 10 checksum, or compute the check digit."
    lede="Validate a number with Luhn."
    about="The Luhn (mod 10) check catches any single mistyped digit and most swaps of neighbours. From the right, double every second digit (subtracting 9 if it exceeds 9), add everything, and the total must end in 0. It is not a security feature, only a typo check. Also known as mod 10 check calculator."
    :calc="['engine' => 'mt-other', 'tool' => 'luhn', 'fields' => ['number'], 'want' => 'check']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 4539 1488 0343 6467 valid?', 'answer' => 'Valid.'],
        ['question' => 'What check digit completes 7992739871?', 'answer' => '3 (to append to 7992739871).'],
    ]"
>
    <x-calc.field name="number" label="Number" value="4539 1488 0343 6467" type="text" inputmode="text" />

    <x-calc.result label="Luhn check" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['number' => '4539 1488 0343 6467'],
        'Append' => ['number' => '7992739871'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Sum'],
            'checkDigit' => ['label' => 'Check digit'],
            'doubled' => ['label' => 'Doubled digits'],
            'valid' => ['label' => 'Valid?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ (doubled digits) ≡ 0 mod 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
