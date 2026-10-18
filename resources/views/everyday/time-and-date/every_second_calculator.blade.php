<x-calc.page
    title="Every Second Calculator - SolveKit"
    description="Free every second calculator: how many seconds, minutes, hours and days you have been alive, counting live, and when you turn a billion seconds old."
    lede="See how many seconds you have been alive, counting up live."
    about="Seconds alive = now − the moment you were born, from your date and time of birth and your device's clock. Without a birth time, midnight is used. Heartbeats and breaths use typical resting rates (70 a minute and 15 a minute) and are only estimates. A billion seconds is about 31.7 years."
    :calc="['engine' => 'ev-time', 'tool' => 'every_second', 'fields' => ['birth', 'time']]"
    :how-to="[
        ['name' => 'Enter your birth date', 'text' => 'And the time if you know it.'],
        ['name' => 'Watch it count', 'text' => 'The total updates every second.'],
    ]"
    :faqs="[
        ['question' => 'How many seconds are in a year?', 'answer' => '31,536,000 in a common year, 31,622,400 in a leap year.'],
        ['question' => 'When am I a billion seconds old?', 'answer' => 'About 31 years and 8 months after birth: someone born at midnight on 1 January 2000 reaches it at 1:46 AM on 9 September 2031.'],
        ['question' => 'How many seconds are in a day?', 'answer' => '86,400.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="1995-08-24" type="date" />

    <x-calc.field name="time" label="Time of birth (optional)" value="" type="time" />

    <x-calc.result label="You have been alive for" />

    <x-calc.options :decimals="false" :examples="[
        'Born 24 Aug 1995' => ['birth' => '1995-08-24', 'time' => ''],
        'Born at 6:30 AM, 2000' => ['birth' => '2000-01-01', 'time' => '06:30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'minutes' => ['label' => 'Minutes'],
            'hours' => ['label' => 'Hours'],
            'days' => ['label' => 'Days'],
            'weeks' => ['label' => 'Weeks'],
            'heart' => ['label' => 'Heartbeats'],
            'breaths' => ['label' => 'Breaths'],
            'billion' => ['label' => 'A billion seconds'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>seconds = now − birth moment</li>
            <li>a billion seconds ≈ 31.69 years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
