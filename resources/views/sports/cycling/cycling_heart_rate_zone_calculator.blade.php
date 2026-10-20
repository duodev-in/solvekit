<x-calc.page
    title="Cycling Heart Rate Zone Calculator - SolveKit"
    description="Free cycling heart rate zone calculator: Joe Friel’s seven zones from lactate-threshold heart rate."
    lede="Find cycling heart-rate zones."
    about="Friel’s cycling zones are set from your lactate-threshold heart rate, found with a 30-minute time trial."
    :calc="['engine' => 'sp-cycle', 'tool' => 'cycling_hr_zones', 'fields' => ['lthr'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What zones suit an LTHR of 162?', 'answer' => 'See the zone table.'],
    ]"
>
    <x-calc.field name="lthr" label="Lactate-threshold heart rate (cycling)" value="162" min="1" step="any" />

    <x-calc.result label="Threshold heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lthr' => 162],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'find' => ['label' => 'How to find it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Friel cycling heart-rate zones" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
