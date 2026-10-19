<x-calc.page
    title="Week Over Week Calculator - SolveKit"
    description="Free Week Over Week Calculator: WoW = (this week − last week) ÷ last week. Week-over-week growth compares a metric with the previous week."
    lede="Work out the week-over-week change from last week and this week."
    about="Week-over-week growth compares a metric with the previous week. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'week_over_week', 'fields' => ['last', 'this']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Last week, This week.'],
        ['name' => 'Read the result', 'text' => 'The week-over-week change appears as you type, with change below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the week-over-week change?', 'answer' => 'WoW = (this week − last week) ÷ last week.'],
        ['question' => 'What is the week-over-week change for last week 1,200, this week 1,350?', 'answer' => '12.5%. Change: 150.'],
        ['question' => 'And for last week 840, this week 790?', 'answer' => '−5.952%. Change: −50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Weekly figures are noisy; look at several weeks.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="last" label="Last week" value="1200" step="any" />
        <x-calc.field name="this" label="This week" value="1350" step="any" />
    </div>

    <x-calc.result label="Week-over-week change" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['last' => 1200, 'this' => 1350],
        'Example B' => ['last' => 840, 'this' => 790],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Change'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WoW = (this week − last week) ÷ last week</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
