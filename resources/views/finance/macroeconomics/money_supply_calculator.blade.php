<x-calc.page
    title="Money Supply Calculator - SolveKit"
    description="Free Money Supply Calculator: M = reserves × (1 ÷ reserve ratio). The textbook maximum deposits supported by a level of reserves."
    lede="Work out the maximum money supply from bank reserves and reserve ratio."
    about="The textbook maximum deposits supported by a level of reserves. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'money_supply', 'fields' => ['reserves', 'ratio']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Bank reserves, Reserve ratio.'],
        ['name' => 'Read the result', 'text' => 'The maximum money supply appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the maximum money supply?', 'answer' => 'M = reserves × (1 ÷ reserve ratio).'],
        ['question' => 'What is the maximum money supply for bank reserves $100,000, reserve ratio 10%?', 'answer' => '$1,000,000.00.'],
        ['question' => 'And for bank reserves $2,500, reserve ratio 5%?', 'answer' => '$50,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Real-world money supply also depends on cash holdings and lending.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="reserves" label="Bank reserves" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="ratio" label="Reserve ratio" value="10" step="any" suffix="%" />
    </div>

    <x-calc.result label="Maximum money supply" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['reserves' => 100000, 'ratio' => 10],
        'Example B' => ['reserves' => 2500, 'ratio' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = reserves × (1 ÷ reserve ratio)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
