<x-calc.page
    title="Mass Moment of Inertia Calculator - SolveKit"
    description="Free mass moment of inertia calculator: I for rods, discs, rings, spheres, plates and cones, with the parallel axis theorem."
    lede="Find the moment of inertia of a shape."
    about="The mass moment of inertia measures resistance to angular acceleration. It depends on how far the mass is from the axis; the parallel axis theorem adds md² for an offset axis."
    :calc="['engine' => 'ph-mech', 'tool' => 'mass_moi', 'fields' => ['shape', 'm', 'r', 'ri', 'L', 'w', 'd', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'ri' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is I for a 10 kg disc of radius 20 cm?', 'answer' => '0.2 kg·m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape and axis" :options="['rod_c' => 'Thin rod about its centre', 'rod_e' => 'Thin rod about one end', 'disc' => 'Solid disc or cylinder about its axis', 'ring' => 'Thin ring or hoop about its axis', 'tube' => 'Thick-walled tube about its axis', 'sphere' => 'Solid sphere', 'shell' => 'Thin spherical shell', 'cyl_d' => 'Solid cylinder about a diameter through its centre', 'plate' => 'Rectangular plate about its centre (perpendicular axis)', 'cone' => 'Solid cone about its axis']" selected="disc" />
        <x-calc.field name="m" label="Mass" value="10" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="shape:disc,ring,tube,sphere,shell,cyl_d,cone">
            <x-calc.field name="r" label="Radius (outer)" value="20" placeholder="Radius (outer)">
                <label for="calc-r-unit" class="sr-only">Radius (outer) unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:tube">
            <x-calc.field name="ri" label="Inner radius" value="15" placeholder="Inner radius">
                <label for="calc-ri-unit" class="sr-only">Inner radius unit</label>
                <select id="calc-ri-unit" name="ri-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rod_c,rod_e,cyl_d,plate">
            <x-calc.field name="L" label="Length" value="100" placeholder="Length">
                <label for="calc-L-unit" class="sr-only">Length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:plate">
            <x-calc.field name="w" label="Width" value="50" placeholder="Width">
                <label for="calc-w-unit" class="sr-only">Width unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="d" label="Shift the axis by (parallel axis)" value="0" placeholder="Shift the axis by (parallel axis)">
            <label for="calc-d-unit" class="sr-only">Shift the axis by (parallel axis) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kgm2' => 'kg·m²', 'gcm2' => 'g·cm²', 'kgcm2' => 'kg·cm²', 'lbft2' => 'lb·ft²', 'lbin2' => 'lb·in²']" selected="kgm2" />
    </div>

    <x-calc.result label="Mass moment of inertia" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kgm2', 'shape' => 'disc', 'm' => 10, 'm-unit' => 'kg', 'r' => 20, 'r-unit' => 'cm', 'ri' => 15, 'ri-unit' => 'cm', 'L' => 100, 'L-unit' => 'cm', 'w' => 50, 'w-unit' => 'cm', 'd' => 0, 'd-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'Radius of gyration'],
            'shifted' => ['label' => 'About the shifted axis'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
