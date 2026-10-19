<x-calc.page
    title="Cash Conversion Cycle Calculator - SolveKit"
    description="Free Cash Conversion Cycle Calculator: CCC = DIO + DSO − DPO. The cash conversion cycle is the days between paying for inventory and collecting cash from sales."
    lede="Work out the cash conversion cycle from days inventory outstanding, days sales outstanding and days payable outstanding."
    about="The cash conversion cycle is the days between paying for inventory and collecting cash from sales. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cash_conversion_cycle', 'fields' => ['dio', 'dso', 'dpo']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Days inventory outstanding, Days sales outstanding, Days payable outstanding.'],
        ['name' => 'Read the result', 'text' => 'The cash conversion cycle appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cash conversion cycle?', 'answer' => 'CCC = DIO + DSO − DPO.'],
        ['question' => 'What is the cash conversion cycle for days inventory outstanding 45, days sales outstanding 30, days payable outstanding 40?', 'answer' => '35 days.'],
        ['question' => 'And for days inventory outstanding 20, days sales outstanding 5, days payable outstanding 55?', 'answer' => '−30 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Shorter is better; negative means suppliers fund operations.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="dio" label="Days inventory outstanding" value="45" min="0" step="any" suffix="days" />
        <x-calc.field name="dso" label="Days sales outstanding" value="30" min="0" step="any" suffix="days" />
        <x-calc.field name="dpo" label="Days payable outstanding" value="40" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Cash conversion cycle" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['dio' => 45, 'dso' => 30, 'dpo' => 40],
        'Example B' => ['dio' => 20, 'dso' => 5, 'dpo' => 55],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CCC = DIO + DSO − DPO</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
