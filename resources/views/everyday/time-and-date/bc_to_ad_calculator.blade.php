<x-calc.page
    title="BC to AD Calculator - SolveKit"
    description="Free BC to AD calculator: years between dates BC and AD, correctly allowing for there being no year 0."
    lede="Count the years between a BC year and an AD year."
    about="The calendar goes from 1 BC straight to AD 1; there is no year 0. So the years between 500 BC and AD 500 are 999, not 1,000. Astronomers number 1 BC as year 0 and 2 BC as −1, which makes the difference a simple subtraction."
    :calc="['engine' => 'ev-time', 'tool' => 'bc_ad', 'fields' => ['year_a', 'era_a', 'year_b', 'era_b']]"
    :how-to="[
        ['name' => 'Enter the two years', 'text' => 'And whether each is BC or AD.'],
    ]"
    :faqs="[
        ['question' => 'How many years from 500 BC to AD 500?', 'answer' => '999, because there is no year 0.'],
        ['question' => 'How old is Rome (founded 753 BC) in 2026?', 'answer' => '2,778 years.'],
        ['question' => 'Are BCE and CE the same as BC and AD?', 'answer' => 'Yes, they use the same numbering.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="year_a" label="First year" value="753" min="1" step="1" />
        <x-calc.segmented name="era_a" legend="Era" :options="['bc' => 'BC (BCE)', 'ad' => 'AD (CE)']" selected="bc" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="year_b" label="Second year" value="2026" min="1" step="1" />
        <x-calc.segmented name="era_b" legend="Era" :options="['bc' => 'BC (BCE)', 'ad' => 'AD (CE)']" selected="ad" />
    </div>

    <x-calc.result label="Years between" />

    <x-calc.options :decimals="false" :examples="[
        'Rome, 753 BC to 2026' => ['year_a' => 753, 'era_a' => 'bc', 'year_b' => 2026, 'era_b' => 'ad'],
        '500 BC to AD 500' => ['year_a' => 500, 'era_a' => 'bc', 'year_b' => 500, 'era_b' => 'ad'],
        'Two BC years' => ['year_a' => 490, 'era_a' => 'bc', 'year_b' => 44, 'era_b' => 'bc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'astronomical' => ['label' => 'Astronomical years'],
            'centuries' => ['label' => 'Centuries'],
            'naive' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>astronomical year = 1 − BC year; AD year unchanged</li>
            <li>years = |a − b|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
