<x-calc.page
    title="RSE Calculator — Relative Standard Error - SolveKit"
    description="Free relative standard error calculator: RSE from data or an estimate and its standard error, with reliability flags."
    lede="Find the relative standard error."
    about="The relative standard error is the standard error as a percentage of the estimate. Survey agencies suppress estimates with high RSE."
    :calc="['engine' => 'st-desc', 'tool' => 'rse', 'fields' => ['mode', 'data', 'est', 'se'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the RSE of the example?', 'answer' => '5.7944%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['data' => 'Data', 'summary' => 'An estimate and its standard error']" selected="data" />
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 15, 11, 18, 14, 16, 13, 20, 15, 17" rows="3" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="est" label="Estimate" value="42.5" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="se" label="Standard error" value="3.1" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Relative standard error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'data', 'data' => '12, 15, 11, 18, 14, 16, 13, 20, 15, 17', 'est' => 42.5, 'se' => 3.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'se' => ['label' => 'Standard error'],
            'est' => ['label' => 'Estimate'],
            'reliable' => ['label' => 'Reliability'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
