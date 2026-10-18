<x-calc.page
    title="TikTok Time Alternatives Calculator - SolveKit"
    description="Free TikTok time alternatives calculator: the hours a year you spend on TikTok and what else that time could do, from books to languages to running."
    lede="See how much time TikTok takes and what else it could buy."
    about="Hours a year = minutes a day × 365.25 ÷ 60. Equivalents: a 90,000-word novel takes about 6.3 hours at the average adult reading speed of 238 words a minute (Brysbaert 2019); the US Foreign Service Institute estimates 600–750 class hours to reach professional working ability in languages such as Spanish or French; the NHS Couch to 5K plan is 9 weeks of three runs of about 30 minutes."
    :calc="['engine' => 'ev-care', 'tool' => 'screen_time', 'fields' => ['minutes']]"
    :how-to="[
        ['name' => 'Enter your daily minutes', 'text' => 'From your phone\'s screen-time report.'],
    ]"
    :faqs="[
        ['question' => 'How much time is 95 minutes a day?', 'answer' => 'About 578 hours a year, or 24 full days.'],
        ['question' => 'How many books is that?', 'answer' => 'About 91 novels.'],
        ['question' => 'Where do I find my screen time?', 'answer' => 'In Screen Time (iOS) or Digital Wellbeing (Android).'],
    ]"
>
    <x-calc.field name="minutes" label="Minutes a day on TikTok" value="95" min="1" step="5" />

    <x-calc.result label="Time spent" />

    <x-calc.options :decimals="false" :examples="[
        '95 minutes a day' => ['minutes' => 95],
        '30 minutes a day' => ['minutes' => 30],
        '3 hours a day' => ['minutes' => 180],
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
