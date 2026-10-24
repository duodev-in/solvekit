<x-calc.page
    title="Crop Factor Calculator - SolveKit"
    description="Free crop factor calculator: crop factor, equivalent focal length and aperture for any sensor."
    lede="Find the crop factor."
    about="Smaller sensors see a narrower view through the same lens; the crop factor compares them with full frame."
    :calc="['engine' => 'tc-photo', 'tool' => 'crop', 'fields' => ['sensor', 'sw', 'sh', 'f', 'aperture'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the crop factor of Micro Four Thirds?', 'answer' => '2.0 (exactly about 2.0 from the diagonal).'],
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
        <x-calc.field name="f" label="Lens focal length (mm)" value="35" min="0" step="any" />
        <x-calc.field name="aperture" label="Aperture (f-number)" value="1.8" min="0" step="any" />
    </div>

    <x-calc.result label="Crop factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'f' => 35, 'aperture' => 1.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equivF' => ['label' => 'Equivalent focal length'],
            'equivN' => ['label' => 'Equivalent aperture (depth of field)'],
            'diagonal' => ['label' => 'Sensor diagonal'],
            'area' => ['label' => 'Sensor area vs full frame'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
