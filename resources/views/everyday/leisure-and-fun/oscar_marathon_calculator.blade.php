<x-calc.page
    title="Oscar Marathon Calculator - SolveKit"
    description="Free Oscar marathon calculator: total running time of the Academy Award Best Picture winners for any range of years, and days to watch them all."
    lede="Plan a Best Picture marathon."
    about="Winners are listed by ceremony year (the 1st ceremony was in 1929; the 2026 ceremony honored One Battle After Another). Runtimes are each film's Wikipedia infobox figure; Wings and All Quiet on the Western Front use the restored versions available today. Two ceremonies were held in 1930."
    :calc="['engine' => 'ev-fun', 'tool' => 'oscars', 'fields' => ['from', 'to', 'per_day'], 'data' => ['best_picture' => config('everyday_data.best_picture')]]"
    :how-to="[
        ['name' => 'Choose the years', 'text' => 'By ceremony.'],
        ['name' => 'Set hours a day', 'text' => 'For a schedule.'],
    ]"
    :faqs="[
        ['question' => 'How long would it take to watch every Best Picture winner?', 'answer' => 'About 225 hours for all 98, or 76 days at 3 hours a day.'],
        ['question' => 'What is the longest Best Picture winner?', 'answer' => 'Lawrence of Arabia, at 222 minutes; Gone with the Wind runs 221 without its overture and intermission.'],
        ['question' => 'What won Best Picture in 2026?', 'answer' => 'One Battle After Another, at the 98th ceremony.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="from" label="From ceremony year" value="2000" min="1929" max="2026" step="1" />
        <x-calc.field name="to" label="To" value="2026" min="1929" max="2026" step="1" />
        <x-calc.field name="per_day" label="Hours a day (optional)" value="3" min="0.5" max="24" step="0.5" />
    </div>

    <x-calc.result label="Best Picture winners" />

    <x-calc.options :decimals="false" :examples="[
        '2000–2026' => ['from' => 2000, 'to' => 2026, 'per_day' => 3],
        'All 98 winners' => ['from' => 1929, 'to' => 2026, 'per_day' => 3],
        '1970s' => ['from' => 1970, 'to' => 1979, 'per_day' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'days' => ['label' => 'Days'],
            'longest' => ['label' => 'Longest'],
            'average' => ['label' => 'Average'],
        ]" />
        <x-calc.quick-ref heading="Winners" name="films" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ runtimes of winners in range</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
