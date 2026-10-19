<x-calc.page
    title="DASI Calculator (Duke Activity Status Index) - SolveKit"
    description="Free DASI calculator: the Duke Activity Status Index, 12 everyday activities scored to 58.2, with estimated peak VO₂ and METs."
    lede="Estimate your functional capacity with DASI."
    about="The Duke Activity Status Index (Hlatky et al. 1989) asks which of 12 activities you can do; each has a weight, totalling 58.2. Estimated peak VO₂ = 0.43 × DASI + 9.6 mL/kg/min, and METs = VO₂ ÷ 3.5. Before surgery, under 4 METs (or DASI 34 or less, METS study) suggests lower functional capacity. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'dasi', 'fields' => ['care', 'indoors', 'blocks', 'stairs', 'run', 'light', 'moderate', 'heavy', 'yard', 'sex', 'recreation', 'sports'], 'data' => ['score' => config('health_data.scores.dasi')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does someone who can do everything except running and strenuous sports score?', 'answer' => '42.7 of 58.2: Estimated peak VO₂ 28.0 mL/kg/min (8.0 METs).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="care" label="Can you take care of yourself (eating, dressing, bathing, using the toilet)?" :checked="false" />
        <x-calc.checkbox name="indoors" label="Can you walk indoors, such as around your house?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="blocks" label="Can you walk a block or two on level ground?" :checked="false" />
        <x-calc.checkbox name="stairs" label="Can you climb a flight of stairs or walk up a hill?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="run" label="Can you run a short distance?" :checked="false" />
        <x-calc.checkbox name="light" label="Can you do light work around the house (dusting, washing dishes)?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="moderate" label="Can you do moderate work around the house (vacuuming, sweeping, carrying groceries)?" :checked="false" />
        <x-calc.checkbox name="heavy" label="Can you do heavy work around the house (scrubbing floors, moving heavy furniture)?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="yard" label="Can you do yard work (raking leaves, weeding, pushing a power mower)?" :checked="false" />
        <x-calc.checkbox name="sex" label="Can you have sexual relations?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="recreation" label="Can you do moderate recreational activities (golf, bowling, dancing, doubles tennis)?" :checked="false" />
        <x-calc.checkbox name="sports" label="Can you take part in strenuous sports (swimming, singles tennis, football, basketball, skiing)?" :checked="false" />
    </div>

    <x-calc.result label="Duke Activity Status Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['care' => false, 'indoors' => false, 'blocks' => false, 'stairs' => false, 'run' => false, 'light' => false, 'moderate' => false, 'heavy' => false, 'yard' => false, 'sex' => false, 'recreation' => false, 'sports' => false],
        'Highest' => ['care' => true, 'indoors' => true, 'blocks' => true, 'stairs' => true, 'run' => true, 'light' => true, 'moderate' => true, 'heavy' => true, 'yard' => true, 'sex' => true, 'recreation' => true, 'sports' => true],
        'No running' => ['care' => true, 'indoors' => true, 'blocks' => true, 'stairs' => true, 'run' => false, 'light' => true, 'moderate' => true, 'heavy' => true, 'yard' => true, 'sex' => true, 'recreation' => true, 'sports' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'vo2' => ['label' => 'Estimated peak VO₂'],
            'mets' => ['label' => 'METs'],
            'periop' => ['label' => 'Before surgery'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DASI = Σ activity weights</li>
            <li>VO₂ = 0.43 × DASI + 9.6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
