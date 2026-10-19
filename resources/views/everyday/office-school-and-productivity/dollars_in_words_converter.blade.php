<x-calc.page
    title="Dollars in Words Converter - SolveKit"
    description="Free dollars in words converter: write any dollar amount in words for a check, with cents as a fraction of 100, or rupees in words for an Indian cheque with lakh and crore."
    lede="Write a dollar amount in words for a check."
    about="On a check, write the dollars in words and the cents as a fraction of 100: $1,234.56 is One thousand two hundred thirty-four and 56/100 dollars. Hyphenate numbers from twenty-one to ninety-nine, and draw a line through the rest of the space so nothing can be added. Indian cheques write the amount with lakh and crore and end with Only: Rupees Twelve Lakh Thirty-Four Thousand Five Hundred Sixty-Seven and Fifty Paise Only."
    :calc="['engine' => 'ev-office', 'tool' => 'dollars_words', 'fields' => ['amount', 'currency_word', 'format']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => 'With or without commas.'],
        ['name' => 'Copy the wording', 'text' => 'Onto the check.'],
    ]"
    :faqs="[
        ['question' => 'How do I write $1,234.56 on a check?', 'answer' => 'One thousand two hundred thirty-four and 56/100 dollars.'],
        ['question' => 'How do I write $100 with no cents?', 'answer' => 'One hundred and 00/100 dollars.'],
        ['question' => 'Do I use and for hundreds?', 'answer' => 'In US check writing, and is kept for the cents.'],
        ['question' => 'How do I write ₹12,34,567.50 on an Indian cheque?', 'answer' => 'Rupees Twelve Lakh Thirty-Four Thousand Five Hundred Sixty-Seven and Fifty Paise Only.'],
    ]"
>
    <x-calc.segmented name="format" legend="Format" :options="['us' => 'US check', 'indian' => 'Indian cheque (rupees)']" selected="us" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="1234.56" type="text" placeholder="1234.56" />
        <x-calc.field name="currency_word" label="Currency word" value="dollars" type="text" />
    </div>

    <x-calc.result label="For a check" />

    <x-calc.options :decimals="false" :examples="[
        '$1,234.56' => ['format' => 'us', 'amount' => '1234.56', 'currency_word' => 'dollars'],
        '$100' => ['format' => 'us', 'amount' => '100', 'currency_word' => 'dollars'],
        '$2,500,000.05' => ['format' => 'us', 'amount' => '2,500,000.05', 'currency_word' => 'dollars'],
        '₹12,34,567.50' => ['format' => 'indian', 'amount' => '1234567.50', 'currency_word' => 'rupees'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'spoken' => ['label' => 'Spelled out'],
            'upper' => ['label' => 'Upper case'],
            'digits' => ['label' => 'In figures'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dollars in words + and + cents/100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
