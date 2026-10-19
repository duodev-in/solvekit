<x-calc.page
    title="GST Calculator - SolveKit"
    description="Free GST calculator for India: add or remove GST at 5%, 18% or 40% (GST 2.0 slabs from September 22, 2025) or any rate, with CGST/SGST or IGST split."
    lede="Add or remove GST."
    about="From September 22, 2025 most goods and services fall in two GST slabs, 5% and 18%, with 40% for luxury and sin goods; 0.25% and 3% apply to rough diamonds and gold. Within a state GST splits equally into CGST and SGST; between states it is IGST. Other countries' GST (Australia 10%, Singapore 9%) works the same way. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'gst_india', 'fields' => ['mode', 'amount', 'slab', 'rate', 'supply'], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the rate and supply type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is ₹10,000 plus 18% GST?', 'answer' => '₹11,800.00, split CGST ₹900.00 + SGST ₹900.00.'],
        ['question' => 'How much GST is in ₹11,800?', 'answer' => '₹1,800.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add GST', 'remove' => 'Remove GST']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="10000" step="0.01" suffix="₹" />
        <x-calc.select name="slab" label="GST rate" :options="['5' => '5%', '18' => '18%', '40' => '40%', '3' => '3% (gold, silver)', '0.25' => '0.25% (rough diamonds)', 'custom' => 'Other rate']" selected="18" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Other rate" value="12" step="any" suffix="%" />
        <x-calc.select name="supply" label="Supply" :options="['intra' => 'Within a state (CGST + SGST)', 'inter' => 'Between states (IGST)']" selected="intra" />
    </div>

    <x-calc.result label="Value including GST" />

    <x-calc.options :decimals="false" :examples="[
        'Add 18%' => ['mode' => 'add', 'amount' => 10000, 'slab' => '18', 'rate' => '', 'supply' => 'intra'],
        'Remove' => ['mode' => 'remove', 'amount' => 11800, 'slab' => '18', 'rate' => '', 'supply' => 'intra'],
        '5% inter-state' => ['mode' => 'add', 'amount' => 5000, 'slab' => '5', 'rate' => '', 'supply' => 'inter'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gst' => ['label' => 'GST'],
            'split' => ['label' => 'Split'],
            'net' => ['label' => 'Before GST'],
            'gross' => ['label' => 'With GST'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GST = value × rate</li>
            <li>CGST = SGST = GST ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
