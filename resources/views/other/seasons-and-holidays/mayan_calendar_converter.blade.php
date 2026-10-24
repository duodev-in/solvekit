<x-calc.page
    title="Mayan Calendar Converter - SolveKit"
    description="Free Mayan calendar converter: Long Count, Tzolk’in and Haab’ for any date, and Long Count back to a date."
    lede="Convert dates to the Mayan calendar."
    about="The Maya counted days in the Long Count and two cycles, the 260-day Tzolk’in and the 365-day Haab’."
    :calc="['engine' => 'ot-misc', 'tool' => 'mayan', 'fields' => ['mode', 'date', 'lc'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What was 21 December 2012?', 'answer' => '13.0.0.0.0, 4 Ajaw 3 K’ank’in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Convert" :options="['toMaya' => 'A date → Mayan calendar', 'fromMaya' => 'A Long Count → date']" selected="toMaya" />
        <div data-show-when="mode:toMaya">
            <x-calc.field name="date" label="Date" value="2012-12-21" type="date" />
        </div>
        <div data-show-when="mode:fromMaya">
            <x-calc.field name="lc" label="Long Count (b.k.t.u.k)" value="13.0.0.0.0" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Long Count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'toMaya', 'date' => '2012-12-21', 'lc' => '13.0.0.0.0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tzolkin' => ['label' => 'Tzolk’in'],
            'haab' => ['label' => 'Haab’'],
            'lord' => ['label' => 'Lord of the Night'],
            'date' => ['label' => 'Gregorian date'],
            'days' => ['label' => 'Days since the Long Count began'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
