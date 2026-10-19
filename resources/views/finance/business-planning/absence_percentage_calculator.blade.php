<x-calc.page
    title="Absence Percentage Calculator - SolveKit"
    description="Free Absence Percentage Calculator: absence % = days absent ÷ working days × 100. Absence percentage shows the share of scheduled working time lost to absence, usually unplanned sickness."
    lede="Work out the absence rate from days absent and working days in the period."
    about="Absence percentage shows the share of scheduled working time lost to absence, usually unplanned sickness. UK public bodies report it as days lost per employee too. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'absence_percentage', 'fields' => ['absent', 'available']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Days absent, Working days in the period.'],
        ['name' => 'Read the result', 'text' => 'The absence rate appears as you type, with days present below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the absence rate?', 'answer' => 'Absence % = days absent ÷ working days × 100.'],
        ['question' => 'What is the absence rate for days absent 6, working days in the period 230?', 'answer' => '2.609%. Days present: 224 days.'],
        ['question' => 'And for days absent 12, working days in the period 250?', 'answer' => '4.8%. Days present: 238 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Rates of 2–4% are common; the comparison that matters is with your own sector and past years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="absent" label="Days absent" value="6" min="0" step="any" suffix="days" />
        <x-calc.field name="available" label="Working days in the period" value="230" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Absence rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['absent' => 6, 'available' => 230],
        'Example B' => ['absent' => 12, 'available' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Days present'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>absence % = days absent ÷ working days × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
