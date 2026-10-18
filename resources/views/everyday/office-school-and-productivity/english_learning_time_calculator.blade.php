<x-calc.page
    title="English Learning Time Calculator - SolveKit"
    description="Free English learning time calculator: guided learning hours and weeks to move between CEFR levels (A1 to C2) at your study pace."
    lede="Estimate how long it takes to reach the next English level."
    about="Cambridge English gives approximate cumulative guided learning hours from beginner: A2 180–200, B1 350–400, B2 500–600, C1 700–800 and C2 1,000–1,200 (A1 is commonly given as 90–100). The hours between two levels are the difference. Guided hours are classes and directed study; your own background, age, intensity and practice change the time a lot."
    :calc="['engine' => 'ev-office', 'tool' => 'english_hours', 'fields' => ['from', 'to', 'per_week'], 'data' => ['cefr_hours' => config('everyday_data.cefr_hours')]]"
    :how-to="[
        ['name' => 'Choose your current and target level', 'text' => 'On the CEFR scale.'],
        ['name' => 'Enter hours a week', 'text' => 'Classes and directed study.'],
    ]"
    :faqs="[
        ['question' => 'How long from A2 to B2?', 'answer' => 'About 300–420 guided learning hours.'],
        ['question' => 'How many hours to reach C1 from zero?', 'answer' => 'About 700–800 hours.'],
        ['question' => 'Does self-study count?', 'answer' => 'Directed study counts; extra practice speeds progress.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="from" label="Current level" :options="['Pre-A1' => 'Beginner (pre-A1)', 'A1' => 'A1 Beginner', 'A2' => 'A2 Elementary', 'B1' => 'B1 Intermediate', 'B2' => 'B2 Upper intermediate', 'C1' => 'C1 Advanced', 'C2' => 'C2 Proficient']" selected="A2" />
        <x-calc.select name="to" label="Target level" :options="['A1' => 'A1 Beginner', 'A2' => 'A2 Elementary', 'B1' => 'B1 Intermediate', 'B2' => 'B2 Upper intermediate', 'C1' => 'C1 Advanced', 'C2' => 'C2 Proficient']" selected="B2" />
    </div>

    <x-calc.field name="per_week" label="Hours of study a week" value="6" min="0.5" step="0.5" />

    <x-calc.result label="Hours needed" />

    <x-calc.options :decimals="false" :examples="[
        'A2 → B2, 6 h a week' => ['from' => 'A2', 'to' => 'B2', 'per_week' => 6],
        'Beginner → B1' => ['from' => 'Pre-A1', 'to' => 'B1', 'per_week' => 10],
        'B2 → C1 intensive' => ['from' => 'B2', 'to' => 'C1', 'per_week' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weeks' => ['label' => 'Weeks'],
            'months' => ['label' => 'Months'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = hours(target) − hours(current)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
