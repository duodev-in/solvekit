<x-calc.page
    title="Cap Rate Calculator - SolveKit"
    description="Free Cap Rate Calculator: cap rate = NOI ÷ value. The capitalization rate is the unlevered yield of a property."
    lede="Work out the cap rate from net operating income (yearly) and property value."
    about="The capitalization rate is the unlevered yield of a property. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cap_rate', 'fields' => ['noi', 'value']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net operating income (yearly), Property value.'],
        ['name' => 'Read the result', 'text' => 'The cap rate appears as you type, with value at this cap rate for $10k more NOI below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cap rate?', 'answer' => 'Cap rate = NOI ÷ value.'],
        ['question' => 'What is the cap rate for net operating income $60,000, property value $1,000,000?', 'answer' => '6%. Value at this cap rate for $10k more NOI: $1,166,666.67.'],
        ['question' => 'And for net operating income $38,000, property value $520,000?', 'answer' => '7.308%. Value at this cap rate for $10k more NOI: $656,842.11.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Lower cap rates mean higher prices for the same income.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="noi" label="Net operating income (yearly)" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="value" label="Property value" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cap rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['noi' => 60000, 'value' => 1000000],
        'Example B' => ['noi' => 38000, 'value' => 520000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Value at this cap rate for $10k more NOI'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cap rate = NOI ÷ value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
