<x-calc.page
    title="Home Battery Calculator - SolveKit"
    description="Free home battery calculator: battery capacity in kWh for backup power or daily solar self-use, with depth of discharge and efficiency."
    lede="Work out the home battery size you need."
    about="Capacity = energy needed ÷ (usable depth of discharge × discharge efficiency). Lithium iron phosphate batteries often allow 90–100% depth of discharge; inverters lose a few percent. For backup, the energy is the load × hours; for solar self-use, the evening and night use."
    :calc="['engine' => 'eco-energy', 'tool' => 'battery', 'fields' => ['mode', 'load', 'hours', 'daily', 'dod', 'efficiency', 'unit_kwh']]"
    :how-to="[
        ['name' => 'Choose backup or daily use', 'text' => 'And enter the energy.'],
        ['name' => 'Enter depth of discharge and efficiency', 'text' => 'From the battery datasheet.'],
    ]"
    :faqs="[
        ['question' => 'How big a battery for 1.5 kW for 8 hours?', 'answer' => 'About 14 kWh with 90% depth of discharge and 95% efficiency.'],
        ['question' => 'What is depth of discharge?', 'answer' => 'The share of the battery you can use without harming it.'],
        ['question' => 'Can a battery run a whole house?', 'answer' => 'For essentials yes; heating and air conditioning need much more.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Use" :options="['backup' => 'Backup power', 'daily' => 'Daily self-use']" selected="backup" />

    <div data-show-when="mode:backup">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="load" label="Load to run" value="1.5" min="0" step="0.1" suffix="kW" />
            <x-calc.field name="hours" label="Hours of backup" value="8" min="0" step="0.5" />
        </div>
    </div>

    <div data-show-when="mode:daily" hidden>
        <x-calc.field name="daily" label="Energy used from the battery per day" value="10" min="0" step="0.5" suffix="kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="dod" label="Depth of discharge" value="90" min="1" max="100" suffix="%" />
        <x-calc.field name="efficiency" label="Discharge efficiency" value="95" min="1" max="100" suffix="%" />
        <x-calc.field name="unit_kwh" label="One battery's size (optional)" value="13.5" min="0" step="0.1" suffix="kWh" />
    </div>

    <x-calc.result label="Battery capacity" />

    <x-calc.options :examples="[
        'Backup 1.5 kW for 8 h' => ['mode' => 'backup', 'load' => 1.5, 'hours' => 8, 'dod' => 90, 'efficiency' => 95, 'unit_kwh' => 13.5],
        'Solar self-use 10 kWh' => ['mode' => 'daily', 'daily' => 10, 'dod' => 100, 'efficiency' => 95, 'unit_kwh' => 5],
        'Lead-acid, 50% DoD' => ['mode' => 'backup', 'load' => 0.5, 'hours' => 12, 'dod' => 50, 'efficiency' => 85, 'unit_kwh' => 2.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'usable' => ['label' => 'Usable energy'],
            'units' => ['label' => 'Batteries'],
            'losses' => ['label' => 'Losses'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>capacity = energy ÷ (DoD × efficiency)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
