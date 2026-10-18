<x-calc.page
    title="Palindrome Date Finder - SolveKit"
    description="Free palindrome date finder: dates that read the same forwards and backwards in MM/DD/YYYY, DD/MM/YYYY, YYYY-MM-DD and short formats."
    lede="Find dates that read the same forwards and backwards."
    about="A date is a palindrome when its digits, written in a given format without separators, read the same both ways: 12/02/2021 is 12022021. The answer depends on the format, so the same day can be a palindrome in the US but not in Europe. Every date in the years you choose is checked."
    :calc="['engine' => 'ev-time', 'tool' => 'palindrome', 'fields' => ['from', 'to', 'format']]"
    :how-to="[
        ['name' => 'Pick the years', 'text' => 'Up to 2,000 years at a time.'],
        ['name' => 'Pick the format', 'text' => 'The way you write dates.'],
    ]"
    :faqs="[
        ['question' => 'When is the next palindrome date?', 'answer' => '03/02/2030: 2 March 2030 in the US format and 3 February 2030 in the day-first format.'],
        ['question' => 'Was 12/02/2021 a palindrome?', 'answer' => 'Yes, 12022021 reads the same both ways: 2 December 2021 in the US and 12 February 2021 in day-first countries.'],
        ['question' => 'How many palindrome dates are there this century?', 'answer' => '12 in MM/DD/YYYY and 29 in DD/MM/YYYY from 2000 to 2100.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="from" label="From year" value="2000" min="1" max="9999" step="1" />
        <x-calc.field name="to" label="To year" value="2100" min="1" max="9999" step="1" />
    </div>

    <x-calc.select name="format" label="Date format" :options="['mdy' => 'MM/DD/YYYY (US)', 'dmy' => 'DD/MM/YYYY', 'ymd' => 'YYYY-MM-DD (ISO)', 'mdy_short' => 'M/D/YYYY (no leading zeros)', 'mdyy' => 'MM/DD/YY', 'ddmmyy' => 'DD/MM/YY']" selected="mdy" />

    <x-calc.result label="Palindrome dates found" />

    <x-calc.options :decimals="false" :examples="[
        '2000–2100, US' => ['from' => 2000, 'to' => 2100, 'format' => 'mdy'],
        '2000–2100, day first' => ['from' => 2000, 'to' => 2100, 'format' => 'dmy'],
        'ISO 1000–2999' => ['from' => 1000, 'to' => 2999, 'format' => 'ymd'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'next' => ['label' => 'Next palindrome date'],
            'first' => ['label' => 'First in range'],
            'last' => ['label' => 'Last in range'],
        ]" />
        <x-calc.quick-ref heading="Palindrome dates" name="dates" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>palindrome when digits(date) = reverse(digits(date))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
