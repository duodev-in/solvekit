<x-calc.page
    title="Hyperfocal Distance Calculator - SolveKit"
    description="Free hyperfocal distance calculator: focus distance for maximum depth of field, by aperture."
    lede="Find the hyperfocal distance."
    about="Focus at the hyperfocal distance and everything from half that distance to infinity is sharp."
    :calc="['engine' => 'tc-photo', 'tool' => 'hyperfocal', 'fields' => ['sensor', 'sw', 'sh', 'f', 'n'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the hyperfocal distance at 24 mm f/8 on full frame?', 'answer' => '2.52 m (8.268 ft).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sensor" label="Sensor" :options="['ff' => 'Full frame (35 mm)', 'mf' => 'Medium format 44 × 33', 'apsh' => 'APS-H', 'apsc' => 'APS-C (Nikon, Sony, Fujifilm)', 'apsc_canon' => 'APS-C (Canon)', 'm43' => 'Micro Four Thirds', 'one' => '1-inch type', 'two_thirds' => '2/3-inch type', 'one_17' => '1/1.7-inch type', 'one_23' => '1/2.3-inch type (compacts, older phones)', 'custom' => 'Other (enter the value)']" selected="ff" />
        <div data-show-when="sensor:custom">
            <x-calc.field name="sw" label="Sensor width (mm)" value="36" min="0" step="any" />
        </div>
        <div data-show-when="sensor:custom">
            <x-calc.field name="sh" label="Sensor height (mm)" value="24" min="0" step="any" />
        </div>
        <x-calc.field name="f" label="Focal length (mm)" value="24" min="0" step="any" />
        <x-calc.field name="n" label="Aperture (f-number)" value="8" min="0" step="any" />
    </div>

    <x-calc.result label="Hyperfocal distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'f' => 24, 'n' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'near' => ['label' => 'Sharp from (half the hyperfocal distance)'],
            'coc' => ['label' => 'Circle of confusion'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="By aperture" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
