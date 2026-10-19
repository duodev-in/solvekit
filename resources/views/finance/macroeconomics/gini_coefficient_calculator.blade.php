<x-calc.page
    title="Gini Coefficient Calculator - SolveKit"
    description="Free Gini coefficient calculator: income inequality from a list of incomes, with the Lorenz curve and the top 20% share."
    lede="Measure inequality with the Gini coefficient."
    about="Gini = Σ (2k − n − 1) xₖ ÷ (n Σ x) with incomes sorted from lowest. 0 is perfect equality and 1 means one person has everything. The US household income Gini was about 0.49 in 2025 (Census); Nordic countries are near 0.27 after taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'gini', 'fields' => ['incomes']]"
    :how-to="[
        ['name' => 'Paste incomes', 'text' => ''],
        ['name' => 'Read the Gini and Lorenz curve', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Gini of the sample incomes?', 'answer' => '0.4074.'],
        ['question' => 'And for equal incomes?', 'answer' => '0.'],
    ]"
>
    <x-calc.textarea name="incomes" label="Incomes (comma or line separated)" value="18000, 25000, 32000, 41000, 48000, 56000, 67000, 82000, 110000, 240000" rows="3" />

    <x-calc.result label="Gini coefficient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['incomes' => '18000, 25000, 32000, 41000, 48000, 56000, 67000, 82000, 110000, 240000'],
        'Equal' => ['incomes' => '50000, 50000, 50000, 50000'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Lorenz curve" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'mean' => ['label' => 'Mean'],
            'median' => ['label' => 'Median'],
            'top' => ['label' => 'Top 20% share'],
            'count' => ['label' => 'People'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>G = Σ (2k − n − 1) xₖ ÷ (n Σ x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
