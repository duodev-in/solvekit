<x-calc.page
    title="Confusion Matrix Calculator - SolveKit"
    description="Free confusion matrix calculator: precision, recall, F1, accuracy, specificity, MCC and kappa from TP, FP, FN and TN."
    lede="Evaluate a classifier."
    about="A confusion matrix counts correct and incorrect predictions by class. Every common classification metric comes from its four cells."
    :calc="['engine' => 'st-prob', 'tool' => 'confusion', 'fields' => ['TP', 'FP', 'FN', 'TN'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the F1 score of the example?', 'answer' => '0.842105.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="TP" label="True positives (predicted yes, actually yes)" value="80" min="0" step="any" />
        <x-calc.field name="FP" label="False positives (predicted yes, actually no)" value="20" min="0" step="any" />
        <x-calc.field name="FN" label="False negatives (predicted no, actually yes)" value="10" min="0" step="any" />
        <x-calc.field name="TN" label="True negatives (predicted no, actually no)" value="90" min="0" step="any" />
    </div>

    <x-calc.result label="F1 score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['TP' => 80, 'FP' => 20, 'FN' => 10, 'TN' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'precision' => ['label' => 'Precision (PPV)'],
            'recall' => ['label' => 'Recall (sensitivity)'],
            'specificity' => ['label' => 'Specificity'],
            'npv' => ['label' => 'Negative predictive value'],
            'accuracy' => ['label' => 'Accuracy'],
            'balanced' => ['label' => 'Balanced accuracy'],
            'mcc' => ['label' => 'Matthews correlation (MCC)'],
            'kappa' => ['label' => 'Cohen’s κ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Confusion matrix" name="matrix" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
