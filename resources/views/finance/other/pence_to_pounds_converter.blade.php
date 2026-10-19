<x-calc.page
    title="Pence to Pounds Converter - SolveKit"
    description="Free Pence to Pounds Converter: £1 = 100 pence. Converts pence to pounds sterling."
    lede="Work out the pounds from the pence."
    about="Converts pence to pounds sterling. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'pence_pounds', 'fields' => ['pence'], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Pence.'],
        ['name' => 'Read the result', 'text' => 'The pounds appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the pounds?', 'answer' => '£1 = 100 pence.'],
        ['question' => 'What is the pounds for pence 250?', 'answer' => '£2.50.'],
        ['question' => 'And for pence 1,995?', 'answer' => '£19.95.'],
        ['question' => 'What does the result tell me?', 'answer' => '250p = £2.50.'],
    ]"
>
    <x-calc.field name="pence" label="Pence" value="250" step="any" />

    <x-calc.result label="Pounds" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['pence' => 250],
        'Example B' => ['pence' => 1995],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>£1 = 100 pence</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
