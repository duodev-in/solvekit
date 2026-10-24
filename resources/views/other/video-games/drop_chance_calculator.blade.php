<x-calc.page
    title="Drop Chance Calculator - SolveKit"
    description="Free drop chance calculator: chance of a rare drop in a number of tries, and tries needed for 50, 90 or 99%."
    lede="Find your drop chance."
    about="Each attempt is independent, so the chance of at least one drop is 1 − (1 − p)ⁿ."
    :calc="['engine' => 'ot-play', 'tool' => 'drop_chance', 'fields' => ['rate', 'attempts'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of a 1/512 drop in 500 kills?', 'answer' => '62.376%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Drop rate (1/512, 0.5% or 0.002)" value="1/512" type="text" inputmode="text" />
        <x-calc.field name="attempts" label="Attempts (kills, pulls, chests)" value="500" min="0" step="any" />
    </div>

    <x-calc.result label="Chance of at least one drop" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => '1/512', 'attempts' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'expected' => ['label' => 'Expected attempts (average)'],
            'p50' => ['label' => 'Attempts for 50%'],
            'p90' => ['label' => 'Attempts for 90%'],
            'p99' => ['label' => 'Attempts for 99%'],
            'none' => ['label' => 'Chance of no drop'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
