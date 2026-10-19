<x-calc.page
    title="Drip Rate Calculator - SolveKit"
    description="Free drip rate calculator: IV drops per minute from the volume, time and giving-set drop factor, with mL/h."
    lede="Work out IV drops per minute."
    about="Drops per minute = volume (mL) × drop factor (drops/mL) ÷ time (minutes). Standard giving sets deliver 20 drops/mL (15 or 10 in some countries) and micro-drip sets 60 drops/mL, where drops/min equals mL/h. Follow the prescription and local policy; pumps are preferred for high-risk infusions. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'drip', 'fields' => ['volume', 'hours', 'minutes', 'factor']]"
    :how-to="[
        ['name' => 'Enter the volume and time', 'text' => ''],
        ['name' => 'Choose the drop factor', 'text' => 'On the giving-set packet.'],
    ]"
    :faqs="[
        ['question' => 'What is the drip rate for 1,000 mL over 8 hours at 20 drops/mL?', 'answer' => '42 drops/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Volume" value="1000" min="0" step="any" suffix="mL" />
        <x-calc.field name="hours" label="Hours" value="8" min="0" step="any" suffix="h" />
        <x-calc.field name="minutes" label="Minutes" value="0" min="0" step="any" suffix="min" />
    </div>

    <x-calc.select name="factor" label="Drop factor (giving set)" :options="['10' => '10 drops/mL', '15' => '15 drops/mL', '20' => '20 drops/mL (standard)', '60' => '60 drops/mL (micro-drip)']" selected="20" />

    <x-calc.result label="Drip rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['volume' => 1000, 'hours' => 8, 'minutes' => 0, 'factor' => '20'],
        'Micro-drip' => ['volume' => 250, 'hours' => 2, 'minutes' => 0, 'factor' => '60'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mlh' => ['label' => 'mL per hour'],
            'seconds' => ['label' => 'One drop every'],
            'per15' => ['label' => 'In 15 seconds'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>drops/min = mL × factor ÷ min</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
