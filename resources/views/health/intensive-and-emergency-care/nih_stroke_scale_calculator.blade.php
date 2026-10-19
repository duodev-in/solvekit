<x-calc.page
    title="NIH Stroke Scale Calculator - SolveKit"
    description="Free NIH Stroke Scale calculator: the 15-item NIHSS (0–42) for stroke severity, with the minor to severe bands."
    lede="Score stroke severity with the NIHSS."
    about="The NIH Stroke Scale (Brott et al. 1989) is the standard bedside measure of stroke deficits, done by trained staff. 0 means no measurable deficit, 1–4 minor, 5–15 moderate, 16–20 moderate to severe and 21–42 severe stroke. Anyone with sudden stroke signs needs emergency services at once. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['loc', 'questions', 'commands', 'gaze', 'visual', 'facial', 'arm_left', 'arm_right', 'leg_left', 'leg_right', 'ataxia', 'sensory', 'language', 'dysarthria', 'extinction'], 'data' => ['score' => config('health_data.scores.nihss')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does mild facial palsy, arm drift and mild dysarthria score?', 'answer' => '3 of 42: Minor stroke (1–4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="loc" label="1a. Level of consciousness" :options="['o0' => 'Alert (0 points)', 'o1' => 'Not alert, rousable by minor stimulation (1 point)', 'o2' => 'Not alert, needs repeated or painful stimulation (2 points)', 'o3' => 'Unresponsive or reflex responses only (3 points)']" selected="o0" />
        <x-calc.select name="questions" label="1b. Questions (month and age)" :options="['o0' => 'Answers both correctly (0 points)', 'o1' => 'Answers one correctly (1 point)', 'o2' => 'Answers neither correctly (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="commands" label="1c. Commands (open and close eyes, grip)" :options="['o0' => 'Performs both (0 points)', 'o1' => 'Performs one (1 point)', 'o2' => 'Performs neither (2 points)']" selected="o0" />
        <x-calc.select name="gaze" label="2. Best gaze" :options="['o0' => 'Normal (0 points)', 'o1' => 'Partial gaze palsy (1 point)', 'o2' => 'Forced deviation (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="visual" label="3. Visual fields" :options="['o0' => 'No visual loss (0 points)', 'o1' => 'Partial hemianopia (1 point)', 'o2' => 'Complete hemianopia (2 points)', 'o3' => 'Bilateral hemianopia (blind) (3 points)']" selected="o0" />
        <x-calc.select name="facial" label="4. Facial palsy" :options="['o0' => 'Normal (0 points)', 'o1' => 'Minor paralysis (1 point)', 'o2' => 'Partial paralysis (2 points)', 'o3' => 'Complete paralysis of one or both sides (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="arm_left" label="5a. Motor, left arm" :options="['o0' => 'No drift (0 points)', 'o1' => 'Drift (1 point)', 'o2' => 'Some effort against gravity (2 points)', 'o3' => 'No effort against gravity (3 points)', 'o4' => 'No movement (4 points)']" selected="o0" />
        <x-calc.select name="arm_right" label="5b. Motor, right arm" :options="['o0' => 'No drift (0 points)', 'o1' => 'Drift (1 point)', 'o2' => 'Some effort against gravity (2 points)', 'o3' => 'No effort against gravity (3 points)', 'o4' => 'No movement (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="leg_left" label="6a. Motor, left leg" :options="['o0' => 'No drift (0 points)', 'o1' => 'Drift (1 point)', 'o2' => 'Some effort against gravity (2 points)', 'o3' => 'No effort against gravity (3 points)', 'o4' => 'No movement (4 points)']" selected="o0" />
        <x-calc.select name="leg_right" label="6b. Motor, right leg" :options="['o0' => 'No drift (0 points)', 'o1' => 'Drift (1 point)', 'o2' => 'Some effort against gravity (2 points)', 'o3' => 'No effort against gravity (3 points)', 'o4' => 'No movement (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="ataxia" label="7. Limb ataxia" :options="['o0' => 'Absent (0 points)', 'o1' => 'Present in one limb (1 point)', 'o2' => 'Present in two limbs (2 points)']" selected="o0" />
        <x-calc.select name="sensory" label="8. Sensory" :options="['o0' => 'Normal (0 points)', 'o1' => 'Mild to moderate loss (1 point)', 'o2' => 'Severe to total loss (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="language" label="9. Best language" :options="['o0' => 'No aphasia (0 points)', 'o1' => 'Mild to moderate aphasia (1 point)', 'o2' => 'Severe aphasia (2 points)', 'o3' => 'Mute, global aphasia (3 points)']" selected="o0" />
        <x-calc.select name="dysarthria" label="10. Dysarthria" :options="['o0' => 'Normal (0 points)', 'o1' => 'Mild to moderate (1 point)', 'o2' => 'Severe (2 points)']" selected="o0" />
    </div>

    <x-calc.select name="extinction" label="11. Extinction and inattention" :options="['o0' => 'No abnormality (0 points)', 'o1' => 'Inattention in one modality (1 point)', 'o2' => 'Profound inattention in more than one modality (2 points)']" selected="o0" />

    <x-calc.result label="NIH Stroke Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['loc' => 'o0', 'questions' => 'o0', 'commands' => 'o0', 'gaze' => 'o0', 'visual' => 'o0', 'facial' => 'o0', 'arm_left' => 'o0', 'arm_right' => 'o0', 'leg_left' => 'o0', 'leg_right' => 'o0', 'ataxia' => 'o0', 'sensory' => 'o0', 'language' => 'o0', 'dysarthria' => 'o0', 'extinction' => 'o0'],
        'Highest' => ['loc' => 'o3', 'questions' => 'o2', 'commands' => 'o2', 'gaze' => 'o2', 'visual' => 'o3', 'facial' => 'o3', 'arm_left' => 'o4', 'arm_right' => 'o4', 'leg_left' => 'o4', 'leg_right' => 'o4', 'ataxia' => 'o2', 'sensory' => 'o2', 'language' => 'o3', 'dysarthria' => 'o2', 'extinction' => 'o2'],
        'Mild stroke' => ['loc' => 'o0', 'questions' => 'o0', 'commands' => 'o0', 'gaze' => 'o0', 'visual' => 'o0', 'facial' => 'o1', 'arm_left' => 'o1', 'arm_right' => 'o0', 'leg_left' => 'o0', 'leg_right' => 'o0', 'ataxia' => 'o0', 'sensory' => 'o0', 'language' => 'o0', 'dysarthria' => 'o1', 'extinction' => 'o0'],
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
            <li>NIH Stroke Scale: sum of item points (maximum 42)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
