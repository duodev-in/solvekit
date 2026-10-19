<x-calc.page
    title="IV Flow Rate Calculator - SolveKit"
    description="Free IV flow rate calculator: infusion rate in mL/h from volume and time, or how long an infusion takes and when it finishes at a set rate."
    lede="Calculate IV flow rate or finish time."
    about="IV flow rate (mL/h) = volume ÷ time in hours; time = volume ÷ rate. The finish time adds the duration to the start time. With a drop factor the same rate is shown in drops per minute for gravity sets. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'iv_flow', 'fields' => ['mode', 'volume', 'hours', 'minutes', 'rate', 'start', 'factor']]"
    :how-to="[
        ['name' => 'Choose what to work out', 'text' => ''],
        ['name' => 'Enter the volume and time or rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What rate runs 1,000 mL over 8 hours?', 'answer' => '125 mL/h.'],
        ['question' => 'When does 1,000 mL at 125 mL/h started at 08:00 finish?', 'answer' => 'Finishes at about 16:00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Work out" :options="['rate' => 'Rate (mL/h)', 'finish' => 'Time and finish']" selected="rate" />

    <x-calc.field name="volume" label="Volume" value="1000" min="0" step="any" suffix="mL" />

    <div data-show-when="mode:rate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hours" label="Hours" value="8" min="0" step="any" suffix="h" />
            <x-calc.field name="minutes" label="Minutes" value="0" min="0" step="any" suffix="min" />
        </div>
    </div>

    <div data-show-when="mode:finish" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="rate" label="Rate" value="125" min="0" step="any" suffix="mL/h" />
            <x-calc.field name="start" label="Start time" value="08:00" type="time" />
        </div>
    </div>

    <x-calc.select name="factor" label="Drop factor (giving set)" :options="['10' => '10 drops/mL', '15' => '15 drops/mL', '20' => '20 drops/mL (standard)', '60' => '60 drops/mL (micro-drip)']" selected="20" />

    <x-calc.result label="IV flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'rate', 'volume' => 1000, 'hours' => 8, 'minutes' => 0, 'rate' => 125, 'start' => '08:00', 'factor' => '20'],
        'Finish' => ['mode' => 'finish', 'volume' => 1000, 'hours' => 8, 'minutes' => 0, 'rate' => 125, 'start' => '08:00', 'factor' => '20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mlh' => ['label' => 'Rate'],
            'gtt' => ['label' => 'Drops per minute'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL/h = volume ÷ hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
