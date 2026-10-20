<x-calc.page
    title="Empirical Rule Calculator - SolveKit"
    description="Free empirical rule calculator: the 68–95–99.7 ranges for a normal distribution from its mean and standard deviation."
    lede="Apply the 68–95–99.7 rule."
    about="For bell-shaped data, about 68% of values lie within one standard deviation of the mean, 95% within two and 99.7% within three."
    :calc="['engine' => 'st-dist', 'tool' => 'empirical', 'fields' => ['mean', 'sd'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Where do 95% of values lie for mean 100, SD 15?', 'answer' => '70 to 130.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mean" label="Mean μ" value="100" step="any" />
        <x-calc.field name="sd" label="Standard deviation σ" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="68% of values lie between" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mean' => 100, 'sd' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Normal curve (shaded ±1σ)" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'r95' => ['label' => '95% between'],
            'r997' => ['label' => '99.7% between'],
            'exact' => ['label' => 'Exact normal shares'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="The 68–95–99.7 rule" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
