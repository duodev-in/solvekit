<x-calc.page
    title="Reserve Ratio Calculator - SolveKit"
    description="Free Reserve Ratio Calculator: reserve ratio = reserves ÷ deposits. The share of deposits a bank holds as reserves."
    lede="Work out the reserve ratio from reserves held and deposits."
    about="The share of deposits a bank holds as reserves. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'reserve_ratio', 'fields' => ['reserves', 'deposits']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Reserves held, Deposits.'],
        ['name' => 'Read the result', 'text' => 'The reserve ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the reserve ratio?', 'answer' => 'Reserve ratio = reserves ÷ deposits.'],
        ['question' => 'What is the reserve ratio for reserves held $15,000,000, deposits $150,000,000?', 'answer' => '10%.'],
        ['question' => 'And for reserves held $40, deposits $500?', 'answer' => '8%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'US reserve requirements have been 0% since March 2020.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="reserves" label="Reserves held" value="15000000" step="0.01" suffix="$" />
        <x-calc.field name="deposits" label="Deposits" value="150000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Reserve ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['reserves' => 15000000, 'deposits' => 150000000],
        'Example B' => ['reserves' => 40, 'deposits' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>reserve ratio = reserves ÷ deposits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
