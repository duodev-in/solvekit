<x-calc.page
    title="Tennis Ball Usage Calculator - SolveKit"
    description="Free tennis ball usage calculator: cans a year and cost."
    lede="Find how many tennis balls you use."
    about="Balls lose pressure with play; club players often change every few hours."
    :calc="['engine' => 'sp-misc', 'tool' => 'tennis_balls', 'fields' => ['sessions', 'hours', 'life', 'price', 'weeks'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many cans a year for the example player?', 'answer' => '69.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sessions" label="Sessions a week" value="3" min="0" step="any" />
        <x-calc.field name="hours" label="Hours per session" value="1.5" min="0" step="any" />
        <x-calc.field name="life" label="Hours of play a can lasts" value="3" min="0.5" step="any" />
        <x-calc.field name="price" label="Price of a can (3 or 4 balls)" value="5" min="0" step="any" suffix="$" />
        <x-calc.field name="weeks" label="Weeks played a year" value="46" min="1" step="any" />
    </div>

    <x-calc.result label="Cans a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sessions' => 3, 'hours' => 1.5, 'life' => 3, 'price' => 5, 'weeks' => 46],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cost' => ['label' => 'Cost a year'],
            'perHour' => ['label' => 'Cost per hour of play'],
            'perWeek' => ['label' => 'Cans a week'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
