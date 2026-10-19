<x-calc.page
    title="AFT Calculator — US Army Fitness Test - SolveKit"
    description="Free AFT calculator: score the US Army Fitness Test (deadlift, hand-release push-ups, sprint-drag-carry, plank and 2-mile run) by age and sex, with the general and combat standards, from the official 2025 tables."
    lede="Score your Army Fitness Test."
    about="The Army Fitness Test replaced the ACFT on 1 June 2025. Each of the five events scores 0–100 points from the Army's tables by age group and sex. The general standard needs at least 60 points in every event and 300 in total; the combat standard is sex-neutral (everyone uses the male/combat column) and needs 60 in each event and 350 in total. Times are entered as minutes:seconds. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'aft', 'fields' => ['age', 'sex', 'standard', 'mdl', 'hrp', 'sdc', 'plk', 'run'], 'data' => ['aft' => config('health_data.aft')]]"
    :how-to="[
        ['name' => 'Enter age, sex and standard', 'text' => ''],
        ['name' => 'Enter your five event results', 'text' => 'Times as minutes:seconds.'],
    ]"
    :faqs="[
        ['question' => 'What does a 25-year-old man score with a 250 lb deadlift, 35 push-ups, 1:55 SDC, 2:30 plank and 16:30 run?', 'answer' => '401 of 500 points: Pass on the general standard (60 a event, 300 in total); age group 22-26.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="25" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="standard" label="Standard" :options="['general' => 'General (300)', 'combat' => 'Combat (350, sex-neutral)']" selected="general" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="mdl" label="Deadlift (3 reps)" value="250" min="0" step="10" suffix="lb" />
        <x-calc.field name="hrp" label="Hand-release push-ups" value="35" min="0" step="1" suffix="reps" />
        <x-calc.field name="sdc" label="Sprint-drag-carry (m:ss)" value="1:55" type="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="plk" label="Plank (m:ss)" value="2:30" type="text" />
        <x-calc.field name="run" label="Two-mile run (m:ss)" value="16:30" type="text" />
    </div>

    <x-calc.result label="AFT total" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 25, 'sex' => 'male', 'standard' => 'general', 'mdl' => 250, 'hrp' => 35, 'sdc' => '1:55', 'plk' => '2:30', 'run' => '16:30'],
        'Female soldier' => ['age' => 30, 'sex' => 'female', 'standard' => 'general', 'mdl' => 180, 'hrp' => 25, 'sdc' => '2:30', 'plk' => '2:10', 'run' => '19:00'],
        'Combat' => ['age' => 23, 'sex' => 'male', 'standard' => 'combat', 'mdl' => 300, 'hrp' => 50, 'sdc' => '1:45', 'plk' => '3:00', 'run' => '14:30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'result' => ['label' => 'Result'],
            'standard' => ['label' => 'Standard'],
            'source' => ['label' => 'Tables'],
        ]" />
        <x-calc.grid heading="Events" name="events" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>points per event from the AFT tables</li>
            <li>pass: ≥ 60 each and ≥ 300 (combat 350)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
