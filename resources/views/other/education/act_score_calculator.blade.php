<x-calc.page
    title="ACT Score Calculator - SolveKit"
    description="Free ACT score calculator: composite score from your section scores for the enhanced ACT (2025) or the legacy test, with the STEM score."
    lede="Find your ACT composite."
    about="The ACT composite is the rounded average of the section scores. Since 2025 the enhanced ACT averages English, Math and Reading; Science is optional."
    :calc="['engine' => 'ot-edu', 'tool' => 'act', 'fields' => ['version', 'english', 'math', 'reading', 'science'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What composite do 27, 25 and 29 give?', 'answer' => '27.'],
        ['question' => 'Does Science count?', 'answer' => 'Not on the enhanced ACT (from 2025): it is reported separately, with a STEM score.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="version" label="Test" :options="['enhanced' => 'Enhanced ACT (from 2025): English, Math, Reading', 'legacy' => 'Legacy ACT (before 2025): with Science']" selected="enhanced" />
        <x-calc.field name="english" label="English (1–36)" value="27" min="1" step="any" />
        <x-calc.field name="math" label="Math (1–36)" value="25" min="1" step="any" />
        <x-calc.field name="reading" label="Reading (1–36)" value="29" min="1" step="any" />
        <x-calc.field name="science" label="Science (1–36; optional on the enhanced ACT)" value="24" min="1" step="any" />
    </div>

    <x-calc.result label="Composite score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['version' => 'enhanced', 'english' => 27, 'math' => 25, 'reading' => 29, 'science' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'average' => ['label' => 'Exact average'],
            'stem' => ['label' => 'STEM score (Math and Science)'],
            'sections' => ['label' => 'Sections in the composite'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
