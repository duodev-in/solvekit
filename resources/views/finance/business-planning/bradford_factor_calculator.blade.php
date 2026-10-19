<x-calc.page
    title="Bradford Factor Calculator - SolveKit"
    description="Free Bradford Factor Calculator: B = S² × D. The Bradford Factor weights frequent short absences more heavily than one long absence: 3 spells of 2 days score 54, one spell of 6 days scores 6."
    lede="Work out the Bradford Factor from separate absences (spells) in 52 weeks and total days absent."
    about="The Bradford Factor weights frequent short absences more heavily than one long absence: 3 spells of 2 days score 54, one spell of 6 days scores 6. It is a convention used in HR policies, not a law; disability-related absence should be treated separately. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'bradford_factor', 'fields' => ['spells', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Separate absences (spells) in 52 weeks, Total days absent.'],
        ['name' => 'Read the result', 'text' => 'The Bradford Factor appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Bradford Factor?', 'answer' => 'B = S² × D.'],
        ['question' => 'What is the Bradford Factor for separate absences in 52 weeks 3, total days absent 6?', 'answer' => '54.'],
        ['question' => 'And for separate absences in 52 weeks 6, total days absent 8?', 'answer' => '288.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Common trigger points are 51, 201 and 401, but each employer sets its own.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spells" label="Separate absences (spells) in 52 weeks" value="3" min="0" step="1" />
        <x-calc.field name="days" label="Total days absent" value="6" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Bradford Factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['spells' => 3, 'days' => 6],
        'Example B' => ['spells' => 6, 'days' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = S² × D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
