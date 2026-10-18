<x-calc.page
    title="Tank Volume Calculator - SolveKit"
    description="Free tank volume calculator: capacity and filled volume of vertical and horizontal cylinders, rectangular, capsule, cone-bottom and spherical tanks, with a dip chart."
    lede="Work out a tank's capacity and how much liquid is in it."
    about="Each shape uses its exact geometry: a horizontal cylinder holds a circular segment × length at any depth, a capsule adds spherical caps, a cone-bottom tank adds a cone below the cylinder. Enter the liquid depth to see the volume at that level, and the dip chart gives the volume every tenth of the depth."
    :calc="['engine' => 'con-water', 'tool' => 'tank', 'fields' => ['tank', 'diameter', 'length', 'height', 'cone', 'fill'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cone' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'fill' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the tank shape', 'text' => 'And enter its sizes.'],
        ['name' => 'Enter the liquid depth', 'text' => 'Measured from the bottom, or leave blank for full.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons in a 4 × 10 ft horizontal tank?', 'answer' => '940 gallons full.'],
        ['question' => 'Why is a horizontal tank not linear?', 'answer' => 'Its width changes with depth, so each inch near the middle holds more.'],
        ['question' => 'How do I read a dip stick?', 'answer' => 'Use the dip chart: depth on the left, volume on the right.'],
    ]"
>
    <x-calc.select name="tank" label="Tank" :options="['vertical' => 'Vertical cylinder', 'horizontal' => 'Horizontal cylinder', 'rectangle' => 'Rectangular', 'capsule_h' => 'Horizontal capsule', 'capsule_v' => 'Vertical capsule', 'cone' => 'Cone-bottom (vertical)', 'sphere' => 'Sphere']" selected="horizontal" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diameter" label="Diameter (or width for rectangular)" value="4" min="0" placeholder="Diameter (or width for rectangular)">
            <label for="calc-diameter-unit" class="sr-only">Diameter (or width for rectangular) unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="tank:vertical,horizontal,rectangle,capsule_h,capsule_v,cone">
            <x-calc.field name="length" label="Length or cylinder height (straight part)" value="10" min="0" placeholder="Length or cylinder height (straight part)">
                <label for="calc-length-unit" class="sr-only">Length or cylinder height (straight part) unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="tank:rectangle" hidden>
            <x-calc.field name="height" label="Height" value="4" min="0" placeholder="Height">
                <label for="calc-height-unit" class="sr-only">Height unit</label>
                <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="tank:cone" hidden>
            <x-calc.field name="cone" label="Cone height" value="2" min="0" placeholder="Cone height">
                <label for="calc-cone-unit" class="sr-only">Cone height unit</label>
                <select id="calc-cone-unit" name="cone-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.field name="fill" label="Liquid depth (optional)" value="30" min="0" placeholder="Full">
        <label for="calc-fill-unit" class="sr-only">Liquid depth (optional) unit</label>
        <select id="calc-fill-unit" name="fill-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Liquid in the tank" />

    <x-calc.options :examples="[
        'Horizontal 4 × 10 ft at 30 in' => ['tank' => 'horizontal', 'diameter' => 4, 'diameter-unit' => 'ft', 'length' => 10, 'length-unit' => 'ft', 'fill' => 30, 'fill-unit' => 'in'],
        'Vertical 8 ft × 12 ft' => ['tank' => 'vertical', 'diameter' => 8, 'diameter-unit' => 'ft', 'length' => 12, 'length-unit' => 'ft', 'fill' => ''],
        'Cone-bottom 1.5 m' => ['tank' => 'cone', 'diameter' => 1.5, 'diameter-unit' => 'm', 'length' => 2, 'length-unit' => 'm', 'cone' => 0.6, 'cone-unit' => 'm', 'fill' => 1500, 'fill-unit' => 'mm'],
        'Propane capsule' => ['tank' => 'capsule_h', 'diameter' => 37, 'diameter-unit' => 'in', 'length' => 10, 'length-unit' => 'ft', 'fill' => 24, 'fill-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'capacity' => ['label' => 'Capacity'],
            'liters' => ['label' => 'Liters'],
            'ft3' => ['label' => 'Cubic feet'],
            'weight' => ['label' => 'Water weight'],
            'empty' => ['label' => 'Space left'],
        ]" />
        <x-calc.quick-ref heading="Dip chart" name="chart" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>horizontal: L × (r² acos((r − h) ÷ r) − (r − h) √(2rh − h²))</li>
            <li>sphere cap: π h² (3r − h) ÷ 3</li>
            <li>cone to depth h: π (r h ÷ H)² h ÷ 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
