<x-calc.page
    title="GST/QST Calculator for Canada - SolveKit"
    description="Free Canadian sales tax calculator: GST, QST, PST or HST for any province, added to or removed from a price (2026 rates)."
    lede="Work out GST, QST, PST or HST in Canada."
    about="GST is 5% across Canada. Quebec adds 9.975% QST; British Columbia (7%), Manitoba (7% RST) and Saskatchewan (6%) add PST; Ontario (13%), Nova Scotia (14%), New Brunswick, Newfoundland and Labrador and Prince Edward Island (15%) charge a single HST. Alberta and the territories charge GST only. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'gst_canada', 'fields' => ['mode', 'amount', 'province'], 'data' => ['canada' => config('finance_data.canada')], 'sym' => 'CAD', 'currency' => 'CAD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the province', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is C$100 with GST and QST?', 'answer' => 'C$114.98.'],
        ['question' => 'And in Ontario?', 'answer' => 'C$113.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add tax', 'remove' => 'Remove tax']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="C$" />
        <x-calc.select name="province" label="Province or territory" :options="['AB' => 'Alberta', 'BC' => 'British Columbia', 'MB' => 'Manitoba', 'NB' => 'New Brunswick', 'NL' => 'Newfoundland and Labrador', 'NS' => 'Nova Scotia', 'NT' => 'Northwest Territories', 'NU' => 'Nunavut', 'ON' => 'Ontario', 'PE' => 'Prince Edward Island', 'QC' => 'Quebec', 'SK' => 'Saskatchewan', 'YT' => 'Yukon']" selected="QC" />
    </div>

    <x-calc.result label="Total with tax" />

    <x-calc.options :decimals="false" :examples="[
        'Quebec' => ['mode' => 'add', 'amount' => 100, 'province' => 'QC'],
        'Ontario' => ['mode' => 'add', 'amount' => 100, 'province' => 'ON'],
        'Remove BC' => ['mode' => 'remove', 'amount' => 112, 'province' => 'BC'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gst' => ['label' => 'GST'],
            'provincial' => ['label' => 'Provincial tax'],
            'total' => ['label' => 'Total tax'],
            'rate' => ['label' => 'Combined rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GST 5% + provincial rate</li>
            <li>HST provinces: one combined rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
