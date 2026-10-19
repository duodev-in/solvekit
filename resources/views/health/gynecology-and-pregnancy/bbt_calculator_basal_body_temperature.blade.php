<x-calc.page
    title="BBT Calculator | Basal Body Temperature - SolveKit"
    description="Free BBT calculator: find the temperature shift and coverline in your basal body temperature chart with the three-over-six rule."
    lede="Find the ovulation shift in your BBT chart."
    about="Progesterone after ovulation raises the resting temperature by about 0.2–0.5 °C (0.4–1 °F). The three-over-six rule used in fertility awareness methods looks for three readings above the highest of the previous six, the third at least 0.1 °C (0.2 °F) above it; ovulation most likely happened the day before the rise. Take the temperature at the same time every morning before getting up. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'bbt', 'fields' => ['temps', 'unit']]"
    :how-to="[
        ['name' => 'Enter one reading per day', 'text' => ''],
        ['name' => 'Choose the unit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Where is the shift in the example chart?', 'answer' => 'Day 14 (Temperature rise confirmed from day 15; coverline 36.55 °C).'],
    ]"
>
    <x-calc.rows-editor name="temps" label="Daily readings (cycle day, temperature)" :columns="['day' => 'Cycle day', 'temp' => 'Temperature']" :rows="[['8', '36.4'], ['9', '36.3'], ['10', '36.4'], ['11', '36.5'], ['12', '36.3'], ['13', '36.4'], ['14', '36.4'], ['15', '36.7'], ['16', '36.8'], ['17', '36.8'], ['18', '36.9'], ['19', '36.8']]" add-label="Add day" />

    <x-calc.segmented name="unit" legend="Unit" :options="['c' => '°C', 'f' => '°F']" selected="c" />

    <x-calc.result label="Likely ovulation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['temps' => '8 36.4
9 36.3
10 36.4
11 36.5
12 36.3
13 36.4
14 36.4
15 36.7
16 36.8
17 36.8
18 36.9
19 36.8', 'unit' => 'c'],
        'Fahrenheit' => ['temps' => '10 97.4
11 97.5
12 97.3
13 97.4
14 97.6
15 97.4
16 97.5
17 97.9
18 98.0
19 98.1
20 98.0
21 98.1', 'unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cover' => ['label' => 'Coverline'],
            'rise' => ['label' => 'After the shift'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Chart" name="temps" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>three readings > max of previous six</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
