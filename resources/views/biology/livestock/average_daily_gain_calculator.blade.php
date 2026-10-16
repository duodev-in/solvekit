<x-calc.page
    title="Average Daily Gain Calculator - SolveKit"
    description="Free average daily gain calculator: ADG from start and end weights, weekly gain and days to a target weight."
    lede="Work out average daily gain and days to a target weight."
    about="Average daily gain (ADG) is the weight gained divided by the days between weighings. It is the main measure of growth for calves, stockers, lambs and pigs, and with a target weight it projects the days still needed."
    :calc="['engine' => 'livestock', 'tool' => 'adg', 'fields' => ['unit', 'start', 'end', 'days', 'target']]"
    :how-to="[
        ['name' => 'Enter both weights', 'text' => 'From two weighings.'],
        ['name' => 'Enter the days', 'text' => 'Between the weighings.'],
        ['name' => 'Add a target', 'text' => 'For days to go.'],
    ]"
    :faqs="[
        ['question' => 'What is a good ADG for steers?', 'answer' => 'About 2 to 3.5 lb a day on feed, less on grass.'],
        ['question' => 'What about lambs?', 'answer' => 'About 0.5 to 0.75 lb (0.2 to 0.35 kg) a day.'],
        ['question' => 'Why does ADG fall?', 'answer' => 'Growth slows as animals mature, and feed quality matters.'],
    ]"
>
    <x-calc.segmented name="unit" legend="Weight unit" :options="['lb' => 'lb', 'kg' => 'kg']" selected="lb" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Start weight" value="550" min="0" />
        <x-calc.field name="end" label="End weight" value="760" min="0" />
        <x-calc.field name="days" label="Days" value="100" min="0" step="1" />
    </div>

    <x-calc.field name="target" label="Target weight (optional)" value="900" min="0" placeholder="Optional" />

    <x-calc.result label="Average daily gain" />

    <x-calc.options :examples="[
        'Stocker steer' => ['unit' => 'lb', 'start' => 550, 'end' => 760, 'days' => 100, 'target' => 900],
        'Lamb' => ['unit' => 'kg', 'start' => 20, 'end' => 38, 'days' => 60, 'target' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weekly' => ['label' => 'Per week'],
            'total' => ['label' => 'Total gain'],
            'target' => ['label' => 'To target'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ADG = (end − start) ÷ days</li>
            <li>days to target = (target − end) ÷ ADG</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
