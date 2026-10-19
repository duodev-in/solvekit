<x-calc.page
    title="Sobriety Calculator - SolveKit"
    description="Free sobriety calculator: days, weeks and months sober since your date, the next milestone and the money not spent."
    lede="Count your days of sobriety."
    about="Counts the days from your sobriety date to today, with the common recovery milestones (24 hours, 30, 60 and 90 days, 6 and 9 months, years) and what you would have spent. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'sobriety', 'fields' => ['start', 'today', 'per_week']]"
    :how-to="[
        ['name' => 'Enter your sobriety date', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long since 1 January 2026?', 'answer' => '291 days as of 19 October 2026.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Sobriety date" value="2026-01-01" type="date" />
        <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.field name="per_week" label="Usual spending a week (optional)" value="60" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Sober" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => '2026-01-01', 'today' => '2026-10-19', 'per_week' => 60],
        'Five years' => ['start' => '2021-10-01', 'today' => '2026-10-19', 'per_week' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weeks' => ['label' => 'Weeks'],
            'saved' => ['label' => 'Money not spent'],
            'next' => ['label' => 'Next milestone'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = today − start</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
