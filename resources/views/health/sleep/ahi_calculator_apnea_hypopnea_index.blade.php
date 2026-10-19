<x-calc.page
    title="AHI Calculator | Apnea-Hypopnea Index - SolveKit"
    description="Free AHI calculator: apnea-hypopnea index from the number of apneas and hypopneas and hours of sleep, with the AASM severity bands."
    lede="Calculate the apnea-hypopnea index."
    about="AHI = (apneas + hypopneas) ÷ hours of sleep. The American Academy of Sleep Medicine grades sleep apnoea as mild from 5 events an hour, moderate from 15 and severe from 30. Home tests may use recording time rather than sleep time, which can underestimate AHI. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'ahi', 'fields' => ['apneas', 'hypopneas', 'hours']]"
    :how-to="[
        ['name' => 'Enter the counts from the sleep study', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the AHI for 40 apneas and 60 hypopneas in 7 hours?', 'answer' => '14.3 events/h an hour: Mild sleep apnoea (5–14.9).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="apneas" label="Apneas" value="40" min="0" step="1" />
        <x-calc.field name="hypopneas" label="Hypopneas" value="60" min="0" step="1" />
        <x-calc.field name="hours" label="Hours of sleep" value="7" min="0" step="any" suffix="h" />
    </div>

    <x-calc.result label="Apnea-hypopnea index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['apneas' => 40, 'hypopneas' => 60, 'hours' => 7],
        'Severe' => ['apneas' => 150, 'hypopneas' => 110, 'hours' => 6.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Severity'],
            'events' => ['label' => 'Events'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AHI = (A + H) ÷ hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
