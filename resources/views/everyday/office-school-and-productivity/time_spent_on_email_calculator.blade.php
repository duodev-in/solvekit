<x-calc.page
    title="Time Spent on Email Calculator - SolveKit"
    description="Free time spent on email calculator: hours a year spent reading and writing email, its share of the workday and its cost."
    lede="See how much of your working year goes on email."
    about="Hours a year = emails a day × minutes each × working days ÷ 60. With about 250 working days a year, an hour a day of email is 250 hours: more than six 40-hour weeks."
    :calc="['engine' => 'ev-office', 'tool' => 'email_time', 'fields' => ['emails', 'minutes', 'days', 'workday', 'rate']]"
    :how-to="[
        ['name' => 'Enter your email habits', 'text' => 'Emails a day and minutes on each.'],
        ['name' => 'Add your workday', 'text' => 'And an hourly cost.'],
    ]"
    :faqs="[
        ['question' => 'How much time do I spend on email?', 'answer' => '60 emails at 2 minutes is 2 hours a day, 500 hours a year.'],
        ['question' => 'What share of the day is that?', 'answer' => '25% of an 8-hour day.'],
        ['question' => 'How do I cut email time?', 'answer' => 'Batch it a few times a day and turn off notifications.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="emails" label="Emails a day" value="60" min="1" step="1" />
        <x-calc.field name="minutes" label="Minutes on each" value="2" min="0.1" step="0.5" />
        <x-calc.field name="days" label="Working days a year" value="250" min="1" max="366" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="workday" label="Hours in your workday" value="8" min="1" max="24" step="0.5" />
        <x-calc.field name="rate" label="Hourly cost (optional)" value="45" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Time on email" />

    <x-calc.options :decimals="false" :examples="[
        '60 emails, 2 min' => ['emails' => 60, 'minutes' => 2, 'days' => 250, 'workday' => 8, 'rate' => 45],
        'Manager inbox' => ['emails' => 120, 'minutes' => 1.5, 'days' => 240, 'workday' => 9, 'rate' => 80],
        'Light user' => ['emails' => 20, 'minutes' => 1, 'days' => 230, 'workday' => 7.5, 'rate' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'day' => ['label' => 'Per day'],
            'share' => ['label' => 'Share of work'],
            'weeks' => ['label' => 'Work weeks'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = emails × minutes × days ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
