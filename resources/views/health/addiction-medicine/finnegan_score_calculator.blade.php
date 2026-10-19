<x-calc.page
    title="Finnegan Score Calculator - SolveKit"
    description="Free Finnegan score calculator: the modified Finnegan Neonatal Abstinence Scoring Tool, 21 signs of neonatal opioid withdrawal."
    lede="Score neonatal abstinence (Finnegan)."
    about="Nurses score the modified Finnegan tool every 3–4 hours after feeds for babies exposed to opioids in pregnancy. Three consecutive scores of 8 or more, or two of 12 or more, are a common trigger for the team to consider medicine. Many units now use the Eat, Sleep, Console approach instead. For clinical teams; parents should ask their baby's nurse. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['cry', 'sleep', 'moro', 'tremor_disturbed', 'tremor_undisturbed', 'tone', 'excoriation', 'myoclonic', 'convulsions', 'sweating', 'fever', 'yawning', 'mottling', 'stuffy', 'sneezing', 'flaring', 'rr', 'sucking', 'feeding', 'vomit', 'stools'], 'data' => ['score' => config('health_data.scores.finnegan')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does excessive crying, sleeping under 2 hours, mild tremors when disturbed and loose stools score?', 'answer' => '7 of 46: Below the treatment threshold (0–7).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cry" label="High-pitched cry" :options="['o0' => 'No (0 points)', 'o1' => 'Excessive (2 points)', 'o2' => 'Continuous (3 points)']" selected="o0" />
        <x-calc.select name="sleep" label="Sleeps after feeding" :options="['o0' => '3 hours or more (0 points)', 'o1' => 'Under 3 hours (1 point)', 'o2' => 'Under 2 hours (2 points)', 'o3' => 'Under 1 hour (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="moro" label="Moro reflex" :options="['o0' => 'Normal (0 points)', 'o1' => 'Hyperactive (2 points)', 'o2' => 'Markedly hyperactive (3 points)']" selected="o0" />
        <x-calc.select name="tremor_disturbed" label="Tremors when disturbed" :options="['o0' => 'None (0 points)', 'o1' => 'Mild (1 point)', 'o2' => 'Moderate to severe (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="tremor_undisturbed" label="Tremors when undisturbed" :options="['o0' => 'None (0 points)', 'o1' => 'Mild (3 points)', 'o2' => 'Moderate to severe (4 points)']" selected="o0" />
        <x-calc.checkbox name="tone" label="Increased muscle tone" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="excoriation" label="Excoriation (chin, knees, toes or nose)" :checked="false" />
        <x-calc.checkbox name="myoclonic" label="Myoclonic jerks" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="convulsions" label="Generalised convulsions" :checked="false" />
        <x-calc.checkbox name="sweating" label="Sweating" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fever" label="Temperature" :options="['o0' => 'Under 37.2 °C (0 points)', 'o1' => '37.2–38.2 °C (1 point)', 'o2' => 'Over 38.2 °C (2 points)']" selected="o0" />
        <x-calc.checkbox name="yawning" label="Frequent yawning (more than 3–4 times an interval)" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="mottling" label="Mottling" :checked="false" />
        <x-calc.checkbox name="stuffy" label="Nasal stuffiness" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="sneezing" label="Sneezing (more than 3–4 times an interval)" :checked="false" />
        <x-calc.checkbox name="flaring" label="Nasal flaring" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="rr" label="Respiratory rate" :options="['o0' => '60 or less (0 points)', 'o1' => 'Over 60 (1 point)', 'o2' => 'Over 60 with retractions (2 points)']" selected="o0" />
        <x-calc.checkbox name="sucking" label="Excessive sucking" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="feeding" label="Poor feeding" :checked="false" />
        <x-calc.select name="vomit" label="Regurgitation or vomiting" :options="['o0' => 'None (0 points)', 'o1' => 'Regurgitation (2 points)', 'o2' => 'Projectile vomiting (3 points)']" selected="o0" />
    </div>

    <x-calc.select name="stools" label="Stools" :options="['o0' => 'Normal (0 points)', 'o1' => 'Loose (2 points)', 'o2' => 'Watery (3 points)']" selected="o0" />

    <x-calc.result label="Finnegan neonatal abstinence score (modified)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cry' => 'o0', 'sleep' => 'o0', 'moro' => 'o0', 'tremor_disturbed' => 'o0', 'tremor_undisturbed' => 'o0', 'tone' => false, 'excoriation' => false, 'myoclonic' => false, 'convulsions' => false, 'sweating' => false, 'fever' => 'o0', 'yawning' => false, 'mottling' => false, 'stuffy' => false, 'sneezing' => false, 'flaring' => false, 'rr' => 'o0', 'sucking' => false, 'feeding' => false, 'vomit' => 'o0', 'stools' => 'o0'],
        'Highest' => ['cry' => 'o2', 'sleep' => 'o3', 'moro' => 'o2', 'tremor_disturbed' => 'o2', 'tremor_undisturbed' => 'o2', 'tone' => true, 'excoriation' => true, 'myoclonic' => true, 'convulsions' => true, 'sweating' => true, 'fever' => 'o2', 'yawning' => true, 'mottling' => true, 'stuffy' => true, 'sneezing' => true, 'flaring' => true, 'rr' => 'o2', 'sucking' => true, 'feeding' => true, 'vomit' => 'o2', 'stools' => 'o2'],
        'Unsettled' => ['cry' => 'o1', 'sleep' => 'o2', 'moro' => 'o0', 'tremor_disturbed' => 'o1', 'tremor_undisturbed' => 'o0', 'tone' => false, 'excoriation' => false, 'myoclonic' => false, 'convulsions' => false, 'sweating' => false, 'fever' => 'o0', 'yawning' => false, 'mottling' => false, 'stuffy' => false, 'sneezing' => false, 'flaring' => false, 'rr' => 'o0', 'sucking' => false, 'feeding' => false, 'vomit' => 'o0', 'stools' => 'o1'],
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
            <li>Finnegan neonatal abstinence score (modified): sum of item points (maximum 46)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
