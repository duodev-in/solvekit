<x-calc.page
    title="Business Days Calculator - SolveKit"
    description="Free business days calculator: working days between two dates, skipping weekends and US federal holidays or your own holiday list."
    lede="Count the working days between two dates."
    about="Every day from the start date up to the end date is checked: weekend days and holidays falling on workdays are skipped. US federal holidays follow 5 U.S.C. 6103, observed on the Friday before when they fall on a Saturday and the Monday after when on a Sunday. Add your own dates for other countries or company days off."
    :calc="['engine' => 'ev-time', 'tool' => 'business_days', 'fields' => ['start', 'end', 'include_start', 'include_end', 'weekend', 'holidays', 'holiday_list']]"
    :how-to="[
        ['name' => 'Enter the dates', 'text' => 'Choose whether to count the start and end days.'],
        ['name' => 'Pick the weekend and holidays', 'text' => 'US federal, none, or your own list.'],
    ]"
    :faqs="[
        ['question' => 'How many business days are in a year?', 'answer' => 'Usually 260 or 261 weekdays, minus holidays: about 250 in the US.'],
        ['question' => 'Are both dates counted?', 'answer' => 'Your choice: tick or untick the start and end dates.'],
        ['question' => 'What if a holiday falls on a weekend?', 'answer' => 'US federal holidays move to the nearest weekday (Friday or Monday).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="2026-11-01" type="date" />
        <x-calc.field name="end" label="End date" value="2026-12-31" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="include_start" label="Count the start date" :checked="true" />
        <x-calc.checkbox name="include_end" label="Count the end date" :checked="true" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="weekend" label="Weekend" :options="['sat_sun' => 'Saturday and Sunday', 'fri_sat' => 'Friday and Saturday', 'sun' => 'Sunday only', 'none' => 'No weekend']" selected="sat_sun" />
        <x-calc.select name="holidays" label="Holidays" :options="['none' => 'None', 'us' => 'US federal holidays', 'custom' => 'My own list']" selected="us" />
    </div>

    <div data-show-when="holidays:custom" hidden>
        <x-calc.textarea name="holiday_list" label="Your holidays (one date per line, YYYY-MM-DD)" value="2026-12-24
2026-12-31" rows="4" />
    </div>

    <x-calc.result label="Business days" />

    <x-calc.options :decimals="false" :examples="[
        'Nov–Dec 2026, US' => ['start' => '2026-11-01', 'end' => '2026-12-31', 'include_start' => true, 'include_end' => true, 'weekend' => 'sat_sun', 'holidays' => 'us', 'holiday_list' => ''],
        'Whole year 2027' => ['start' => '2027-01-01', 'end' => '2027-12-31', 'include_start' => true, 'include_end' => true, 'weekend' => 'sat_sun', 'holidays' => 'us', 'holiday_list' => ''],
        'Fri–Sat weekend, own holidays' => ['start' => '2026-03-01', 'end' => '2026-03-31', 'include_start' => true, 'include_end' => true, 'weekend' => 'fri_sat', 'holidays' => 'custom', 'holiday_list' => '2026-03-20
2026-03-21'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Calendar days'],
            'weekend' => ['label' => 'Weekend days'],
            'holidays' => ['label' => 'Holidays skipped'],
            'weeks' => ['label' => 'Working weeks'],
        ]" />
        <x-calc.quick-ref heading="Holidays skipped" name="skipped" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>business days = days − weekend days − holidays on workdays</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
