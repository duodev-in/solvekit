<x-calc.page
    title="False Positive Paradox Calculator - SolveKit"
    description="Free false positive paradox calculator: why most positive results for a rare condition are false, with a table of outcomes."
    lede="See the false positive paradox."
    about="When a condition is rare, even a very accurate test produces more false positives than true ones. Bayes’ theorem gives the real chance that a positive result is right. Also known as False Positive Calculator."
    :calc="['engine' => 'st-prob', 'tool' => 'false_positive', 'fields' => ['prev', 'sens', 'spec', 'pop'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'With 1% prevalence, 99% sensitivity and 95% specificity, how likely is a positive to be real?', 'answer' => '16.67%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prev" label="Prevalence (%)" value="1" min="0" step="any" />
        <x-calc.field name="sens" label="Sensitivity (%)" value="99" min="0" step="any" />
        <x-calc.field name="spec" label="Specificity (%)" value="95" min="0" step="any" />
        <x-calc.field name="pop" label="People tested" value="10000" min="1" step="any" />
    </div>

    <x-calc.result label="P(condition | positive test)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['prev' => 1, 'sens' => 99, 'spec' => 95, 'pop' => 10000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'falsePos' => ['label' => 'Positive results that are false'],
            'npv' => ['label' => 'P(no condition | negative)'],
            'positives' => ['label' => 'Positive results'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="What happens to the people tested" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
