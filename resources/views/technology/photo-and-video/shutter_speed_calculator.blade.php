<x-calc.page
    title="Shutter Speed Calculator - SolveKit"
    description="Free shutter speed calculator: slowest hand-held speed, and star-trail-free exposure by the NPF and 500 rules."
    lede="Find a safe shutter speed."
    about="Long focal lengths magnify camera shake and star motion, so they need faster shutter speeds."
    :calc="['engine' => 'tc-photo', 'tool' => 'shutter', 'fields' => ['sensor', 'sw', 'sh', 'purpose', 'f', 'stops', 'n', 'px'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the slowest hand-held speed at 50 mm on full frame?', 'answer' => '1/50 s.'],
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
        <x-calc.select name="purpose" label="For" :options="['handheld' => 'Hand-held sharpness', 'stars' => 'Stars without trails (NPF rule)', 'rule500' => 'Stars without trails (500 rule)']" selected="handheld" />
        <x-calc.field name="f" label="Focal length (mm)" value="50" min="0" step="any" />
        <div data-show-when="purpose:handheld">
            <x-calc.field name="stops" label="Stabilisation (stops)" value="0" min="0" step="any" />
        </div>
        <div data-show-when="purpose:stars">
            <x-calc.field name="n" label="Aperture (f-number, NPF rule)" value="2.8" min="0" step="any" />
        </div>
        <div data-show-when="purpose:stars">
            <x-calc.field name="px" label="Image width (pixels, NPF rule)" value="6000" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Slowest shutter speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'purpose' => 'handheld', 'f' => 50, 'stops' => 0, 'n' => 2.8, 'px' => 6000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'method' => ['label' => 'Rule used'],
            'crop' => ['label' => 'Crop factor used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
