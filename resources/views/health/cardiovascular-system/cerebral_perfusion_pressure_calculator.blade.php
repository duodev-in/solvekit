<x-calc.page
    title="Cerebral Perfusion Pressure Calculator - SolveKit"
    description="Free cerebral perfusion pressure calculator: CPP from mean arterial pressure (or blood pressure) and intracranial pressure, against the 60–70 mmHg target."
    lede="Calculate cerebral perfusion pressure."
    about="Cerebral perfusion pressure = MAP − ICP. The Brain Trauma Foundation (2016) targets CPP of 60–70 mmHg in severe traumatic brain injury and treats ICP above 22 mmHg. MAP can be entered directly or worked out from systolic and diastolic. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'cpp', 'fields' => ['sbp', 'dbp', 'icp']]"
    :how-to="[
        ['name' => 'Enter blood pressure', 'text' => ''],
        ['name' => 'Enter the ICP', 'text' => 'From the monitor.'],
    ]"
    :faqs="[
        ['question' => 'What is the CPP at 130/70 with ICP 15?', 'answer' => '75 mmHg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sbp" label="Systolic" value="130" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="dbp" label="Diastolic" value="70" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="icp" label="Intracranial pressure" value="15" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Cerebral perfusion pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sbp' => 130, 'dbp' => 70, 'icp' => 15],
        'Raised ICP' => ['sbp' => 120, 'dbp' => 65, 'icp' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'map' => ['label' => 'MAP'],
            'icp' => ['label' => 'ICP'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPP = MAP − ICP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
