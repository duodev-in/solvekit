<x-calc.page
    title="Boy or Girl Paradox - SolveKit"
    description="Free boy or girl paradox calculator: P(two boys) is 1/3, 1/2 or 13/27 depending on what you know, with a simulation."
    lede="See the boy or girl paradox."
    about="A family has two children and at least one is a boy. The chance that both are boys is 1/3, but it becomes 1/2 if you know the older child is a boy, and 13/27 if you know a boy was born on a Tuesday."
    :calc="['engine' => 'st-prob', 'tool' => 'boy_girl', 'fields' => ['known', 'trials', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(two boys) given at least one boy?', 'answer' => '1/3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="known" label="What you know about the two children" :options="['one' => 'At least one is a boy', 'older' => 'The older child is a boy', 'tuesday' => 'At least one is a boy born on a Tuesday']" selected="one" />
        <x-calc.field name="trials" label="Simulated trials" value="10000" min="1" step="any" />
        <x-calc.field name="seed" label="Simulation seed (same seed, same run)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="P(both are boys)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['known' => 'one', 'trials' => 10000, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact answer'],
            'sim' => ['label' => 'Simulated share'],
            'families' => ['label' => 'Matching families'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
