<x-calc.page
    title="Pooled Standard Deviation Calculator - SolveKit"
    description="Free pooled standard deviation calculator: combine the SDs of several groups weighted by their degrees of freedom."
    lede="Pool standard deviations."
    about="The pooled standard deviation combines group variances, each weighted by its size minus one."
    :calc="['engine' => 'st-desc', 'tool' => 'pooled_sd', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the pooled SD of the example groups?', 'answer' => '4.3081157.'],
    ]"
>
    <x-calc.textarea name="data" label="Groups: standard deviation, size (one per line)" value="4.2, 25
3.8, 30
5.1, 20" rows="3" />

    <x-calc.result label="Pooled standard deviation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '4.2, 25
3.8, 30
5.1, 20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'variance' => ['label' => 'Pooled variance'],
            'df' => ['label' => 'Degrees of freedom Σ(n − 1)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
