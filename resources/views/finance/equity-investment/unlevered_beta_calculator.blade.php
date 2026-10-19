<x-calc.page
    title="Unlevered Beta Calculator - SolveKit"
    description="Free Unlevered Beta Calculator: βU = βL ÷ [1 + (1 − t) D/E] (Hamada). Unlevered (asset) beta removes the effect of debt so companies with different leverage can be compared."
    lede="Work out the unlevered beta from levered (equity) beta, tax rate and debt-to-equity ratio."
    about="Unlevered (asset) beta removes the effect of debt so companies with different leverage can be compared. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'unlevered_beta', 'fields' => ['levered', 'tax', 'de']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Levered (equity) beta, Tax rate, Debt-to-equity ratio.'],
        ['name' => 'Read the result', 'text' => 'The unlevered beta appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the unlevered beta?', 'answer' => 'βU = βL ÷ [1 + (1 − t) D/E] (Hamada).'],
        ['question' => 'What is the unlevered beta for levered beta 1.3, tax rate 21%, debt-to-equity ratio 0.6?', 'answer' => '0.882.'],
        ['question' => 'And for levered beta 0.9, tax rate 25%, debt-to-equity ratio 1.2?', 'answer' => '0.4737.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Relever with your target D/E: βL = βU [1 + (1 − t) D/E].'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="levered" label="Levered (equity) beta" value="1.3" step="any" />
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
        <x-calc.field name="de" label="Debt-to-equity ratio" value="0.6" step="any" />
    </div>

    <x-calc.result label="Unlevered beta" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['levered' => 1.3, 'tax' => 21, 'de' => 0.6],
        'Example B' => ['levered' => 0.9, 'tax' => 25, 'de' => 1.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>βU = βL ÷ [1 + (1 − t) D/E] (Hamada)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
