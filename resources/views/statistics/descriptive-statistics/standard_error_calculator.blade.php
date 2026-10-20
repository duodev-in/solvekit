<x-calc.page
    title="Standard Error Calculator - SolveKit"
    description="Free standard error calculator: the standard error of a mean or proportion from data or summary values."
    lede="Find the standard error."
    about="The standard error measures how much an estimate would vary between samples."
    :calc="['engine' => 'st-desc', 'tool' => 'std_error', 'fields' => ['mode', 'data', 's', 'n', 'p', 'np'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the standard error of the example data?', 'answer' => '0.87496032.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['data' => 'Data', 'sd' => 'Standard deviation and n', 'prop' => 'A proportion']" selected="data" />
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 15, 11, 18, 14, 16, 13, 20, 15, 17" rows="3" />
        </div>
        <div data-show-when="mode:sd">
            <x-calc.field name="s" label="Standard deviation" value="8" min="0" step="any" />
        </div>
        <div data-show-when="mode:sd">
            <x-calc.field name="n" label="Sample size" value="25" min="1" step="any" />
        </div>
        <div data-show-when="mode:prop">
            <x-calc.field name="p" label="Proportion p̂" value="0.4" min="0" step="any" />
        </div>
        <div data-show-when="mode:prop">
            <x-calc.field name="np" label="Sample size" value="200" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Standard error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'data', 'data' => '12, 15, 11, 18, 14, 16, 13, 20, 15, 17', 's' => 8, 'n' => 25, 'p' => 0.4, 'np' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ci' => ['label' => 'Approximate 95% interval (± 1.96 SE)'],
            'centre' => ['label' => 'Estimate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
