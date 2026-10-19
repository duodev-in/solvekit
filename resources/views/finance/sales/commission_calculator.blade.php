<x-calc.page
    title="Commission Calculator - SolveKit"
    description="Free Commission Calculator: commission = sale × rate. Commission is a percentage of the sale."
    lede="Work out the commission from sale amount and commission rate."
    about="Commission is a percentage of the sale. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'commission', 'fields' => ['sale', 'rate']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Sale amount, Commission rate.'],
        ['name' => 'Read the result', 'text' => 'The commission appears as you type, with net after commission below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the commission?', 'answer' => 'Commission = sale × rate.'],
        ['question' => 'What is the commission for sale amount $25,000, commission rate 6%?', 'answer' => '$1,500.00. Net after commission: $23,500.00.'],
        ['question' => 'And for sale amount $1,850, commission rate 15%?', 'answer' => '$277.50. Net after commission: $1,572.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'For tiers, use the Sales Commission Calculator.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sale" label="Sale amount" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Commission rate" value="6" step="any" suffix="%" />
    </div>

    <x-calc.result label="Commission" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['sale' => 25000, 'rate' => 6],
        'Example B' => ['sale' => 1850, 'rate' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Net after commission'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>commission = sale × rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
