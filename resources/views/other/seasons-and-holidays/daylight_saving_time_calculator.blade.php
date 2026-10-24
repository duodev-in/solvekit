<x-calc.page
    title="Daylight Saving Time Calculator - SolveKit"
    description="Free daylight saving time calculator: when clocks change in the US, EU, UK, Australia and New Zealand."
    lede="Find when the clocks change."
    about="Clock changes follow fixed rules in each region, such as the second Sunday in March in the US."
    :calc="['engine' => 'ot-misc', 'tool' => 'dst', 'fields' => ['year', 'region'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'When do US clocks go forward in 2027?', 'answer' => 'Sunday 14 March 2027 at 2:00 local.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="year" label="Year" value="2027" min="2008" step="any" />
        <x-calc.select name="region" label="Region" :options="['us' => 'United States and Canada', 'eu' => 'European Union', 'uk' => 'United Kingdom', 'au' => 'Australia (NSW, Vic, SA, Tas, ACT)', 'nz' => 'New Zealand']" selected="us" />
    </div>

    <x-calc.result label="Clocks go forward" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['year' => 2027, 'region' => 'us'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'back' => ['label' => 'Clocks go back'],
            'length' => ['label' => 'Length of daylight saving'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
