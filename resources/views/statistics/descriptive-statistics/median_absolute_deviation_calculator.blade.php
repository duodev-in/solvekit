<x-calc.page
    title="Median Absolute Deviation Calculator - SolveKit"
    description="Free median absolute deviation calculator: a robust measure of spread, raw or scaled to estimate σ."
    lede="Find the median absolute deviation."
    about="The median absolute deviation is the median distance from the median. Unlike the standard deviation it ignores outliers."
    :calc="['engine' => 'st-desc', 'tool' => 'mad_median', 'fields' => ['data', 'scale'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the MAD of the example?', 'answer' => '1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 3, 3, 4, 5, 6, 40" rows="3" />
        <x-calc.select name="scale" label="Scale" :options="['raw' => 'Raw MAD', 'normal' => 'Scaled × 1.4826 (estimates σ for normal data)']" selected="raw" />
    </div>

    <x-calc.result label="Median absolute deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 3, 3, 4, 5, 6, 40', 'scale' => 'raw'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'median' => ['label' => 'Median'],
            'scaled' => ['label' => 'Scaled MAD (× 1.4826)'],
            'sd' => ['label' => 'Standard deviation for comparison'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
