<x-calc.page
    title="Margin of Error Calculator - SolveKit"
    description="Free margin of error calculator: survey margin of error for a proportion or mean, with finite population correction."
    lede="Find the margin of error."
    about="The margin of error is half the width of a confidence interval: how far the estimate may be from the truth."
    :calc="['engine' => 'st-inf', 'tool' => 'margin_error', 'fields' => ['type', 'conf', 'n', 'p', 'sd', 'N'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the margin of error for 1,000 respondents?', 'answer' => '± 3.099%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="For a" :options="['prop' => 'Proportion (survey percentage)', 'mean' => 'Mean']" selected="prop" />
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
        <x-calc.field name="n" label="Sample size" value="1000" min="1" step="any" />
        <div data-show-when="type:prop">
            <x-calc.field name="p" label="Proportion p (0.5 = most cautious)" value="0.5" min="0" step="any" />
        </div>
        <div data-show-when="type:mean">
            <x-calc.field name="sd" label="Standard deviation" value="15" min="0" step="any" />
        </div>
        <x-calc.field name="N" label="Population size (0 = very large)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Margin of error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'prop', 'conf' => 95, 'n' => 1000, 'p' => 0.5, 'sd' => 15, 'N' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'z' => ['label' => 'z critical value'],
            'se' => ['label' => 'Standard error'],
            'fpc' => ['label' => 'Finite population correction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
