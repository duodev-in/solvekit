<x-calc.page
    title="Bertrand's Box Paradox - SolveKit"
    description="Free Bertrand's box paradox calculator: why the other coin is gold with probability 2/3, with a repeatable simulation."
    lede="See Bertrand's box paradox."
    about="Three boxes hold two gold coins, two silver coins, and one of each. You draw a gold coin from a random box. The chance that the other coin in that box is also gold is 2/3, not 1/2."
    :calc="['engine' => 'st-prob', 'tool' => 'bertrand_box', 'fields' => ['trials', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What share of simulated draws confirms 2/3?', 'answer' => '0.669451 (3,366 of 5,028).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="trials" label="Simulated trials" value="10000" min="1" step="any" />
        <x-calc.field name="seed" label="Simulation seed (same seed, same run)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="P(the other coin is gold | you drew gold)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['trials' => 10000, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact answer'],
            'sim' => ['label' => 'Simulated share'],
            'counted' => ['label' => 'Gold draws counted'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
