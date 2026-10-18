<x-calc.page
    title="Countdown Calculator - SolveKit"
    description="Free countdown calculator: a live countdown to any date and time in days, hours, minutes and seconds, with weekdays and sleeps left."
    lede="Count down to a date and time, live."
    about="Time left = target − now, using your device's clock and time zone, updated every second. Weekdays left count Monday–Friday before the day; sleeps count the nights. After the date passes it shows the time since."
    :calc="['engine' => 'ev-time', 'tool' => 'countdown', 'fields' => ['target']]"
    :how-to="[
        ['name' => 'Enter the date and time', 'text' => 'The countdown starts at once.'],
    ]"
    :faqs="[
        ['question' => 'How many days until Christmas?', 'answer' => 'Enter 25 December; the count updates every second.'],
        ['question' => 'Does it use my time zone?', 'answer' => 'Yes, your device\'s clock and time zone.'],
        ['question' => 'What are sleeps?', 'answer' => 'The nights left before the day.'],
    ]"
>
    <x-calc.field name="target" label="Count down to" value="2026-12-25T00:00" type="datetime-local" />

    <x-calc.result label="Time left" />

    <x-calc.options :decimals="false" :examples="[
        'Christmas 2026' => ['target' => '2026-12-25T00:00'],
        'New Year 2027' => ['target' => '2027-01-01T00:00'],
        'Summer solstice 2027' => ['target' => '2027-06-21T14:11'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'Days'],
            'hours' => ['label' => 'Hours'],
            'weeks' => ['label' => 'Weeks'],
            'workdays' => ['label' => 'Weekdays left'],
            'sleeps' => ['label' => 'Sleeps'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time left = target − now</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
