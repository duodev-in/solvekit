<x-calc.page
    title="Direct Material Price Variance Calculator - SolveKit"
    description="Free Direct Material Price Variance Calculator: DMPV = (AP − SP) × AQ. The direct material price variance shows how much more (positive, unfavorable) or less (negative, favorable) materials cost than the standard."
    lede="Work out the price variance from actual price per unit, standard price per unit and actual quantity bought."
    about="The direct material price variance shows how much more (positive, unfavorable) or less (negative, favorable) materials cost than the standard. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'direct_material_price_variance', 'fields' => ['actual', 'standard', 'quantity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Actual price per unit, Standard price per unit, Actual quantity bought.'],
        ['name' => 'Read the result', 'text' => 'The price variance appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price variance?', 'answer' => 'DMPV = (AP − SP) × AQ.'],
        ['question' => 'What is the price variance for actual price per unit $5.20, standard price per unit $5, actual quantity bought 2,000?', 'answer' => '$400.00.'],
        ['question' => 'And for actual price per unit $2.90, standard price per unit $3.10, actual quantity bought 5,000?', 'answer' => '−$1,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Positive is unfavorable: you paid more than planned.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="actual" label="Actual price per unit" value="5.2" step="0.01" suffix="$" />
        <x-calc.field name="standard" label="Standard price per unit" value="5" step="0.01" suffix="$" />
        <x-calc.field name="quantity" label="Actual quantity bought" value="2000" step="any" />
    </div>

    <x-calc.result label="Price variance" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['actual' => 5.2, 'standard' => 5, 'quantity' => 2000],
        'Example B' => ['actual' => 2.9, 'standard' => 3.1, 'quantity' => 5000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DMPV = (AP − SP) × AQ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
