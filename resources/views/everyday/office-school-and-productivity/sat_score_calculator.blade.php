<x-calc.page
    title="SAT® Score Calculator - SolveKit"
    description="Free SAT score calculator: the percentile rank of an SAT total score and section scores, among test takers and among all US 11th and 12th graders, from the College Board's tables."
    lede="Find the percentile of your SAT score."
    about="The digital SAT is adaptive, so the College Board does not publish raw-to-scaled score tables; this works from your scaled scores (400–1600 total, 200–800 per section). User percentiles compare you with students who took the SAT in the past three school years; nationally representative percentiles compare you with all US 11th and 12th graders. SAT® is a trademark of the College Board, which does not endorse this site."
    :calc="['engine' => 'ev-office', 'tool' => 'sat', 'fields' => ['total', 'rw', 'math'], 'data' => collect(config('everyday_data'))->only(['sat_total', 'sat_section'])->all()]"
    :how-to="[
        ['name' => 'Enter your total', 'text' => 'From 400 to 1600.'],
        ['name' => 'Add section scores', 'text' => 'For their percentiles.'],
    ]"
    :faqs="[
        ['question' => 'What percentile is a 1200 SAT?', 'answer' => 'The 75th among test takers and 81st nationally.'],
        ['question' => 'What is a good SAT score?', 'answer' => 'Above about 1200 is better than three-quarters of test takers.'],
        ['question' => 'Why no raw score conversion?', 'answer' => 'The digital SAT is adaptive, so raw scores do not map to fixed scaled scores.'],
    ]"
>
    <x-calc.field name="total" label="Total score" value="1200" min="400" max="1600" step="10" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rw" label="Reading and Writing (optional)" value="590" min="200" max="800" step="10" />
        <x-calc.field name="math" label="Math (optional)" value="610" min="200" max="800" step="10" />
    </div>

    <x-calc.result label="Percentile" />

    <x-calc.options :decimals="false" :examples="[
        '1200 (590 + 610)' => ['total' => 1200, 'rw' => 590, 'math' => 610],
        '1450' => ['total' => 1450, 'rw' => 720, 'math' => 730],
        '1000' => ['total' => 1000, 'rw' => '', 'math' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rw' => ['label' => 'Reading and Writing'],
            'math' => ['label' => 'Math'],
            'sum' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>percentile = College Board table lookup</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
