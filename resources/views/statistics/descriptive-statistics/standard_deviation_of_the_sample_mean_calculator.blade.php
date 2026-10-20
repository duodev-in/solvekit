<x-calc.page
    title="Standard Deviation of the Sample Mean Calculator - SolveKit"
    description="Free standard deviation of the sample mean calculator: σ/√n with the finite population correction."
    lede="Find the SD of the sample mean."
    about="Sample means vary less than single values: their standard deviation is σ divided by √n."
    :calc="['engine' => 'st-desc', 'tool' => 'sd_mean', 'fields' => ['sigma', 'n', 'N'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is σ_x̄ for σ = 15, n = 36?', 'answer' => '2.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sigma" label="Standard deviation σ (or s)" value="15" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="36" min="1" step="any" />
        <x-calc.field name="N" label="Population size N (0 = very large)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Standard deviation of the sample mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sigma' => 15, 'n' => 36, 'N' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'fpc' => ['label' => 'Finite population correction'],
            'plain' => ['label' => 'Without the correction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
