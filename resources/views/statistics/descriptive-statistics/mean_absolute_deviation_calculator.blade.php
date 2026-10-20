<x-calc.page
    title="Mean Absolute Deviation Calculator - SolveKit"
    description="Free mean absolute deviation calculator: average distance from the mean or median, with the working table."
    lede="Find the mean absolute deviation."
    about="The mean absolute deviation is the average distance of the values from their mean."
    :calc="['engine' => 'st-desc', 'tool' => 'mad_mean', 'fields' => ['data', 'about'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the MAD of the example?', 'answer' => '6.122449.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 6, 8, 10, 12, 30" rows="3" />
        <x-calc.select name="about" label="Deviations from the" :options="['mean' => 'Mean', 'median' => 'Median']" selected="mean" />
    </div>

    <x-calc.result label="Mean absolute deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 6, 8, 10, 12, 30', 'about' => 'mean'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'centre' => ['label' => 'Centre used'],
            'sd' => ['label' => 'Standard deviation (population)'],
            'ratio' => ['label' => 'MAD ÷ SD'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Absolute deviations" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
