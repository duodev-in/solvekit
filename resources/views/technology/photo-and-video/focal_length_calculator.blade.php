<x-calc.page
    title="Focal Length Calculator - SolveKit"
    description="Free focal length calculator: the lens to fill the frame with a subject, or for an angle of view."
    lede="Find the focal length you need."
    about="To fill the frame, the focal length scales with distance and inversely with the subject size."
    :calc="['engine' => 'tc-photo', 'tool' => 'focal_length', 'fields' => ['sensor', 'sw', 'sh', 'by', 'subject', 'dist', 'angle'], 'unitFields' => ['subject' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'technology' => collect(config('technology_data'))->only(['sensors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What lens fills full frame with a 2 m subject at 10 m?', 'answer' => '180 mm.'],
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
        <x-calc.select name="by" label="From" :options="['subject' => 'Subject size and distance', 'angle' => 'Angle of view']" selected="subject" />
        <div data-show-when="by:subject">
            <x-calc.field name="subject" label="Subject width to fill the frame" value="2" placeholder="Subject width to fill the frame">
                <label for="calc-subject-unit" class="sr-only">Subject width to fill the frame unit</label>
                <select id="calc-subject-unit" name="subject-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:subject">
            <x-calc.field name="dist" label="Distance to the subject" value="10" placeholder="Distance to the subject">
                <label for="calc-dist-unit" class="sr-only">Distance to the subject unit</label>
                <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:angle">
            <x-calc.field name="angle" label="Horizontal angle of view (°)" value="40" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Focal length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 'ff', 'sw' => 36, 'sh' => 24, 'by' => 'subject', 'subject' => 2, 'subject-unit' => 'm', 'dist' => 10, 'dist-unit' => 'm', 'angle' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equiv' => ['label' => 'Full-frame equivalent'],
            'angle' => ['label' => 'Horizontal angle of view'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
