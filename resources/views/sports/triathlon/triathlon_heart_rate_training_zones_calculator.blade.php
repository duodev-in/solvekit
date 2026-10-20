<x-calc.page
    title="Triathlon Heart Rate Training Zones Calculator - SolveKit"
    description="Free triathlon heart rate zones calculator: Friel zones for running and cycling."
    lede="Find triathlon heart-rate zones."
    about="Heart-rate zones differ between running and cycling, so triathletes set each from its own threshold."
    :calc="['engine' => 'sp-run', 'tool' => 'tri_hr_zones', 'fields' => ['run', 'bike'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What zones suit LTHRs of 170 and 162?', 'answer' => 'See the zone table.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="run" label="Running lactate-threshold heart rate" value="170" min="1" step="any" />
        <x-calc.field name="bike" label="Cycling lactate-threshold heart rate" value="162" min="1" step="any" />
    </div>

    <x-calc.result label="Run and bike zones" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['run' => 170, 'bike' => 162],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'swim' => ['label' => 'Swimming'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Joe Friel heart-rate zones" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
