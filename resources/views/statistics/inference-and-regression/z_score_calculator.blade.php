<x-calc.page
    title="Z-score Calculator - SolveKit"
    description="Free z-score calculator: standard score of a value with its percentile and tail probabilities."
    lede="Find a z-score."
    about="A z-score says how many standard deviations a value is from the mean."
    :calc="['engine' => 'st-inf', 'tool' => 'z_score', 'fields' => ['mode', 'x', 'mean', 'sd', 'data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the z-score of 85 with mean 70, SD 10?', 'answer' => '1.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['values' => 'A value, mean and SD', 'data' => 'A value within a data set']" selected="values" />
        <x-calc.field name="x" label="Value x" value="85" step="any" />
        <div data-show-when="mode:values">
            <x-calc.field name="mean" label="Mean μ" value="70" step="any" />
        </div>
        <div data-show-when="mode:values">
            <x-calc.field name="sd" label="Standard deviation σ" value="10" min="0" step="any" />
        </div>
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data set" value="62, 70, 74, 78, 81, 85, 88, 90, 93, 97" rows="3" />
        </div>
    </div>

    <x-calc.result label="z-score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'values', 'x' => 85, 'mean' => 70, 'sd' => 10, 'data' => '62, 70, 74, 78, 81, 85, 88, 90, 93, 97'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Standard normal curve" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'below' => ['label' => 'P(Z < z), percentile'],
            'above' => ['label' => 'P(Z > z)'],
            'between' => ['label' => 'P(−|z| < Z < |z|)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
