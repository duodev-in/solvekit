<x-calc.page
    title="Sampling Error Calculator - SolveKit"
    description="Free sampling error calculator: the expected error of a sample mean or proportion at a confidence level."
    lede="Find the sampling error."
    about="Sampling error is the difference between a sample estimate and the population value that comes from sampling alone."
    :calc="['engine' => 'st-inf', 'tool' => 'sampling_error', 'fields' => ['type', 'sd', 'p', 'n', 'conf', 'N'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the sampling error in the example?', 'answer' => '± 1.95996.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="For a" :options="['mean' => 'Mean (from σ)', 'prop' => 'Proportion']" selected="mean" />
        <div data-show-when="type:mean">
            <x-calc.field name="sd" label="Population SD σ" value="20" min="0" step="any" />
        </div>
        <div data-show-when="type:prop">
            <x-calc.field name="p" label="Proportion p" value="0.5" min="0" step="any" />
        </div>
        <x-calc.field name="n" label="Sample size" value="400" min="1" step="any" />
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
        <x-calc.field name="N" label="Population size (0 = very large)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Sampling error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'mean', 'sd' => 20, 'p' => 0.5, 'n' => 400, 'conf' => 95, 'N' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'se' => ['label' => 'Standard error'],
            'z' => ['label' => 'z'],
            'fpc' => ['label' => 'Finite population correction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
