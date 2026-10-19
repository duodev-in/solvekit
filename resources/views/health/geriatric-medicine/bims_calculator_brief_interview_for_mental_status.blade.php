<x-calc.page
    title="BIMS Calculator – Brief Interview for Mental Status - SolveKit"
    description="Free BIMS calculator: the Brief Interview for Mental Status from the MDS 3.0 (repetition, orientation and recall), scored 0–15."
    lede="Score the Brief Interview for Mental Status."
    about="The BIMS is the cognitive screen in the US Minimum Data Set 3.0 for nursing homes: repeating three words, saying the year, month and day, and recalling the three words. 13–15 is cognitively intact, 8–12 moderately impaired and 0–7 severely impaired. It screens; it does not diagnose dementia. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['repeat', 'year', 'month', 'day', 'sock', 'blue', 'bed'], 'data' => ['score' => config('health_data.scores.bims')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does missing the month by 2 weeks and needing cues for two words score?', 'answer' => '12 of 15: Moderately impaired (8–12).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="repeat" label="Repetition of three words (sock, blue, bed) on the first attempt" :options="['o0' => 'None (0 points)', 'o1' => 'One (1 point)', 'o2' => 'Two (2 points)', 'o3' => 'Three (3 points)']" selected="o3" />
        <x-calc.select name="year" label="Says the current year" :options="['o0' => 'Missed by over 5 years or no answer (0 points)', 'o1' => 'Missed by 2–5 years (1 point)', 'o2' => 'Missed by 1 year (2 points)', 'o3' => 'Correct (3 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="month" label="Says the current month" :options="['o0' => 'Missed by over 1 month or no answer (0 points)', 'o1' => 'Missed by 6 days to 1 month (1 point)', 'o2' => 'Accurate within 5 days (2 points)']" selected="o2" />
        <x-calc.select name="day" label="Says the day of the week" :options="['o0' => 'Incorrect or no answer (0 points)', 'o1' => 'Correct (1 point)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sock" label="Recalls “sock”" :options="['o0' => 'No, could not recall (0 points)', 'o1' => 'Yes, after cueing (“something to wear”) (1 point)', 'o2' => 'Yes, no cue needed (2 points)']" selected="o2" />
        <x-calc.select name="blue" label="Recalls “blue”" :options="['o0' => 'No, could not recall (0 points)', 'o1' => 'Yes, after cueing (“a colour”) (1 point)', 'o2' => 'Yes, no cue needed (2 points)']" selected="o2" />
    </div>

    <x-calc.select name="bed" label="Recalls “bed”" :options="['o0' => 'No, could not recall (0 points)', 'o1' => 'Yes, after cueing (“a piece of furniture”) (1 point)', 'o2' => 'Yes, no cue needed (2 points)']" selected="o2" />

    <x-calc.result label="Brief Interview for Mental Status (BIMS)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['repeat' => 'o3', 'year' => 'o3', 'month' => 'o2', 'day' => 'o1', 'sock' => 'o2', 'blue' => 'o2', 'bed' => 'o2'],
        'Highest' => ['repeat' => 'o3', 'year' => 'o3', 'month' => 'o2', 'day' => 'o1', 'sock' => 'o2', 'blue' => 'o2', 'bed' => 'o2'],
        'Some errors' => ['repeat' => 'o3', 'year' => 'o3', 'month' => 'o1', 'day' => 'o1', 'sock' => 'o1', 'blue' => 'o2', 'bed' => 'o1'],
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
            <li>Brief Interview for Mental Status (BIMS): sum of item points (maximum 15)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
