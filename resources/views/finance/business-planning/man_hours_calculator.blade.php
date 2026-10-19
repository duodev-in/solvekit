<x-calc.page
    title="Man-Hours Calculator - SolveKit"
    description="Free Man-Hours Calculator: man-hours = people × hours a day × days. Man-hours (person-hours) measure the total work in a job."
    lede="Work out the man-hours from people, hours a day and days."
    about="Man-hours (person-hours) measure the total work in a job. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'man_hours', 'fields' => ['people', 'hours', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'People, Hours a day, Days.'],
        ['name' => 'Read the result', 'text' => 'The man-hours appears as you type, with person-days of 8 hours below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the man-hours?', 'answer' => 'Man-hours = people × hours a day × days.'],
        ['question' => 'What is the man-hours for people 6, hours a day 8, days 15?', 'answer' => '720 hours. Person-days of 8 hours: 90.'],
        ['question' => 'And for people 3, hours a day 7.5, days 20?', 'answer' => '450 hours. Person-days of 8 hours: 56.25.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 720 person-hour job takes 9 days for a crew of 10 working 8 hours.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="People" value="6" min="0" step="1" />
        <x-calc.field name="hours" label="Hours a day" value="8" min="0" step="any" suffix="hours" />
        <x-calc.field name="days" label="Days" value="15" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Man-hours" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['people' => 6, 'hours' => 8, 'days' => 15],
        'Example B' => ['people' => 3, 'hours' => 7.5, 'days' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Person-days of 8 hours'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>man-hours = people × hours a day × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
