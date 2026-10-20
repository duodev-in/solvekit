<x-calc.page
    title="Mann-Whitney U Test Calculator - SolveKit"
    description="Free Mann–Whitney U test calculator: exact or normal-approximation p-value for two independent samples."
    lede="Run a Mann–Whitney U test."
    about="The Mann–Whitney U test compares two independent samples using ranks, without assuming normal data."
    :calc="['engine' => 'st-inf', 'tool' => 'mann_whitney', 'fields' => ['a', 'b', 'tail', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is U for the example?', 'answer' => '1.5 (p = 0.001062).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="Sample 1" value="12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3" rows="3" />
        <x-calc.textarea name="b" label="Sample 2" value="15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9" rows="3" />
        <x-calc.select name="tail" label="Alternative hypothesis" :options="['two' => 'Two-tailed (≠)', 'left' => 'Left-tailed (<)', 'right' => 'Right-tailed (>)']" selected="two" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="U" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '12.1, 14.3, 11.8, 15.2, 13.6, 12.9, 14.8, 13.3', 'b' => '15.4, 16.2, 14.9, 17.8, 15.9, 16.6, 18.1, 15.2, 16.9', 'tail' => 'two', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'u12' => ['label' => 'U₁ and U₂'],
            'method' => ['label' => 'Method'],
            'r' => ['label' => 'Effect size r'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
