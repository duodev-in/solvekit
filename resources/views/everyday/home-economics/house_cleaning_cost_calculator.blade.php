<x-calc.page
    title="House Cleaning Cost Calculator - SolveKit"
    description="Free house cleaning cost calculator: the cost of a cleaner per visit, per month and per year, by the hour or by the room."
    lede="Work out what a house cleaner costs."
    about="Cleaners charge by the hour (hours × rate × number of cleaners) or by the room. Weekly cleans take less time each than monthly ones. Enter your local quotes; prices vary widely by city."
    :calc="['engine' => 'ev-home', 'tool' => 'cleaning', 'fields' => ['mode', 'hours', 'rate', 'cleaners', 'rooms', 'room_price', 'bathrooms', 'bath_price', 'frequency', 'tip']]"
    :how-to="[
        ['name' => 'Choose how it is priced', 'text' => 'Hourly or per room.'],
        ['name' => 'Pick how often', 'text' => 'And any tip.'],
    ]"
    :faqs="[
        ['question' => 'How much is a cleaner every two weeks?', 'answer' => 'At 3 hours and $35 an hour plus 10% tip, $115.50 a visit, about $250 a month.'],
        ['question' => 'Is it cheaper weekly?', 'answer' => 'Often per visit, as each clean is quicker.'],
        ['question' => 'Should I tip?', 'answer' => 'Many people tip 10–20%, especially for independent cleaners.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Priced by" :options="['hourly' => 'The hour', 'rooms' => 'The room']" selected="hourly" />

    <div data-show-when="mode:hourly">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="hours" label="Hours per clean" value="3" min="0.5" step="0.5" />
            <x-calc.field name="rate" label="Rate per cleaner-hour" value="35" min="0" step="0.01" suffix="$" />
            <x-calc.field name="cleaners" label="Cleaners" value="1" min="1" step="1" />
        </div>
    </div>

    <div data-show-when="mode:rooms" hidden>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="rooms" label="Rooms" value="5" min="1" step="1" />
            <x-calc.field name="room_price" label="Per room" value="25" min="0" step="0.01" suffix="$" />
            <x-calc.field name="bathrooms" label="Bathrooms" value="2" min="0" step="1" />
            <x-calc.field name="bath_price" label="Per bathroom" value="30" min="0" step="0.01" suffix="$" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="frequency" label="How often" :options="['weekly' => 'Weekly', 'biweekly' => 'Every two weeks', 'monthly' => 'Monthly', 'once' => 'One-off']" selected="biweekly" />
        <x-calc.field name="tip" label="Tip" value="10" min="0" max="50" step="1" suffix="%" />
    </div>

    <x-calc.result label="Cost per clean" />

    <x-calc.options :decimals="false" :examples="[
        '3 h at $35, biweekly' => ['mode' => 'hourly', 'hours' => 3, 'rate' => 35, 'cleaners' => 1, 'rooms' => '', 'room_price' => '', 'bathrooms' => '', 'bath_price' => '', 'frequency' => 'biweekly', 'tip' => 10],
        'Team of 2, monthly' => ['mode' => 'hourly', 'hours' => 2.5, 'rate' => 30, 'cleaners' => 2, 'rooms' => '', 'room_price' => '', 'bathrooms' => '', 'bath_price' => '', 'frequency' => 'monthly', 'tip' => 15],
        'By the room, weekly' => ['mode' => 'rooms', 'hours' => '', 'rate' => '', 'cleaners' => 1, 'rooms' => 5, 'room_price' => 20, 'bathrooms' => 2, 'bath_price' => 25, 'frequency' => 'weekly', 'tip' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'year' => ['label' => 'Per year'],
            'month' => ['label' => 'Per month'],
            'cleans' => ['label' => 'Cleans'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per clean = hours × rate × cleaners (or rooms × price)</li>
            <li>year = per clean × cleans a year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
