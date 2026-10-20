<x-calc.page
    title="Trimmed Mean Calculator - SolveKit"
    description="Free trimmed mean calculator: the mean after removing a percentage from each end, with the winsorised mean."
    lede="Find a trimmed mean."
    about="A trimmed mean drops the most extreme values before averaging, so outliers have less influence."
    :calc="['engine' => 'st-desc', 'tool' => 'trimmed_mean', 'fields' => ['data', 'trim'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the 10% trimmed mean of the example?', 'answer' => '6.375.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 5, 5, 6, 7, 7, 8, 9, 40" rows="3" />
        <x-calc.field name="trim" label="Trim from each end (%)" value="10" min="0" step="any" />
    </div>

    <x-calc.result label="Trimmed mean" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 5, 5, 6, 7, 7, 8, 9, 40', 'trim' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'removed' => ['label' => 'Values removed from each end'],
            'winsor' => ['label' => 'Winsorised mean'],
            'mean' => ['label' => 'Ordinary mean'],
            'median' => ['label' => 'Median'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
