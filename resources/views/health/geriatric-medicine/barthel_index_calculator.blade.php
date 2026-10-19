<x-calc.page
    title="Barthel Index Calculator - SolveKit"
    description="Free Barthel Index calculator: independence in 10 activities of daily living, scored 0–100."
    lede="Score daily living activities (Barthel)."
    about="The Barthel Index (Mahoney & Barthel 1965) rates feeding, bathing, grooming, dressing, bowels, bladder, toilet use, transfers, mobility and stairs. 100 means independent in all ten; Shah et al. (1989) grade 91–99 as slight, 61–90 moderate, 21–60 severe and 0–20 total dependence. It is used in rehabilitation and stroke care. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['feeding', 'bathing', 'grooming', 'dressing', 'bowels', 'bladder', 'toilet', 'transfers', 'mobility', 'stairs'], 'data' => ['score' => config('health_data.scores.barthel')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does needing help with stairs and bathing score?', 'answer' => '90 of 100: Moderate dependence (61–90).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="feeding" label="Feeding" :options="['o0' => 'Independent (10 points)', 'o1' => 'Needs help cutting, spreading butter or a modified diet (5 points)', 'o2' => 'Unable (0 points)']" selected="o0" />
        <x-calc.select name="bathing" label="Bathing" :options="['o0' => 'Independent (5 points)', 'o1' => 'Dependent (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="grooming" label="Grooming (face, hair, teeth, shaving)" :options="['o0' => 'Independent (5 points)', 'o1' => 'Needs help (0 points)']" selected="o0" />
        <x-calc.select name="dressing" label="Dressing" :options="['o0' => 'Independent, including buttons, zips and laces (10 points)', 'o1' => 'Needs help but does about half unaided (5 points)', 'o2' => 'Dependent (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bowels" label="Bowels" :options="['o0' => 'Continent (10 points)', 'o1' => 'Occasional accident (5 points)', 'o2' => 'Incontinent or needs enemas (0 points)']" selected="o0" />
        <x-calc.select name="bladder" label="Bladder" :options="['o0' => 'Continent (10 points)', 'o1' => 'Occasional accident (5 points)', 'o2' => 'Incontinent, or catheterised and unable to manage (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="toilet" label="Toilet use" :options="['o0' => 'Independent (10 points)', 'o1' => 'Needs some help (5 points)', 'o2' => 'Dependent (0 points)']" selected="o0" />
        <x-calc.select name="transfers" label="Transfers (bed to chair and back)" :options="['o0' => 'Independent (15 points)', 'o1' => 'Minor help (verbal or physical) (10 points)', 'o2' => 'Major help, can sit (5 points)', 'o3' => 'Unable, no sitting balance (0 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mobility" label="Mobility on level surfaces" :options="['o0' => 'Walks independently over 50 m (may use an aid) (15 points)', 'o1' => 'Walks with help of one person over 50 m (10 points)', 'o2' => 'Independent in a wheelchair over 50 m (5 points)', 'o3' => 'Immobile or under 50 m (0 points)']" selected="o0" />
        <x-calc.select name="stairs" label="Stairs" :options="['o0' => 'Independent (10 points)', 'o1' => 'Needs help (5 points)', 'o2' => 'Unable (0 points)']" selected="o0" />
    </div>

    <x-calc.result label="Barthel Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['feeding' => 'o0', 'bathing' => 'o0', 'grooming' => 'o0', 'dressing' => 'o0', 'bowels' => 'o0', 'bladder' => 'o0', 'toilet' => 'o0', 'transfers' => 'o0', 'mobility' => 'o0', 'stairs' => 'o0'],
        'Highest' => ['feeding' => 'o0', 'bathing' => 'o0', 'grooming' => 'o0', 'dressing' => 'o0', 'bowels' => 'o0', 'bladder' => 'o0', 'toilet' => 'o0', 'transfers' => 'o0', 'mobility' => 'o0', 'stairs' => 'o0'],
        'Stairs and bath' => ['feeding' => 'o0', 'bathing' => 'o1', 'grooming' => 'o0', 'dressing' => 'o0', 'bowels' => 'o0', 'bladder' => 'o0', 'toilet' => 'o0', 'transfers' => 'o0', 'mobility' => 'o0', 'stairs' => 'o1'],
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
            <li>Barthel Index: sum of item points (maximum 100)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
