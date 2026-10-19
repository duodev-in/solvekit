<x-calc.page
    title="Aldrete Score Calculator - SolveKit"
    description="Free Aldrete score calculator: modified Aldrete recovery score after anaesthesia (activity, breathing, circulation, consciousness, oxygen saturation), with the discharge cut-off of 9."
    lede="Score recovery after anaesthesia."
    about="The modified Aldrete score (Aldrete 1995) rates five items 0–2 in the recovery room. A total of 9 or more is the usual criterion for discharge from post-anaesthesia care. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['activity', 'respiration', 'circulation', 'consciousness', 'spo2'], 'data' => ['score' => config('health_data.scores.aldrete')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'Is a patient breathing well but needing oxygen ready to leave recovery?', 'answer' => '9 of 10: Ready for discharge from recovery (9–10).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="activity" label="Activity" :options="['o0' => 'Moves all four limbs on command (2 points)', 'o1' => 'Moves two limbs (1 point)', 'o2' => 'Moves no limbs (0 points)']" selected="o0" />
        <x-calc.select name="respiration" label="Respiration" :options="['o0' => 'Breathes deeply and coughs freely (2 points)', 'o1' => 'Short of breath or limited breathing (1 point)', 'o2' => 'Apnoeic (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="circulation" label="Circulation (BP vs before anaesthesia)" :options="['o0' => 'Within 20% (2 points)', 'o1' => 'Within 20–49% (1 point)', 'o2' => '50% or more different (0 points)']" selected="o0" />
        <x-calc.select name="consciousness" label="Consciousness" :options="['o0' => 'Fully awake (2 points)', 'o1' => 'Rousable on calling (1 point)', 'o2' => 'Not responding (0 points)']" selected="o0" />
    </div>

    <x-calc.select name="spo2" label="Oxygen saturation" :options="['o0' => 'Over 92% on room air (2 points)', 'o1' => 'Needs oxygen to keep over 90% (1 point)', 'o2' => 'Under 90% even with oxygen (0 points)']" selected="o0" />

    <x-calc.result label="Modified Aldrete score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['activity' => 'o0', 'respiration' => 'o0', 'circulation' => 'o0', 'consciousness' => 'o0', 'spo2' => 'o0'],
        'Highest' => ['activity' => 'o0', 'respiration' => 'o0', 'circulation' => 'o0', 'consciousness' => 'o0', 'spo2' => 'o0'],
        'Needs oxygen' => ['activity' => 'o0', 'respiration' => 'o0', 'circulation' => 'o0', 'consciousness' => 'o0', 'spo2' => 'o1'],
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
            <li>Modified Aldrete score: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
