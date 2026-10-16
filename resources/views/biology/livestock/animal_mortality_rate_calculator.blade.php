<x-calc.page
    title="Animal Mortality Rate Calculator - SolveKit"
    description="Free animal mortality rate calculator: death rate, survival and annualised mortality for a herd or flock."
    lede="Work out mortality and survival for a herd or flock."
    about="Mortality rate is the number that died divided by the number at the start of the period. With the period length it is converted to a yearly rate assuming the same risk all year, which makes batches of different lengths comparable."
    :calc="['engine' => 'livestock', 'tool' => 'mortality', 'fields' => ['deaths', 'population', 'days']]"
    :how-to="[
        ['name' => 'Enter deaths', 'text' => 'In the period.'],
        ['name' => 'Enter the starting number', 'text' => 'Animals at the start.'],
        ['name' => 'Add the period', 'text' => 'For a yearly rate.'],
    ]"
    :faqs="[
        ['question' => 'What mortality is normal for broilers?', 'answer' => 'About 3 to 5% over a grow-out.'],
        ['question' => 'What about calves?', 'answer' => 'Pre-weaning losses of under 5% are a common target.'],
        ['question' => 'Why annualise?', 'answer' => 'To compare periods of different lengths.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="deaths" label="Deaths" value="12" min="0" step="1" />
        <x-calc.field name="population" label="Animals at start" value="400" min="0" step="1" />
        <x-calc.field name="days" label="Period (optional)" value="42" min="0" suffix="days" />
    </div>

    <x-calc.result label="Mortality rate" />

    <x-calc.options :examples="[
        'Broiler batch' => ['deaths' => 12, 'population' => 400, 'days' => 42],
        'Calf crop' => ['deaths' => 3, 'population' => 80, 'days' => 205],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'survival' => ['label' => 'Survival'],
            'annual' => ['label' => 'Annualised'],
            'alive' => ['label' => 'Still alive'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = deaths ÷ animals at start</li>
            <li>annual = 1 − (1 − rate)^(365 ÷ days)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
