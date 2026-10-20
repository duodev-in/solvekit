<x-calc.page
    title="Skewness Calculator - SolveKit"
    description="Free skewness calculator: sample skewness G₁, population g₁, Pearson’s coefficient and a significance check."
    lede="Measure skewness."
    about="Skewness measures the asymmetry of a distribution: positive when the right tail is longer, negative when the left is."
    :calc="['engine' => 'st-desc', 'tool' => 'skewness', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the skewness of the example?', 'answer' => '1.53738.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 3, 3, 4, 4, 4, 5, 5, 6, 9, 12" rows="3" />

    <x-calc.result label="Sample skewness G₁" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 3, 3, 4, 4, 4, 5, 5, 6, 9, 12'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g1' => ['label' => 'Population skewness g₁'],
            'b1' => ['label' => 'b₁ (Minitab)'],
            'pearson' => ['label' => 'Pearson’s 2nd: 3(mean − median)/s'],
            'se' => ['label' => 'Standard error of G₁'],
            'z' => ['label' => 'z = G₁ ÷ SE'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
