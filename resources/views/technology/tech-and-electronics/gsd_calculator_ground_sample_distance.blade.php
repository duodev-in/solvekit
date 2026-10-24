<x-calc.page
    title="GSD Calculator – Ground Sample Distance - SolveKit"
    description="Free GSD calculator: ground sample distance for drone mapping from sensor, focal length, image width and flight height."
    lede="Find the ground sample distance."
    about="Ground sample distance is the size of one image pixel on the ground; it sets the detail of a drone map."
    :calc="['engine' => 'tc-elec', 'tool' => 'gsd', 'fields' => ['sensor', 'focal', 'imageW', 'imageH', 'height', 'target'], 'unitFields' => ['height' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GSD at 100 m with a 1-inch 20 MP camera?', 'answer' => '2.741 cm/px.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sensor" label="Sensor width (mm)" value="13.2" min="0" step="any" />
        <x-calc.field name="focal" label="Focal length (mm)" value="8.8" min="0" step="any" />
        <x-calc.field name="imageW" label="Image width (pixels)" value="5472" min="1" step="any" />
        <x-calc.field name="imageH" label="Image height (pixels)" value="3648" min="1" step="any" />
        <x-calc.field name="height" label="Flight height" value="100" placeholder="Flight height">
            <label for="calc-height-unit" class="sr-only">Flight height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Target GSD (cm/px, optional)" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Ground sample distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sensor' => 13.2, 'focal' => 8.8, 'imageW' => 5472, 'imageH' => 3648, 'height' => 100, 'height-unit' => 'm', 'target' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'footprint' => ['label' => 'Image footprint on the ground'],
            'area' => ['label' => 'Area covered'],
            'heightFor' => ['label' => 'Height for the target GSD'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
