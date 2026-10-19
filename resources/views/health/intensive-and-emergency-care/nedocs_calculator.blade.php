<x-calc.page
    title="NEDOCS Calculator - SolveKit"
    description="Free NEDOCS calculator: the National Emergency Department Overcrowding Scale from beds, patients, ventilators and waiting times."
    lede="Measure emergency department crowding."
    about="NEDOCS (Weiss et al. 2004) = −20 + 85.8 × (ED patients ÷ ED beds) + 600 × (admitted patients waiting ÷ hospital beds) + 13.4 × ventilators in the ED + 0.93 × longest admit time (hours) + 5.64 × longest waiting-room time (hours), from 0 to 200. Over 100 is overcrowded and over 180 dangerously so. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'nedocs', 'fields' => ['ed_beds', 'hospital_beds', 'ed_patients', 'admits', 'vents', 'admit_hours', 'wait_hours']]"
    :how-to="[
        ['name' => 'Enter the current counts', 'text' => ''],
        ['name' => 'Enter the longest waits', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is NEDOCS with 40 patients in 30 beds and 8 admits waiting?', 'answer' => '141: Severely overcrowded.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ed_beds" label="ED beds" value="30" min="1" step="1" />
        <x-calc.field name="hospital_beds" label="Hospital beds" value="300" min="1" step="1" />
        <x-calc.field name="ed_patients" label="Patients in the ED" value="40" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="admits" label="Admitted patients waiting in the ED" value="8" min="0" step="1" />
        <x-calc.field name="vents" label="Patients on ventilators in the ED" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="admit_hours" label="Longest admitted wait" value="6" min="0" step="any" suffix="h" />
        <x-calc.field name="wait_hours" label="Longest waiting-room wait" value="2" min="0" step="any" suffix="h" />
    </div>

    <x-calc.result label="NEDOCS" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ed_beds' => 30, 'hospital_beds' => 300, 'ed_patients' => 40, 'admits' => 8, 'vents' => 1, 'admit_hours' => 6, 'wait_hours' => 2],
        'Quiet' => ['ed_beds' => 30, 'hospital_beds' => 300, 'ed_patients' => 15, 'admits' => 1, 'vents' => 0, 'admit_hours' => 1, 'wait_hours' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Crowding level'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NEDOCS = −20 + 85.8 P/B + 600 A/H + 13.4 V + 0.93 L + 5.64 W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
