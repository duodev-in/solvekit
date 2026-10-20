<x-calc.page
    title="Miracle Calculator - SolveKit"
    description="Miracle calculator: Littlewood's law, how often one-in-a-million events happen to an ordinary person."
    lede="How often do miracles happen?"
    about="Littlewood counted about one noticeable event per second over eight alert hours a day: 28,800 a day, a million in about 35 days. So a one-in-a-million coincidence should happen to each of us roughly once a month; rare events are common when there are many chances. Also known as Littlewood's law calculator."
    :calc="['engine' => 'mt-other', 'tool' => 'miracle', 'fields' => ['rate', 'hours', 'odds', 'days']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'How long until a one-in-a-million event?', 'answer' => 'About 34.722222 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Events noticed per second" value="1" min="0" step="any" />
        <x-calc.field name="hours" label="Alert hours per day" value="8" min="0" max="24" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="odds" label="Odds: one in …" value="1000000" min="1" step="any" />
        <x-calc.field name="days" label="Over how many days" value="30" min="1" step="any" />
    </div>

    <x-calc.result label="Days per one-in-a-million event" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => 1, 'hours' => 8, 'odds' => 1000000, 'days' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perDay' => ['label' => 'Events per day'],
            'expected' => ['label' => 'Expected miracles'],
            'chance' => ['label' => 'Chance of at least one'],
            'lesson' => ['label' => 'Why'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = odds ÷ events per day</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
