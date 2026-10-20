<x-calc.page
    title="Simpson's Diversity Index Calculator - SolveKit"
    description="Free Simpson's diversity index calculator: D, 1 − D and 1/D from species counts. Includes practice questions."
    lede="Work out Simpson's diversity index from counts of each species."
    about="Simpson's D is the chance that two individuals drawn at random without replacement belong to the same species. 1 − D (Gini–Simpson) is the chance they differ, so it rises with diversity, and 1 ÷ D is the effective number of species."
    :calc="['engine' => 'ecology', 'tool' => 'simpson', 'fields' => ['mode', 'counts', 'question', 'answer'], 'practice' => 'simpson']"
    :how-to="[
        ['name' => 'Count each species', 'text' => 'Individuals of each species in the sample.'],
        ['name' => 'Enter the list', 'text' => 'Comma or space separated.'],
    ]"
    :faqs="[
        ['question' => 'Is a higher Simpson\'s index more diverse?', 'answer' => 'For 1 − D and 1 ÷ D yes; for D itself, lower is more diverse.'],
        ['question' => 'Why n(n − 1)?', 'answer' => 'It is sampling without replacement, which suits finite samples.'],
        ['question' => 'Which index should I report?', 'answer' => 'State which form you use; 1 − D is the most common.'],
        ['question' => 'Can I practise working out the index?', 'answer' => 'Yes. Switch the mode to practice questions; each question number gives new species counts, checks your 1 − D and shows the working. This replaces the old Simpson\'s diversity index quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <x-calc.textarea name="counts" label="Individuals per species" value="40, 25, 15, 10, 5, 5" help="One count per species, separated by commas or spaces" rows="3" />
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Simpson's index" />

    <x-calc.options :examples="[
        'Six species' => ['mode' => 'calculate', 'counts' => '40, 25, 15, 10, 5, 5'],
        'Perfectly even' => ['mode' => 'calculate', 'counts' => '20, 20, 20, 20, 20'],
        'One dominant' => ['mode' => 'calculate', 'counts' => '90, 5, 3, 2'],
        'Practice' => ['mode' => 'practice', 'counts' => '40, 25, 15, 10, 5, 5', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :grow="true" :rows="[
                'd' => ['label' => 'Simpson\'s D'],
                'reciprocal' => ['label' => 'Reciprocal 1 ÷ D'],
                'richness' => ['label' => 'Species richness'],
                'total' => ['label' => 'Total individuals'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
            <x-calc.steps heading="Working" name="steps" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D = Σ n(n − 1) ÷ N(N − 1)</li>
            <li>diversity = 1 − D</li>
            <li>effective species = 1 ÷ D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
