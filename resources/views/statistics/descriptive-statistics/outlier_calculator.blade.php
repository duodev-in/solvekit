<x-calc.page
    title="Outlier Calculator - SolveKit"
    description="Free outlier calculator: find outliers with Tukey fences, z-scores or Grubbs’ test, with a box plot."
    lede="Find outliers."
    about="Outliers are values far from the rest. Tukey’s fences flag values more than 1.5 IQR beyond the quartiles."
    :calc="['engine' => 'st-desc', 'tool' => 'outlier', 'fields' => ['data', 'method'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Which values are outliers in the example?', 'answer' => '45.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="12, 14, 15, 15, 16, 17, 18, 19, 21, 45" rows="3" />
        <x-calc.select name="method" label="Method" :options="['iqr' => 'Tukey fences (1.5 × IQR)', 'z' => 'z-score (|z| > 3)', 'grubbs' => 'Grubbs’ test (α = 0.05)']" selected="iqr" />
    </div>

    <x-calc.result label="Outliers" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '12, 14, 15, 15, 16, 17, 18, 19, 21, 45', 'method' => 'iqr'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Box plot" name="box" />
        <x-calc.rows heading="Details" :rows="[
            'limits' => ['label' => 'Limits'],
            'count' => ['label' => 'Outliers found'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
