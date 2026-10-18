<x-calc.page
    title="Minute Calculator - SolveKit"
    description="Free minute calculator: minutes between two times, or hours and minutes turned into minutes, with hours and seconds."
    lede="Count the minutes between two times, or convert hours to minutes."
    about="Minutes between = (end − start) in minutes; if the end is earlier than the start it is taken as the next day. In convert mode, minutes = hours × 60 + minutes."
    :calc="['engine' => 'ev-time', 'tool' => 'minute', 'fields' => ['mode', 'start', 'end', 'hours', 'minutes']]"
    :how-to="[
        ['name' => 'Choose the mode', 'text' => 'Between times, or converting hours.'],
        ['name' => 'Enter the times', 'text' => 'Or the hours and minutes.'],
    ]"
    :faqs="[
        ['question' => 'How many minutes from 8:45 to 11:20?', 'answer' => '155 minutes.'],
        ['question' => 'How many minutes are in 2 hours 35 minutes?', 'answer' => '155.'],
        ['question' => 'How many minutes are in a day?', 'answer' => '1,440.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['between' => 'Between two times', 'convert' => 'Hours to minutes']" selected="between" />

    <div data-show-when="mode:between">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="start" label="Start time" value="08:45" type="time" />
            <x-calc.field name="end" label="End time" value="11:20" type="time" />
        </div>
    </div>

    <div data-show-when="mode:convert" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hours" label="Hours" value="2" min="0" step="1" />
            <x-calc.field name="minutes" label="Minutes" value="35" min="0" step="1" />
        </div>
    </div>

    <x-calc.result label="Minutes" />

    <x-calc.options :decimals="false" :examples="[
        '8:45 to 11:20' => ['mode' => 'between', 'start' => '08:45', 'end' => '11:20'],
        'Overnight 23:10 to 01:05' => ['mode' => 'between', 'start' => '23:10', 'end' => '01:05'],
        '2 h 35 min' => ['mode' => 'convert', 'hours' => 2, 'minutes' => 35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hours' => ['label' => 'Hours'],
            'seconds' => ['label' => 'Seconds'],
            'days' => ['label' => 'Days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>minutes = (end − start) ÷ 60 s</li>
            <li>minutes = hours × 60 + minutes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
