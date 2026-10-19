<x-calc.page
    title="Centor Score Calculator (Modified/McIsaac) - SolveKit"
    description="Free Centor score calculator: the modified (McIsaac) Centor score for the probability of strep throat, from tonsils, neck nodes, fever, cough and age."
    lede="Score the chance of strep throat."
    about="The Centor criteria (1981), modified by McIsaac (1998) for age, add a point each for tonsillar exudate, tender neck nodes, fever and no cough, plus 1 for ages 3–14 and minus 1 for 45 and over. 0–1 rarely needs testing; 2–3 call for a rapid strep test; 4–5 have about a 50% chance of strep. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['exudate', 'nodes', 'fever', 'cough', 'age'], 'data' => ['score' => config('health_data.scores.centor')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 10-year-old with fever, exudate and no cough score?', 'answer' => '4 of 5: About 51–53% probability of strep throat. Testing is advised; some guidelines allow empirical antibiotics.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="exudate" label="Tonsillar exudate or swelling" :checked="false" />
        <x-calc.checkbox name="nodes" label="Tender, swollen anterior neck lymph nodes" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="fever" label="Temperature over 38 °C (100.4 °F)" :checked="false" />
        <x-calc.checkbox name="cough" label="No cough" :checked="false" />
    </div>

    <x-calc.select name="age" label="Age" :options="['o0' => '3–14 years (1 point)', 'o1' => '15–44 years (0 points)', 'o2' => '45 or older (-1 points)']" selected="o1" />

    <x-calc.result label="Centor score (McIsaac)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['exudate' => false, 'nodes' => false, 'fever' => false, 'cough' => false, 'age' => 'o1'],
        'Highest' => ['exudate' => true, 'nodes' => true, 'fever' => true, 'cough' => true, 'age' => 'o0'],
        'Child' => ['exudate' => true, 'nodes' => false, 'fever' => true, 'cough' => true, 'age' => 'o0'],
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
            <li>Centor score (McIsaac): sum of item points (maximum 5)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
