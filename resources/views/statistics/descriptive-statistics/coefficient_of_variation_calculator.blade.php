<x-calc.page
    title="Coefficient of Variation Calculator - SolveKit"
    description="Free coefficient of variation calculator: CV from data or from a mean and standard deviation, sample and population."
    lede="Find the coefficient of variation."
    about="The coefficient of variation is the standard deviation as a percentage of the mean, comparing spread across data on different scales."
    :calc="['engine' => 'st-desc', 'tool' => 'cv', 'fields' => ['mode', 'data', 'mean', 'sd'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the CV of the example data?', 'answer' => '18.324%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['data' => 'Data', 'summary' => 'Mean and standard deviation']" selected="data" />
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 15, 11, 18, 14, 16, 13, 20, 15, 17" rows="3" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="mean" label="Mean" value="50" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="sd" label="Standard deviation" value="5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Coefficient of variation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'data', 'data' => '12, 15, 11, 18, 14, 16, 13, 20, 15, 17', 'mean' => 50, 'sd' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sample' => ['label' => 'Using the sample SD'],
            'pop' => ['label' => 'Using the population SD'],
            'mean' => ['label' => 'Mean'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
