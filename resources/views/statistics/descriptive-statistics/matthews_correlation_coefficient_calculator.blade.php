<x-calc.page
    title="Correlation Coefficient Calculator (Matthews) - SolveKit"
    description="Free Matthews correlation coefficient calculator: MCC from a confusion matrix, robust to unbalanced classes."
    lede="Find the Matthews correlation coefficient."
    about="The Matthews correlation coefficient summarises a binary classifier in one number from −1 to +1, fair even when classes are unbalanced."
    :calc="['engine' => 'st-desc', 'tool' => 'mcc', 'fields' => ['TP', 'FP', 'TN', 'FN'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the MCC of the example?', 'answer' => '0.750939.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="TP" label="True positives" value="90" min="0" step="any" />
        <x-calc.field name="FP" label="False positives" value="10" min="0" step="any" />
        <x-calc.field name="TN" label="True negatives" value="85" min="0" step="any" />
        <x-calc.field name="FN" label="False negatives" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Matthews correlation coefficient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['TP' => 90, 'FP' => 10, 'TN' => 85, 'FN' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'chi' => ['label' => 'χ² = n × MCC²'],
            'f1' => ['label' => 'F1 score'],
            'acc' => ['label' => 'Accuracy'],
            'meaning' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
