<x-calc.page
    title="Running Pace Calculator - SolveKit"
    description="Free running pace calculator: convert min/km, min/mi, km/h and mph, with finish times."
    lede="Convert running pace and speed."
    about="Runners use pace; treadmills and watches may show speed. This converts between them."
    :calc="['engine' => 'sp-run', 'tool' => 'running_pace', 'fields' => ['by', 'pace', 'speed'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 5:30 /km per mile?', 'answer' => '8:51 /mi.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['kmpace' => 'Pace per km', 'mipace' => 'Pace per mile', 'kmh' => 'Speed in km/h', 'mph' => 'Speed in mph']" selected="kmpace" />
        <div data-show-when="by:kmpace,mipace">
            <x-calc.field name="pace" label="Pace (m:ss)" value="5:30" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:kmh,mph">
            <x-calc.field name="speed" label="Speed" value="11" min="0.1" step="any" />
        </div>
    </div>

    <x-calc.result label="Pace per km" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'kmpace', 'pace' => '5:30', 'speed' => 11],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mi' => ['label' => 'Pace per mile'],
            'kmh' => ['label' => 'km/h'],
            'mph' => ['label' => 'mph'],
            'm400' => ['label' => '400 m lap'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Finish times at this pace" name="races" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
