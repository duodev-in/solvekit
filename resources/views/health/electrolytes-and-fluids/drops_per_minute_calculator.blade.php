<x-calc.page
    title="Drops Per Minute Calculator - SolveKit"
    description="Free drops per minute calculator: gravity infusion rate in drops per minute and seconds per drop from volume, time and drop factor."
    lede="Calculate drops per minute."
    about="For a gravity infusion, drops per minute = total volume × drop factor ÷ minutes. Counting the drops in 15 seconds and multiplying by 4 checks the rate at the bedside. A 20 drops/mL set at 1 L in 8 hours runs at about 42 drops a minute. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'drip', 'fields' => ['volume', 'hours', 'minutes', 'factor']]"
    :how-to="[
        ['name' => 'Enter volume and time', 'text' => ''],
        ['name' => 'Choose the drop factor', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many drops a minute is 500 mL over 4 hours with a 15 drops/mL set?', 'answer' => '31 drops/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Volume" value="1000" min="0" step="any" suffix="mL" />
        <x-calc.field name="hours" label="Hours" value="8" min="0" step="any" suffix="h" />
        <x-calc.field name="minutes" label="Minutes" value="0" min="0" step="any" suffix="min" />
    </div>

    <x-calc.select name="factor" label="Drop factor (giving set)" :options="['10' => '10 drops/mL', '15' => '15 drops/mL', '20' => '20 drops/mL (standard)', '60' => '60 drops/mL (micro-drip)']" selected="20" />

    <x-calc.result label="Drops per minute" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['volume' => 500, 'hours' => 4, 'minutes' => 0, 'factor' => '15'],
        'Standard' => ['volume' => 1000, 'hours' => 8, 'minutes' => 0, 'factor' => '20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'seconds' => ['label' => 'One drop every'],
            'per15' => ['label' => 'In 15 seconds'],
            'mlh' => ['label' => 'mL per hour'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>drops/min = mL × factor ÷ min</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
