<x-calc.page
    title="Sensitivity and Specificity Calculator - SolveKit"
    description="Free sensitivity and specificity calculator: with Wilson confidence intervals, PPV, NPV and likelihood ratios from a 2 × 2 table."
    lede="Evaluate a diagnostic test."
    about="Sensitivity is the share of people with the condition who test positive; specificity is the share without it who test negative. Also known as Sensitivity Calculator and Specificity Calculator."
    :calc="['engine' => 'st-prob', 'tool' => 'sens_spec', 'fields' => ['TP', 'FN', 'FP', 'TN', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What are the sensitivity and specificity in the example?', 'answer' => '90% and 90% (CI 86.08% to 92.91%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="TP" label="True positives" value="90" min="0" step="any" />
        <x-calc.field name="FN" label="False negatives" value="10" min="0" step="any" />
        <x-calc.field name="FP" label="False positives" value="30" min="0" step="any" />
        <x-calc.field name="TN" label="True negatives" value="270" min="0" step="any" />
        <x-calc.field name="conf" label="Confidence (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Sensitivity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['TP' => 90, 'FN' => 10, 'FP' => 30, 'TN' => 270, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'spec' => ['label' => 'Specificity'],
            'ppv' => ['label' => 'Positive predictive value'],
            'npv' => ['label' => 'Negative predictive value'],
            'lrp' => ['label' => 'LR+'],
            'lrn' => ['label' => 'LR−'],
            'prev' => ['label' => 'Prevalence in this sample'],
            'acc' => ['label' => 'Accuracy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
