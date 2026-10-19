<x-calc.page
    title="Audit-C Calculator – Am I an Alcoholic? - SolveKit"
    description="Free AUDIT-C calculator: the three-question alcohol screen (how often, how much, binge drinking) with the cut-offs for men and women."
    lede="Screen your drinking with AUDIT-C."
    about="AUDIT-C (Bush et al. 1998) uses the first three questions of the WHO AUDIT. A score of 4 or more for men, or 3 or more for women, suggests hazardous drinking or an alcohol use disorder. It is a screening tool, not a diagnosis: the full AUDIT and a conversation with a clinician give a better picture. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['freq', 'typical', 'binge'], 'data' => ['score' => config('health_data.scores.auditc')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does drinking 2–4 times a month, 1–2 drinks, binge less than monthly score?', 'answer' => '3 of 12: Positive for women (3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="freq" label="How often do you have a drink containing alcohol?" :options="['o0' => 'Never (0 points)', 'o1' => 'Monthly or less (1 point)', 'o2' => '2–4 times a month (2 points)', 'o3' => '2–3 times a week (3 points)', 'o4' => '4 or more times a week (4 points)']" selected="o2" />
        <x-calc.select name="typical" label="How many standard drinks on a typical day when you drink?" :options="['o0' => '1 or 2 (0 points)', 'o1' => '3 or 4 (1 point)', 'o2' => '5 or 6 (2 points)', 'o3' => '7 to 9 (3 points)', 'o4' => '10 or more (4 points)']" selected="o0" />
    </div>

    <x-calc.select name="binge" label="How often do you have six or more drinks on one occasion?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o1" />

    <x-calc.result label="AUDIT-C" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['freq' => 'o2', 'typical' => 'o0', 'binge' => 'o1'],
        'Highest' => ['freq' => 'o4', 'typical' => 'o4', 'binge' => 'o4'],
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
            <li>AUDIT-C: sum of item points (maximum 12)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
