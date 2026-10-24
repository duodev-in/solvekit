<x-calc.page
    title="Depth of Field Calculator - SolveKit"
    description="Free depth of field calculator: near and far limits of sharpness for any sensor, focal length, aperture and distance."
    lede="Find the depth of field."
    about="Depth of field is the range of distance that looks sharp; it shrinks with wider apertures, longer lenses and closer subjects."
    :calc="['engine' => 'tc-photo', 'tool' => 'dof', 'fields' => ['sensor', 'sw', 'sh', 'f', 'n', 'dist'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the depth of field at 50 mm f/2.8, 3 m, full frame?', 'answer' => '57.71 cm (22.72 in).'],
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
        <x-calc.field name="n" label="Aperture (f-number)" value="2.8" min="0" step="any" />
        <x-calc.field name="dist" label="Focus distance" value="3" placeholder="Focus distance">
            <label for="calc-dist-unit" class="sr-only">Focus distance unit</label>
            <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Depth of field" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'f' => 50, 'n' => 2.8, 'dist' => 3, 'dist-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Depth of field by aperture" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'near' => ['label' => 'Near limit'],
            'far' => ['label' => 'Far limit'],
            'front' => ['label' => 'In front / behind'],
            'hyper' => ['label' => 'Hyperfocal distance'],
            'coc' => ['label' => 'Circle of confusion'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
