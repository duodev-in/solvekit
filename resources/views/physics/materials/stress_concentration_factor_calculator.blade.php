<x-calc.page
    title="Stress Concentration Factor Calculator - SolveKit"
    description="Free stress concentration factor calculator: Kt for a hole in a plate and for elliptical holes, with peak stress."
    lede="Find Kt for a hole."
    about="Holes and notches raise the local stress above the average. Kt is the peak stress divided by the nominal stress. A small round hole in a wide plate has Kt ≈ 3 on the gross section; sharp elliptical holes are far worse."
    :calc="['engine' => 'ph-mat', 'tool' => 'scf', 'fields' => ['geom', 'd', 'W', 't', 'F', 'a', 'b'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'W' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Kt for a 10 mm hole in a 50 mm plate?', 'answer' => '2.519.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="geom" label="Geometry" :options="['hole' => 'Circular hole in a plate under tension', 'ellipse' => 'Elliptical hole in a wide plate (Inglis)']" selected="hole" />
        <div data-show-when="geom:hole">
            <x-calc.field name="d" label="Hole diameter" value="10" placeholder="Hole diameter">
                <label for="calc-d-unit" class="sr-only">Hole diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:hole">
            <x-calc.field name="W" label="Plate width" value="50" placeholder="Plate width">
                <label for="calc-W-unit" class="sr-only">Plate width unit</label>
                <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:hole">
            <x-calc.field name="t" label="Plate thickness" value="5" placeholder="Plate thickness">
                <label for="calc-t-unit" class="sr-only">Plate thickness unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:hole">
            <x-calc.field name="F" label="Tension force (optional)" value="10" placeholder="Tension force (optional)">
                <label for="calc-F-unit" class="sr-only">Tension force (optional) unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:ellipse">
            <x-calc.field name="a" label="Semi-axis across the load" value="10" placeholder="Semi-axis across the load">
                <label for="calc-a-unit" class="sr-only">Semi-axis across the load unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:ellipse">
            <x-calc.field name="b" label="Semi-axis along the load" value="2" placeholder="Semi-axis along the load">
                <label for="calc-b-unit" class="sr-only">Semi-axis along the load unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Stress concentration factor Kt" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['geom' => 'hole', 'd' => 10, 'd-unit' => 'mm', 'W' => 50, 'W-unit' => 'mm', 't' => 5, 't-unit' => 'mm', 'F' => 10, 'F-unit' => 'kn', 'a' => 10, 'a-unit' => 'mm', 'b' => 2, 'b-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nominal' => ['label' => 'Nominal (net-section) stress'],
            'peak' => ['label' => 'Peak stress at the edge of the hole'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
