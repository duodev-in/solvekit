<x-calc.page
    title="Raw Score Calculator - SolveKit"
    description="Free raw score calculator: x from a z-score, mean and standard deviation."
    lede="Find a raw score."
    about="A raw score is the original value: x = μ + zσ."
    :calc="['engine' => 'st-inf', 'tool' => 'raw_score', 'fields' => ['z', 'mean', 'sd'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What raw score is z = 1.5 with mean 100, SD 15?', 'answer' => '122.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="z" label="z-score" value="1.5" step="any" />
        <x-calc.field name="mean" label="Mean μ" value="100" step="any" />
        <x-calc.field name="sd" label="Standard deviation σ" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Raw score x" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z' => 1.5, 'mean' => 100, 'sd' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pct' => ['label' => 'Percentile (normal)'],
            'above' => ['label' => 'Share above'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
