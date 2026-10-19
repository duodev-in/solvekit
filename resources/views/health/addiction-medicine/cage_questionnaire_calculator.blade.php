<x-calc.page
    title="CAGE Questionnaire Calculator - SolveKit"
    description="Free CAGE questionnaire: four yes/no questions (Cut down, Annoyed, Guilty, Eye-opener) to screen for an alcohol problem."
    lede="Answer the CAGE questions."
    about="CAGE (Ewing 1984) asks four questions about drinking; two or more yes answers are clinically significant. It is quick but can miss risky drinking that has not yet caused problems, so AUDIT-C is often preferred. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['cut', 'annoyed', 'guilty', 'eye'], 'data' => ['score' => config('health_data.scores.cage')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does yes to Cut down and Guilty score?', 'answer' => '2 of 4: Clinically significant (2–4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="cut" label="Have you ever felt you should Cut down on your drinking?" :checked="false" />
        <x-calc.checkbox name="annoyed" label="Have people Annoyed you by criticising your drinking?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="guilty" label="Have you ever felt bad or Guilty about your drinking?" :checked="false" />
        <x-calc.checkbox name="eye" label="Have you ever had a drink first thing in the morning (Eye-opener)?" :checked="false" />
    </div>

    <x-calc.result label="CAGE questionnaire" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cut' => false, 'annoyed' => false, 'guilty' => false, 'eye' => false],
        'Highest' => ['cut' => true, 'annoyed' => true, 'guilty' => true, 'eye' => true],
        'Two yes' => ['cut' => true, 'annoyed' => false, 'guilty' => true, 'eye' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CAGE questionnaire: sum of item points (maximum 4)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
