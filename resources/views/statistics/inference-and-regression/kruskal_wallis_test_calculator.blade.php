<x-calc.page
    title="Kruskal-Wallis Test Calculator - SolveKit"
    description="Free Kruskal–Wallis test calculator: H statistic and p-value for three or more independent groups."
    lede="Run a Kruskal–Wallis test."
    about="The Kruskal–Wallis test compares several groups using ranks, a non-parametric alternative to one-way ANOVA."
    :calc="['engine' => 'st-inf', 'tool' => 'kruskal', 'fields' => ['data', 'alpha'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is H for the example?', 'answer' => '2.8538 (p = 0.2401).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Groups: one per line, optionally named" value="A: 27, 2, 4, 18, 7, 9
B: 20, 8, 14, 36, 21, 22
C: 34, 31, 3, 23, 30, 6" rows="3" />
        <x-calc.field name="alpha" label="Significance level α" value="0.05" min="0" step="any" />
    </div>

    <x-calc.result label="H statistic" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => 'A: 27, 2, 4, 18, 7, 9
B: 20, 8, 14, 36, 21, 22
C: 34, 31, 3, 23, 30, 6', 'alpha' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'df' => ['label' => 'Degrees of freedom'],
            'eps' => ['label' => 'ε² (effect size)'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Mean ranks" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
