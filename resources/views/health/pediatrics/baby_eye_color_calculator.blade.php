<x-calc.page
    title="Baby Eye Color Calculator - SolveKit"
    description="Free baby eye color calculator: the chance of brown, green or blue eyes from the parents' eye colours, using the simplified two-gene model."
    lede="Predict a baby's eye colour."
    about="This uses the classic simplified model with two genes: one with a dominant brown allele (bey2) and one with green dominant over blue (gey). It explains common patterns, but eye colour actually depends on many genes, mainly OCA2 and HERC2, so the chances are only illustrative. Babies' eyes can also change colour until about age 1–3. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'eye_colour', 'fields' => ['mother', 'father']]"
    :how-to="[
        ['name' => 'Choose both parents\' eye colours', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the chances for a brown-eyed mother and blue-eyed father?', 'answer' => 'Brown 67%, green 17%, blue 17%.'],
        ['question' => 'And two blue-eyed parents?', 'answer' => 'Brown 0%, green 0%, blue 100% in this model.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mother" label="Mother's eyes" :options="['brown' => 'Brown', 'green' => 'Green or hazel', 'blue' => 'Blue or grey']" selected="brown" />
        <x-calc.select name="father" label="Father's eyes" :options="['brown' => 'Brown', 'green' => 'Green or hazel', 'blue' => 'Blue or grey']" selected="blue" />
    </div>

    <x-calc.result label="Most likely eye colour" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mother' => 'brown', 'father' => 'blue'],
        'Both blue' => ['mother' => 'blue', 'father' => 'blue'],
        'Green and brown' => ['mother' => 'green', 'father' => 'brown'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'model' => ['label' => 'Model'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Chances" name="chances" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>two-gene Mendelian model</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
