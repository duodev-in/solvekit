<x-calc.page
    title="Check Digit Calculator - SolveKit"
    description="Free check digit calculator: UPC-A, EAN-13, EAN-8, ISBN-10, ISBN-13 and Luhn (credit card, IMEI) check digits, or verify a full number."
    lede="Calculate or verify a check digit."
    about="UPC and EAN (GTIN) weight digits 3 and 1 alternately from the right and take (10 − sum mod 10) mod 10. ISBN-10 weights 10 down to 2 and uses mod 11 (10 is written X). Luhn doubles every second digit from the right, subtracting 9 from results over 9. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'check_digit', 'fields' => ['type', 'code']]"
    :how-to="[
        ['name' => 'Choose the code type', 'text' => ''],
        ['name' => 'Enter the digits', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the check digit of EAN 400638133393?', 'answer' => '1.'],
        ['question' => 'Is ISBN 0306406152 valid?', 'answer' => 'Valid.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Code" :options="['ean13' => 'EAN-13 / GTIN-13', 'upc' => 'UPC-A', 'ean8' => 'EAN-8', 'isbn13' => 'ISBN-13', 'isbn10' => 'ISBN-10', 'luhn' => 'Luhn (cards, IMEI)']" selected="ean13" />
        <x-calc.field name="code" label="Number without the check digit (or with it, to verify)" value="400638133393" type="text" />
    </div>

    <x-calc.result label="Check digit" />

    <x-calc.options :decimals="false" :examples="[
        'EAN-13' => ['type' => 'ean13', 'code' => '400638133393'],
        'UPC' => ['type' => 'upc', 'code' => '03600029145'],
        'ISBN-10 verify' => ['type' => 'isbn10', 'code' => '0306406152'],
        'Luhn' => ['type' => 'luhn', 'code' => '7992739871'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'full' => ['label' => 'Full number'],
            'type' => ['label' => 'Code type'],
            'valid' => ['label' => 'Verification'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GTIN: (10 − Σ w d mod 10) mod 10, w = 3,1,…</li>
            <li>ISBN-10: Σ (10 − k) d mod 11</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
