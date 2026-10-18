<x-calc.page
    title="Social Media Time Alternatives Calculator - SolveKit"
    description="Free social media time alternatives calculator: the hours a year spent on social media and what else that time could do."
    lede="See what your social media time could buy instead."
    about="Hours a year = minutes a day × 365.25 ÷ 60. A 90,000-word novel takes about 6.3 hours at the adult reading average of 238 words a minute; the US Foreign Service Institute estimates 600–750 class hours for a language such as Spanish; the NHS Couch to 5K plan is about 13.5 hours of running."
    :calc="['engine' => 'ev-fun', 'tool' => 'screen_time', 'fields' => ['amount', 'unit']]"
    :how-to="[
        ['name' => 'Enter your daily time', 'text' => 'From your phone\'s screen-time report.'],
    ]"
    :faqs="[
        ['question' => 'How much time is 2 hours a day on social media?', 'answer' => 'About 730 hours a year, or 30 full days.'],
        ['question' => 'How many books is that?', 'answer' => 'About 115 novels.'],
        ['question' => 'Is 145 minutes typical?', 'answer' => 'Global surveys put average daily social media use at around two and a half hours.'],
    ]"
>
    <x-calc.field name="amount" label="Minutes a day on social media" value="145" min="1" step="5" />

    <x-calc.segmented name="unit" legend="Entered in" :options="['minutes' => 'Minutes', 'hours' => 'Hours']" selected="minutes" />

    <x-calc.result label="Time spent" />

    <x-calc.options :decimals="false" :examples="[
        '145 minutes' => ['amount' => 145, 'unit' => 'minutes'],
        '1 hour' => ['amount' => 1, 'unit' => 'hours'],
        '4 hours' => ['amount' => 4, 'unit' => 'hours'],
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
            <li>hours = minutes × 365.25 ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
