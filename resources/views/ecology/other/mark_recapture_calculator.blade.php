<x-calc.page
    title="Mark–Recapture Calculator - SolveKit"
    description="Free mark and recapture calculator: population size by Lincoln-Petersen and Chapman estimators with a 95% interval."
    lede="Estimate population size from a mark–recapture study."
    about="Mark M animals and release them; later catch C, of which R are marked. Lincoln–Petersen estimates N = MC ÷ R. The Chapman form, (M + 1)(C + 1) ÷ (R + 1) − 1, is less biased with few recaptures. It assumes a closed population and that marks are not lost."
    :calc="['engine' => 'ecology', 'tool' => 'mark_recapture', 'fields' => ['marked', 'caught', 'recaptured']]"
    :how-to="[
        ['name' => 'Mark and release', 'text' => 'Count the animals marked.'],
        ['name' => 'Recapture', 'text' => 'Count all caught and how many carry marks.'],
    ]"
    :faqs="[
        ['question' => 'What does the method assume?', 'answer' => 'No births, deaths or migration between samples, marks are kept, and all animals are equally catchable.'],
        ['question' => 'Why use Chapman?', 'answer' => 'Lincoln–Petersen overestimates when recaptures are few.'],
        ['question' => 'How many recaptures do I need?', 'answer' => 'At least 7 for a reasonable estimate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="marked" label="Marked first M" value="50" min="0" step="1" />
        <x-calc.field name="caught" label="Caught second C" value="60" min="0" step="1" />
        <x-calc.field name="recaptured" label="Marked in second R" value="10" min="0" step="1" />
    </div>

    <x-calc.result label="Population estimate" />

    <x-calc.options :examples="[
        '50 / 60 / 10' => ['marked' => 50, 'caught' => 60, 'recaptured' => 10],
        'Pond fish' => ['marked' => 120, 'caught' => 150, 'recaptured' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lincoln' => ['label' => 'Lincoln–Petersen'],
            'interval' => ['label' => '95% margin'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Lincoln–Petersen N = M × C ÷ R</li>
            <li>Chapman N = (M + 1)(C + 1) ÷ (R + 1) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
