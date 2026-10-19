<x-calc.page
    title="Crown-rump Length Calculator - SolveKit"
    description="Free crown-rump length calculator: gestational age and due date from the CRL measured on a first-trimester ultrasound (Robinson & Fleming)."
    lede="Date a pregnancy from crown-rump length."
    about="Crown-rump length, measured from 6 to 14 weeks, is the most accurate way to date a pregnancy. Robinson & Fleming (1975): gestational age (days) = 8.052 × √CRL (mm) + 23.73, the formula used by BMUS and many ultrasound machines. Beyond 84 mm (about 14 weeks) head circumference is used instead. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'crl', 'fields' => ['crl', 'scan']]"
    :how-to="[
        ['name' => 'Enter the CRL', 'text' => ''],
        ['name' => 'Enter the scan date', 'text' => 'For the due date.'],
    ]"
    :faqs="[
        ['question' => 'What gestational age is a 45 mm CRL?', 'answer' => '11 weeks 1 day (Due date Apr 10, 2027).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="crl" label="Crown-rump length" value="45" min="0" max="90" step="any" suffix="mm" />
        <x-calc.field name="scan" label="Scan date" value="2026-09-20" type="date" />
    </div>

    <x-calc.result label="Gestational age by CRL" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['crl' => 45, 'scan' => '2026-09-20'],
        'Early' => ['crl' => 8, 'scan' => '2026-09-20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'In days'],
            'due' => ['label' => 'Due date'],
            'accuracy' => ['label' => 'Accuracy'],
            'source' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GA (d) = 8.052 √CRL + 23.73</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
