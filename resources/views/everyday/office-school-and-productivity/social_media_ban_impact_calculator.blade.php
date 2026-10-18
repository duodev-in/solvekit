<x-calc.page
    title="Social Media Ban Impact Calculator - SolveKit"
    description="Free social media ban impact calculator: the time freed each year by cutting or quitting social media, in hours, days, books and work weeks."
    lede="See how much time you get back by cutting social media."
    about="Time freed = (minutes a day before − after) × 365.25. Your phone's screen-time report shows your real figure. A 90,000-word novel takes about 6.3 hours at the average reading speed of 238 words a minute."
    :calc="['engine' => 'ev-office', 'tool' => 'social_ban', 'fields' => ['before', 'after']]"
    :how-to="[
        ['name' => 'Enter your current use', 'text' => 'From screen time.'],
        ['name' => 'Enter your target', 'text' => '0 for a full ban.'],
    ]"
    :faqs="[
        ['question' => 'How much time does 2 hours a day of social media take?', 'answer' => '730 hours a year, about 30 full days.'],
        ['question' => 'What if I cut 145 to 30 minutes?', 'answer' => 'About 700 hours a year freed.'],
        ['question' => 'Where do I see my use?', 'answer' => 'Screen Time on iPhone, Digital Wellbeing on Android.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="before" label="Minutes a day now" value="145" min="1" step="5" />
        <x-calc.field name="after" label="Minutes a day after" value="30" min="0" step="5" />
    </div>

    <x-calc.result label="Time freed" />

    <x-calc.options :decimals="false" :examples="[
        '145 → 30 min' => ['before' => 145, 'after' => 30],
        'Full ban from 2 h' => ['before' => 120, 'after' => 0],
        'Halve 60 min' => ['before' => 60, 'after' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'In days'],
            'books' => ['label' => 'Books'],
            'workweeks' => ['label' => 'Work weeks'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = (before − after) × 365.25 ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
