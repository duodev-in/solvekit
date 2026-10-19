<x-calc.page
    title="EMV Calculator – Expected Monetary Value - SolveKit"
    description="Free expected monetary value calculator: probability-weighted value of project risks and opportunities for risk analysis and decision trees."
    lede="Quantify risks with expected monetary value."
    about="EMV = Σ probability × impact, with threats as negative and opportunities as positive amounts. Project managers add the EMV of identified risks to the contingency reserve. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'emv', 'fields' => ['outcomes']]"
    :how-to="[
        ['name' => 'List risks and opportunities', 'text' => ''],
        ['name' => 'Read the EMV', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the EMV of the example risks?', 'answer' => '−$14,000.00.'],
    ]"
>
    <x-calc.rows-editor name="outcomes" label="Risks and opportunities" :columns="['name' => 'Item', 'p' => 'Probability %', 'impact' => 'Impact']" :rows="[['Supplier delay', 30, -40000], ['Price increase', 20, -25000], ['Early delivery bonus', 15, 20000]]" :text="['name']" />

    <x-calc.result label="Expected monetary value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['outcomes' => 'Supplier delay	30	-40000
Price increase	20	-25000
Early delivery bonus	15	20000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'threats' => ['label' => 'Threats'],
            'opportunities' => ['label' => 'Opportunities'],
            'probability' => ['label' => 'Total probability'],
            'count' => ['label' => 'Items'],
        ]" />
        <x-calc.quick-ref heading="Items" name="outcomes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EMV = Σ p × impact</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
