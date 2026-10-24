<x-calc.page
    title="Camera Field of View Calculator - SolveKit"
    description="Free camera field of view calculator: angle of view and the area covered for any sensor and focal length."
    lede="Find the field of view."
    about="The angle of view depends on the sensor size and focal length; the field covered grows with distance."
    :calc="['engine' => 'tc-photo', 'tool' => 'fov', 'fields' => ['sensor', 'sw', 'sh', 'f', 'dist'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the horizontal angle of a 50 mm lens on full frame?', 'answer' => '39.6°.'],
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
        <x-calc.field name="f" label="Focal length (mm)" value="50" min="0" step="any" />
        <x-calc.field name="dist" label="Subject distance" value="10" placeholder="Subject distance">
            <label for="calc-dist-unit" class="sr-only">Subject distance unit</label>
            <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Horizontal angle of view" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'f' => 50, 'dist' => 10, 'dist-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'vertical' => ['label' => 'Vertical angle'],
            'diagonal' => ['label' => 'Diagonal angle'],
            'field' => ['label' => 'Field of view at the distance'],
            'equiv' => ['label' => 'Full-frame equivalent focal length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
