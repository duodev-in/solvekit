<x-calc.page
    title="Anaerobic Threshold Calculator - SolveKit"
    description="Free anaerobic threshold calculator: threshold heart rate from a 30-minute test or a share of maximum."
    lede="Find your threshold heart rate."
    about="The anaerobic (lactate) threshold is the hardest effort you can sustain for about an hour. A 30-minute solo time trial estimates it well."
    :calc="['engine' => 'sp-fit', 'tool' => 'anaerobic_threshold', 'fields' => ['by', 'sport', 'avg', 'age', 'formula', 'max', 'rest'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What threshold does a maximum of 185 suggest?', 'answer' => '156–165 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="Method" :options="['test' => '30-minute time-trial heart rate (Friel)', 'pct' => 'Percentage of maximum']" selected="pct" />
        <x-calc.select name="sport" label="Sport" :options="['run' => 'Running', 'bike' => 'Cycling']" selected="run" />
        <div data-show-when="by:test">
            <x-calc.field name="avg" label="Average heart rate over the last 20 minutes" value="165" min="1" step="any" />
        </div>
        <div data-show-when="by:pct">
            <x-calc.field name="age" label="Age" value="35" min="1" step="any" />
        </div>
        <div data-show-when="by:pct">
            <x-calc.select name="formula" label="Maximum heart rate from" :options="['tanaka' => 'Tanaka (208 − 0.7 × age)', 'fox' => 'Fox (220 − age)', 'gulati' => 'Gulati, women (206 − 0.88 × age)', 'nes' => 'Nes (211 − 0.64 × age)', 'known' => 'A measured maximum']" selected="tanaka" />
        </div>
        <div data-show-when="formula:known">
            <x-calc.field name="max" label="Measured maximum heart rate" value="185" min="1" step="any" />
        </div>
        <div data-show-when="by:none">
            <x-calc.field name="rest" label="Resting heart rate (for Karvonen)" value="60" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Anaerobic (lactate) threshold heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'pct', 'sport' => 'run', 'avg' => 165, 'age' => 35, 'formula' => 'tanaka', 'max' => 185, 'rest' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Typical range'],
            'note' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
