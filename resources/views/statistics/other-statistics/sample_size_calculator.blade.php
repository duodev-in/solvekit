<x-calc.page
    title="Sample Size Calculator - SolveKit"
    description="Free sample size calculator: survey sample size for a proportion or mean at any confidence level and margin of error."
    lede="Find the sample size."
    about="The sample size needed grows with the confidence level and shrinks with the margin of error you can accept (Cochran’s formula)."
    :calc="['engine' => 'st-inf', 'tool' => 'sample_size', 'fields' => ['type', 'conf', 'moe', 'p', 'sd', 'N'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many people for ±5% at 95%?', 'answer' => '385.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Estimating a" :options="['prop' => 'Proportion (survey percentage)', 'mean' => 'Mean']" selected="prop" />
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
        <x-calc.field name="moe" label="Margin of error (± % for proportions)" value="5" min="0" step="any" />
        <div data-show-when="type:prop">
            <x-calc.field name="p" label="Expected proportion (%; 50 = most cautious)" value="50" min="0" step="any" />
        </div>
        <div data-show-when="type:mean">
            <x-calc.field name="sd" label="Expected standard deviation" value="15" min="0" step="any" />
        </div>
        <x-calc.field name="N" label="Population size (0 = very large)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Sample size needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'prop', 'conf' => 95, 'moe' => 5, 'p' => 50, 'sd' => 15, 'N' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'infinite' => ['label' => 'For a very large population'],
            'z' => ['label' => 'z'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
