<x-calc.page
    title="Age Difference Calculator - SolveKit"
    description="Free age difference calculator: the gap between two people's ages in years, months and days, weeks and days, and who is older."
    lede="Find the age gap between two people."
    about="The gap is the calendar difference between the two birth dates: whole years, whole months and days. It stays the same all their lives. Total days count every day between the dates, including leap days."
    :calc="['engine' => 'ev-time', 'tool' => 'age_difference', 'fields' => ['first', 'first_name', 'second', 'second_name']]"
    :how-to="[
        ['name' => 'Enter both birth dates', 'text' => 'Add names if you like.'],
    ]"
    :faqs="[
        ['question' => 'Does an age gap change over time?', 'answer' => 'No; the difference between birth dates is fixed, only its share of each age shrinks.'],
        ['question' => 'How do I compare someone born 12 March 1988 and 4 November 1992?', 'answer' => '4 years, 7 months and 23 days apart.'],
        ['question' => 'Are leap years counted?', 'answer' => 'Yes, total days count every real day.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="first" label="First date of birth" value="1988-03-12" type="date" />
        <x-calc.field name="first_name" label="Name (optional)" value="" type="text" placeholder="Person 1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="second" label="Second date of birth" value="1992-11-04" type="date" />
        <x-calc.field name="second_name" label="Name (optional)" value="" type="text" placeholder="Person 2" />
    </div>

    <x-calc.result label="Age difference" />

    <x-calc.options :decimals="false" :examples="[
        '1988 and 1992' => ['first' => '1988-03-12', 'first_name' => 'Sam', 'second' => '1992-11-04', 'second_name' => 'Alex'],
        'Twins a day apart' => ['first' => '2001-12-31', 'first_name' => '', 'second' => '2002-01-01', 'second_name' => ''],
        'Grandparent and grandchild' => ['first' => '1950-06-01', 'first_name' => '', 'second' => '2015-09-20', 'second_name' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'years' => ['label' => 'In years'],
            'months' => ['label' => 'In months'],
            'weeks' => ['label' => 'In weeks'],
            'days' => ['label' => 'In days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gap = whole years, months and days from the earlier date to the later</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
