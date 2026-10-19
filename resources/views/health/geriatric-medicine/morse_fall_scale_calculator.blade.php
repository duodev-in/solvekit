<x-calc.page
    title="Morse Fall Scale Calculator - SolveKit"
    description="Free Morse Fall Scale calculator: hospital fall risk from fall history, diagnoses, walking aids, IV access, gait and mental status (0–125)."
    lede="Score fall risk with the Morse Fall Scale."
    about="The Morse Fall Scale (Morse et al. 1989) is used on hospital wards. Common cut-offs are 0–24 no risk, 25–44 low and 45 or more high risk, though hospitals set their own thresholds. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['history', 'secondary', 'aid', 'iv', 'gait', 'mental'], 'data' => ['score' => config('health_data.scores.morse')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a patient with a previous fall, a walker and a weak gait score?', 'answer' => '50 of 125: High risk (45 or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="history" label="History of falling (immediate or within 3 months)" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (25 points)']" selected="o0" />
        <x-calc.select name="secondary" label="Secondary diagnosis" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (15 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="aid" label="Ambulatory aid" :options="['o0' => 'None, bed rest or nurse assist (0 points)', 'o1' => 'Crutches, cane or walker (15 points)', 'o2' => 'Furniture (30 points)']" selected="o0" />
        <x-calc.select name="iv" label="IV therapy or heparin lock" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (20 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gait" label="Gait" :options="['o0' => 'Normal, bed rest or wheelchair (0 points)', 'o1' => 'Weak (10 points)', 'o2' => 'Impaired (20 points)']" selected="o0" />
        <x-calc.select name="mental" label="Mental status" :options="['o0' => 'Oriented to own ability (0 points)', 'o1' => 'Overestimates or forgets limitations (15 points)']" selected="o0" />
    </div>

    <x-calc.result label="Morse Fall Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['history' => 'o0', 'secondary' => 'o0', 'aid' => 'o0', 'iv' => 'o0', 'gait' => 'o0', 'mental' => 'o0'],
        'Highest' => ['history' => 'o1', 'secondary' => 'o1', 'aid' => 'o2', 'iv' => 'o1', 'gait' => 'o2', 'mental' => 'o1'],
        'Walker' => ['history' => 'o1', 'secondary' => 'o0', 'aid' => 'o1', 'iv' => 'o0', 'gait' => 'o1', 'mental' => 'o0'],
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
            <li>Morse Fall Scale: sum of item points (maximum 125)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
