<x-calc.page
    title="Anniversary Calculator - SolveKit"
    description="Free anniversary calculator: years, months and days together, the next anniversary date and countdown, and the traditional anniversary gift."
    lede="Count your time together and the days to your next anniversary."
    about="Time together is the calendar difference from your wedding or first date. The next anniversary is the same day and month in the coming year (28 February for a 29 February date in common years). The gift names follow the traditional US list (1 paper, 5 wood, 10 tin, 25 silver, 50 gold); lists differ between countries."
    :calc="['engine' => 'ev-time', 'tool' => 'anniversary', 'fields' => ['start', 'on']]"
    :how-to="[
        ['name' => 'Enter your date', 'text' => 'Wedding day or when you got together.'],
        ['name' => 'See the next one', 'text' => 'And the traditional gift for it.'],
    ]"
    :faqs="[
        ['question' => 'What is the 10th anniversary gift?', 'answer' => 'Tin (or aluminium) on the traditional list.'],
        ['question' => 'What are the big milestone anniversaries?', 'answer' => '25th silver, 40th ruby, 50th gold, 60th diamond.'],
        ['question' => 'What if we married on 29 February?', 'answer' => 'The anniversary is shown on 28 February in common years.'],
    ]"
>
    <x-calc.field name="start" label="Wedding or first date" value="2015-06-20" type="date" />

    <x-calc.field name="on" label="On date" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Together for" />

    <x-calc.options :decimals="false" :examples="[
        'Married June 2015' => ['start' => '2015-06-20', 'on' => '2026-10-18'],
        'Silver anniversary year' => ['start' => '2001-11-03', 'on' => '2026-10-18'],
        'Leap-day wedding' => ['start' => '2008-02-29', 'on' => '2026-01-15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'next' => ['label' => 'Next anniversary'],
            'left' => ['label' => 'Days to go'],
            'gift' => ['label' => 'Traditional gift'],
            'weeks' => ['label' => 'Weeks together'],
        ]" />
        <x-calc.quick-ref heading="Milestone anniversaries" name="milestones" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>together = calendar difference</li>
            <li>next = start + n years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
