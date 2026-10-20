<x-calc.page
    title="Kendall's Tau Calculator - SolveKit"
    description="Free Kendall's tau calculator: τ-b with tie correction, concordant and discordant pairs and a p-value."
    lede="Find Kendall's τ."
    about="Kendall's τ compares every pair of observations: it is the excess of pairs ordered the same way over pairs ordered oppositely."
    :calc="['engine' => 'st-desc', 'tool' => 'kendall', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is τ for the example?', 'answer' => '0.777778.'],
    ]"
>
    <x-calc.textarea name="data" label="x, y pairs (one per line)" value="1, 2
2, 1
3, 4
4, 3
5, 6
6, 5
7, 8
8, 9
9, 7
10, 10" rows="10" />

    <x-calc.result label="Kendall τ-b" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1, 2
2, 1
3, 4
4, 3
5, 6
6, 5
7, 8
8, 9
9, 7
10, 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value (two-sided)'],
            'pairs' => ['label' => 'Concordant / discordant pairs'],
            'method' => ['label' => 'p-value method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
