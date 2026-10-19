<x-calc.page
    title="Adjusted Age Calculator - SolveKit"
    description="Free adjusted age calculator: a premature baby's corrected age (chronological age minus weeks born early), for growth and development milestones."
    lede="Work out a preemie's corrected age."
    about="Corrected (adjusted) age = chronological age − the weeks born before 40 weeks. A baby born at 32 weeks who is 4 months old has a corrected age of 2 months. The AAP advises using corrected age for growth charts and milestones until about age 2 (some up to 3 for very premature babies); vaccinations follow chronological age. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'adjusted_age', 'fields' => ['birth', 'ga_weeks', 'ga_days', 'today']]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => ''],
        ['name' => 'Enter the weeks at birth', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the corrected age of a baby born at 32 weeks on 10 May 2026, on 19 October 2026?', 'answer' => '3.5 months (15 weeks 1 day) (Chronological age 5.3 months (23 weeks 1 day); born 8 weeks 0 days early).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="birth" label="Birth date" value="2026-05-10" type="date" />
        <x-calc.field name="ga_weeks" label="Born at (weeks)" value="32" min="22" max="42" step="1" suffix="weeks" />
        <x-calc.field name="ga_days" label="and days" value="0" min="0" max="6" step="1" suffix="days" />
    </div>

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Corrected age" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['birth' => '2026-05-10', 'ga_weeks' => 32, 'ga_days' => 0, 'today' => '2026-10-19'],
        'Very premature' => ['birth' => '2025-11-01', 'ga_weeks' => 27, 'ga_days' => 3, 'today' => '2026-10-19'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'chronological' => ['label' => 'Chronological age'],
            'early' => ['label' => 'Born early'],
            'due' => ['label' => 'Original due date'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>corrected = age − (40 weeks − GA at birth)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
