<x-calc.page
    title="Post-Test Probability Calculator - SolveKit"
    description="Free post-test probability calculator: update a pre-test probability with a likelihood ratio or with sensitivity and specificity."
    lede="Find the post-test probability."
    about="Diagnostic tests change the odds of a condition by their likelihood ratio: post-test odds = pre-test odds × LR."
    :calc="['engine' => 'st-prob', 'tool' => 'post_test', 'fields' => ['pre', 'by', 'lr', 'sens', 'spec', 'result'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the post-test probability in the example?', 'answer' => '68%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pre" label="Pre-test probability (%)" value="20" min="0" step="any" />
        <x-calc.select name="by" label="Test described by" :options="['lr' => 'A likelihood ratio', 'sens' => 'Sensitivity and specificity']" selected="sens" />
        <div data-show-when="by:lr">
            <x-calc.field name="lr" label="Likelihood ratio" value="4" min="0" step="any" />
        </div>
        <div data-show-when="by:sens">
            <x-calc.field name="sens" label="Sensitivity (%)" value="85" min="0" step="any" />
        </div>
        <div data-show-when="by:sens">
            <x-calc.field name="spec" label="Specificity (%)" value="90" min="0" step="any" />
        </div>
        <div data-show-when="by:sens">
            <x-calc.select name="result" label="Test result" :options="['pos' => 'Positive', 'neg' => 'Negative']" selected="pos" />
        </div>
    </div>

    <x-calc.result label="Post-test probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pre' => 20, 'by' => 'sens', 'lr' => 4, 'sens' => 85, 'spec' => 90, 'result' => 'pos'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'preOdds' => ['label' => 'Pre-test odds'],
            'lrUsed' => ['label' => 'Likelihood ratio used'],
            'postOdds' => ['label' => 'Post-test odds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
