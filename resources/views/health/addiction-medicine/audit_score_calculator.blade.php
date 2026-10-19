<x-calc.page
    title="Audit Score Calculator - SolveKit"
    description="Free AUDIT calculator: the WHO Alcohol Use Disorders Identification Test, 10 questions scored 0–40 with the four risk zones."
    lede="Take the WHO AUDIT."
    about="The AUDIT (WHO, Babor et al. 2001) covers alcohol use, signs of dependence and alcohol-related harm. Zones: 0–7 low risk, 8–15 increasing risk, 16–19 higher risk and 20 or more possible dependence. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10'], 'data' => ['score' => config('health_data.scores.audit')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What zone is the default answer set?', 'answer' => '3 of 40: Zone I: low risk (0–7).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="How often do you have a drink containing alcohol?" :options="['o0' => 'Never (0 points)', 'o1' => 'Monthly or less (1 point)', 'o2' => '2–4 times a month (2 points)', 'o3' => '2–3 times a week (3 points)', 'o4' => '4 or more times a week (4 points)']" selected="o2" />
        <x-calc.select name="q2" label="How many drinks containing alcohol do you have on a typical day when you are drinking?" :options="['o0' => '1 or 2 (0 points)', 'o1' => '3 or 4 (1 point)', 'o2' => '5 or 6 (2 points)', 'o3' => '7 to 9 (3 points)', 'o4' => '10 or more (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="How often do you have six or more drinks on one occasion?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o1" />
        <x-calc.select name="q4" label="How often during the last year have you found that you were not able to stop drinking once you had started?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="How often during the last year have you failed to do what was normally expected of you because of drinking?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o0" />
        <x-calc.select name="q6" label="How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q7" label="How often during the last year have you had a feeling of guilt or remorse after drinking?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o0" />
        <x-calc.select name="q8" label="How often during the last year have you been unable to remember what happened the night before because of your drinking?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less than monthly (1 point)', 'o2' => 'Monthly (2 points)', 'o3' => 'Weekly (3 points)', 'o4' => 'Daily or almost daily (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q9" label="Have you or someone else been injured because of your drinking?" :options="['o0' => 'No (0 points)', 'o1' => 'Yes, but not in the last year (2 points)', 'o2' => 'Yes, during the last year (4 points)']" selected="o0" />
        <x-calc.select name="q10" label="Has a relative, friend, doctor or other health worker been concerned about your drinking or suggested you cut down?" :options="['o0' => 'No (0 points)', 'o1' => 'Yes, but not in the last year (2 points)', 'o2' => 'Yes, during the last year (4 points)']" selected="o0" />
    </div>

    <x-calc.result label="AUDIT" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o2', 'q2' => 'o0', 'q3' => 'o1', 'q4' => 'o0', 'q5' => 'o0', 'q6' => 'o0', 'q7' => 'o0', 'q8' => 'o0', 'q9' => 'o0', 'q10' => 'o0'],
        'Highest' => ['q1' => 'o4', 'q2' => 'o4', 'q3' => 'o4', 'q4' => 'o4', 'q5' => 'o4', 'q6' => 'o4', 'q7' => 'o4', 'q8' => 'o4', 'q9' => 'o2', 'q10' => 'o2'],
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
            <li>AUDIT: sum of item points (maximum 40)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
