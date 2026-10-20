<x-calc.page
    title="Accuracy Calculator - SolveKit"
    description="Free accuracy calculator: classification accuracy from a confusion matrix, or percent accuracy of a measurement, with balanced accuracy and error rate."
    lede="Find accuracy."
    about="Accuracy is the share of cases classified correctly, (TP + TN) ÷ total. For a single measurement, percent accuracy is 100% minus the percent error against the true value."
    :calc="['engine' => 'st-prob', 'tool' => 'accuracy', 'fields' => ['mode', 'TP', 'FP', 'TN', 'FN', 'measured', 'actual'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the accuracy of the example classifier?', 'answer' => '85%.'],
        ['question' => 'Why look at balanced accuracy?', 'answer' => 'When one class is rare, a model can score high accuracy by always predicting the common class; balanced accuracy averages sensitivity and specificity instead.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Measure" :options="['matrix' => 'Classification (confusion matrix)', 'measure' => 'A measurement against the true value']" selected="matrix" />
        <div data-show-when="mode:matrix">
            <x-calc.field name="TP" label="True positives" value="45" min="0" step="any" />
        </div>
        <div data-show-when="mode:matrix">
            <x-calc.field name="FP" label="False positives" value="5" min="0" step="any" />
        </div>
        <div data-show-when="mode:matrix">
            <x-calc.field name="TN" label="True negatives" value="40" min="0" step="any" />
        </div>
        <div data-show-when="mode:matrix">
            <x-calc.field name="FN" label="False negatives" value="10" min="0" step="any" />
        </div>
        <div data-show-when="mode:measure">
            <x-calc.field name="measured" label="Measured value" value="9.6" step="any" />
        </div>
        <div data-show-when="mode:measure">
            <x-calc.field name="actual" label="True (accepted) value" value="9.81" step="any" />
        </div>
    </div>

    <x-calc.result label="Accuracy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'matrix', 'TP' => 45, 'FP' => 5, 'TN' => 40, 'FN' => 10, 'measured' => 9.6, 'actual' => 9.81],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'second' => ['label' => 'Error rate'],
            'balanced' => ['label' => 'Balanced accuracy'],
            'prevalence' => ['label' => 'Prevalence'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
