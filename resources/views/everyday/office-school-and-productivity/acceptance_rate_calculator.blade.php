<x-calc.page
    title="Acceptance Rate Calculator - SolveKit"
    description="Free acceptance rate calculator: a college's or program's acceptance rate, the odds of admission and the yield from applicants, admits and enrolled students."
    lede="Work out an acceptance rate and the odds of getting in."
    about="Acceptance rate = admitted ÷ applicants. Yield = enrolled ÷ admitted, showing how many admitted students accept. Colleges report these in their Common Data Set (sections C1 and C2). Your own chance depends on your application, not just the overall rate."
    :calc="['engine' => 'ev-office', 'tool' => 'acceptance', 'fields' => ['applicants', 'admitted', 'enrolled']]"
    :how-to="[
        ['name' => 'Enter applicants and admits', 'text' => 'From the Common Data Set.'],
        ['name' => 'Add enrolled students', 'text' => 'For the yield.'],
    ]"
    :faqs="[
        ['question' => 'What is the acceptance rate if 5,460 of 42,000 are admitted?', 'answer' => '13%, about 1 in 7.7.'],
        ['question' => 'What is yield?', 'answer' => 'The share of admitted students who enroll.'],
        ['question' => 'Where do I find these numbers?', 'answer' => 'In the college\'s Common Data Set, section C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="applicants" label="Applicants" value="42000" min="1" step="1" />
        <x-calc.field name="admitted" label="Admitted" value="5460" min="0" step="1" />
        <x-calc.field name="enrolled" label="Enrolled (optional)" value="1650" min="0" step="1" />
    </div>

    <x-calc.result label="Acceptance rate" />

    <x-calc.options :examples="[
        'Selective college' => ['applicants' => 42000, 'admitted' => 5460, 'enrolled' => 1650],
        'State university' => ['applicants' => 30000, 'admitted' => 21000, 'enrolled' => 6300],
        'Job applications' => ['applicants' => 250, 'admitted' => 4, 'enrolled' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'odds' => ['label' => 'Odds'],
            'rejected' => ['label' => 'Not admitted'],
            'yield' => ['label' => 'Yield'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = admitted ÷ applicants</li>
            <li>yield = enrolled ÷ admitted</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
