<x-calc.page
    title="Money Multiplier Calculator - SolveKit"
    description="Free Money Multiplier Calculator: multiplier = 1 ÷ reserve ratio. The textbook money multiplier shows the most deposits the banking system can create from reserves."
    lede="Work out the money multiplier from the reserve ratio."
    about="The textbook money multiplier shows the most deposits the banking system can create from reserves. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'money_multiplier', 'fields' => ['ratio']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Reserve ratio.'],
        ['name' => 'Read the result', 'text' => 'The money multiplier appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the money multiplier?', 'answer' => 'Multiplier = 1 ÷ reserve ratio.'],
        ['question' => 'What is the money multiplier for reserve ratio 10%?', 'answer' => '10×.'],
        ['question' => 'And for reserve ratio 20%?', 'answer' => '5×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The Fed set reserve requirements to zero in March 2020; real money creation is limited by capital and demand.'],
    ]"
>
    <x-calc.field name="ratio" label="Reserve ratio" value="10" step="any" suffix="%" />

    <x-calc.result label="Money multiplier" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ratio' => 10],
        'Example B' => ['ratio' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>multiplier = 1 ÷ reserve ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
