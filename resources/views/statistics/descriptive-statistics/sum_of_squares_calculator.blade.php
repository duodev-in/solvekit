<x-calc.page
    title="Sum of Squares Calculator - SolveKit"
    description="Free sum of squares calculator: Σ(x − x̄)², the raw sum of squares and the shortcut formula."
    lede="Find the sum of squares."
    about="The sum of squares adds the squared deviations from the mean. It is the building block of variance, ANOVA and regression."
    :calc="['engine' => 'st-desc', 'tool' => 'sum_squares', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the sum of squares of 3, 5, 7, 9, 11?', 'answer' => '40.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="3, 5, 7, 9, 11" rows="3" />

    <x-calc.result label="Sum of squares Σ(x − x̄)²" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '3, 5, 7, 9, 11'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'raw' => ['label' => 'Raw sum of squares Σx²'],
            'shortcut' => ['label' => 'Shortcut Σx² − (Σx)²/n'],
            'mean' => ['label' => 'Mean'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Squared deviations" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
