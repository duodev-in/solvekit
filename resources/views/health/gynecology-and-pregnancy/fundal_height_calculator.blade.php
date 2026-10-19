<x-calc.page
    title="Fundal Height Calculator - SolveKit"
    description="Free fundal height calculator: the expected symphysis–fundal height for your weeks of pregnancy and whether a measurement is in range."
    lede="Check fundal height for your weeks."
    about="From about 24 to 36 weeks, the symphysis–fundal height in centimetres roughly equals the weeks of pregnancy, within ± 2 cm. A measurement outside the range, or a change in growth along a customised chart, may lead to a growth scan (NICE, RCOG). Twins, fibroids, obesity and the baby's position all affect it. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'fundal', 'fields' => ['weeks', 'fundal']]"
    :how-to="[
        ['name' => 'Enter weeks of pregnancy', 'text' => ''],
        ['name' => 'Enter the measurement', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is 29 cm normal at 30 weeks?', 'answer' => '29.0 cm is within the expected range.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weeks" label="Weeks pregnant" value="30" min="16" max="42" step="1" suffix="weeks" />
        <x-calc.field name="fundal" label="Fundal height" value="29" min="0" max="50" step="any" suffix="cm" />
    </div>

    <x-calc.result label="Expected fundal height" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weeks' => 30, 'fundal' => 29],
        'Small' => ['weeks' => 34, 'fundal' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'diff' => ['label' => 'Difference'],
            'rule' => ['label' => 'Rule'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>expected ≈ weeks ± 2 cm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
