<x-calc.page
    title="TV Alternatives Calculator - SolveKit"
    description="Free TV alternatives calculator: the hours a year you spend watching TV and what else that time could do."
    lede="See what your TV time could do instead."
    about="Hours a year = hours a day × 365.25. The same time could read novels (about 6.3 hours each at average speed), learn a language (600–750 class hours for Spanish or French, US Foreign Service Institute) or run the NHS Couch to 5K plan (about 13.5 hours) many times over."
    :calc="['engine' => 'ev-fun', 'tool' => 'screen_time', 'fields' => ['amount', 'unit']]"
    :how-to="[
        ['name' => 'Enter your daily TV time', 'text' => 'In hours or minutes.'],
    ]"
    :faqs="[
        ['question' => 'How much TV is 3 hours a day?', 'answer' => 'About 1,096 hours a year: over 45 days.'],
        ['question' => 'What could I do instead?', 'answer' => 'Read about 173 novels, or learn a language well.'],
        ['question' => 'How much TV do Americans watch?', 'answer' => 'The American Time Use Survey puts it near 3 hours a day.'],
    ]"
>
    <x-calc.field name="amount" label="TV a day" value="3" min="0.25" step="0.25" />

    <x-calc.segmented name="unit" legend="Entered in" :options="['hours' => 'Hours', 'minutes' => 'Minutes']" selected="hours" />

    <x-calc.result label="Time spent" />

    <x-calc.options :decimals="false" :examples="[
        '3 hours' => ['amount' => 3, 'unit' => 'hours'],
        '90 minutes' => ['amount' => 90, 'unit' => 'minutes'],
        '5 hours' => ['amount' => 5, 'unit' => 'hours'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'books' => ['label' => 'Books'],
            'language' => ['label' => 'Language'],
            'run' => ['label' => 'Running'],
            'life' => ['label' => 'Waking hours'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = hours a day × 365.25</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
