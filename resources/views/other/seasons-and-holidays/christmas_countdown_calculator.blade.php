<x-calc.page
    title="Christmas Countdown Calculator - SolveKit"
    description="Free Christmas countdown: days until Christmas, New Year, Valentine’s Day, Easter, Halloween, Thanksgiving or the first day of autumn."
    lede="Count down to the holidays."
    about="The countdown counts whole days from today (or any date) to the holiday. Also known as Days Until Fall Calculator, Days Until Valentine's Day Calculator and New Year Countdown Calculator."
    :calc="['engine' => 'ot-misc', 'tool' => 'countdown', 'fields' => ['holiday', 'date', 'from'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many sleeps until Christmas?', 'answer' => 'The page counts from today’s date; change “Counting from” to plan ahead.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="holiday" label="Holiday" :options="['christmas' => 'Christmas (25 December)', 'newyear' => 'New Year’s Day (1 January)', 'valentine' => 'Valentine’s Day (14 February)', 'easter' => 'Easter Sunday', 'halloween' => 'Halloween (31 October)', 'thanksgiving' => 'Thanksgiving (US, 4th Thursday of November)', 'fall' => 'First day of autumn (September equinox)', 'custom' => 'Another date']" selected="christmas" />
        <div data-show-when="holiday:custom">
            <x-calc.field name="date" label="Date (for another date)" value="2026-12-31" type="date" />
        </div>
        <x-calc.field name="from" label="Counting from (blank = today)" value="" type="date" />
    </div>

    <x-calc.result label="Days to go" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['holiday' => 'christmas', 'date' => '2026-12-31', 'from' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'when' => ['label' => 'Date'],
            'weekday' => ['label' => 'Day of the week'],
            'weeks' => ['label' => 'Weeks and days'],
            'sleeps' => ['label' => 'Sleeps'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
