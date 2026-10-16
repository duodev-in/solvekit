<x-calc.page
    title="Dog Quality of Life Calculator - SolveKit"
    description="Free dog quality of life calculator: score the HHHHHMM scale (hurt, hunger, hydration, hygiene, happiness, mobility, more good days) out of 70."
    lede="Score your dog's quality of life on the HHHHHMM scale."
    about="The HHHHHMM scale by veterinary oncologist Dr Alice Villalobos rates seven areas from 0 to 10. A total above 35 suggests an acceptable quality of life. It is a way to organize your observations and talk with your vet, not a decision on its own."
    :calc="['engine' => 'pets', 'tool' => 'quality_of_life', 'fields' => ['hurt', 'hunger', 'hydration', 'hygiene', 'happiness', 'mobility', 'more_good']]"
    :how-to="[
        ['name' => 'Score each area', 'text' => '0 is worst and 10 is best.'],
        ['name' => 'Repeat over days', 'text' => 'Trends matter more than one score.'],
        ['name' => 'Share with your vet', 'text' => 'Use it to guide the conversation.'],
    ]"
    :faqs="[
        ['question' => 'What does a score above 35 mean?', 'answer' => 'On the Villalobos scale it suggests quality of life is acceptable.'],
        ['question' => 'How often should I score?', 'answer' => 'Daily or every few days, ideally at the same time of day.'],
        ['question' => 'Should I decide on euthanasia from the score?', 'answer' => 'No. Use it alongside your vet\'s advice; they can assess pain and prognosis.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hurt" label="Hurt (pain under control, breathing easy)" value="8" min="0" max="10" step="1" />
        <x-calc.field name="hunger" label="Hunger (eating enough)" value="8" min="0" max="10" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hydration" label="Hydration (drinking enough)" value="8" min="0" max="10" step="1" />
        <x-calc.field name="hygiene" label="Hygiene (clean, no sores)" value="7" min="0" max="10" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="happiness" label="Happiness (interest, responds to family)" value="8" min="0" max="10" step="1" />
        <x-calc.field name="mobility" label="Mobility (can get up and move)" value="6" min="0" max="10" step="1" />
    </div>

    <x-calc.field name="more_good" label="More good days than bad" value="7" min="0" max="10" step="1" />

    <x-calc.result label="Quality-of-life score" />

    <x-calc.options :examples="[
        'Doing well' => ['hurt' => 9, 'hunger' => 9, 'hydration' => 9, 'hygiene' => 9, 'happiness' => 9, 'mobility' => 8, 'more_good' => 9],
        'Struggling' => ['hurt' => 4, 'hunger' => 5, 'hydration' => 6, 'hygiene' => 4, 'happiness' => 4, 'mobility' => 3, 'more_good' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lowest' => ['label' => 'Lowest area'],
            'percent' => ['label' => 'Percent of maximum'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>score = hurt + hunger + hydration + hygiene + happiness + mobility + more good days</li>
            <li>each 0 to 10; maximum 70; above 35 acceptable</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
