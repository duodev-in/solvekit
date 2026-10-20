<x-calc.page
    title="Capacitance Calculator - SolveKit"
    description="Free capacitance calculator: parallel plates, coaxial cable and spheres with common dielectrics."
    lede="Find the capacitance of a geometry."
    about="Capacitance depends only on geometry and the material between the conductors. Parallel plates give ε₀ε_rA/d; a coaxial cable 2πε/ln(b/a) per metre."
    :calc="['engine' => 'ph-em', 'tool' => 'capacitance', 'fields' => ['geom', 'A', 'd', 'a', 'b', 'L', 'diel', 'er', 'out'], 'unitFields' => ['A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'capacitance', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['dielectrics'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the capacitance of 100 cm² plates 1 mm apart in air?', 'answer' => '88.595 pF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="geom" label="Geometry" :options="['plates' => 'Parallel plates', 'coax' => 'Coaxial cylinders (cable)', 'spheres' => 'Concentric spheres', 'sphere' => 'Isolated sphere']" selected="plates" />
        <div data-show-when="geom:plates">
            <x-calc.field name="A" label="Plate area" value="100" min="0" placeholder="Plate area">
                <label for="calc-A-unit" class="sr-only">Plate area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:plates">
            <x-calc.field name="d" label="Gap" value="1" placeholder="Gap">
                <label for="calc-d-unit" class="sr-only">Gap unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:coax,spheres,sphere">
            <x-calc.field name="a" label="Inner radius" value="0.5" placeholder="Inner radius">
                <label for="calc-a-unit" class="sr-only">Inner radius unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:coax,spheres">
            <x-calc.field name="b" label="Outer radius" value="1.75" placeholder="Outer radius">
                <label for="calc-b-unit" class="sr-only">Outer radius unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="geom:coax">
            <x-calc.field name="L" label="Length" value="1" placeholder="Length">
                <label for="calc-L-unit" class="sr-only">Length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="diel" label="Dielectric" :options="['vacuum' => 'Vacuum', 'air' => 'Air', 'ptfe' => 'PTFE (Teflon)', 'polypropylene' => 'Polypropylene', 'polyethylene' => 'Polyethylene', 'polystyrene' => 'Polystyrene', 'polyester' => 'Polyester (PET film)', 'paper' => 'Paper (dry)', 'fr4' => 'FR-4 circuit board', 'glass' => 'Glass', 'mica' => 'Mica', 'alumina' => 'Alumina ceramic', 'tantalum' => 'Tantalum pentoxide', 'water' => 'Water (20 °C)', 'batio3' => 'Barium titanate (typical)', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="diel:custom">
            <x-calc.field name="er" label="Relative permittivity" value="4" min="1" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="pf" />
    </div>

    <x-calc.result label="Capacitance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'pf', 'geom' => 'plates', 'A' => 100, 'A-unit' => 'cm2', 'd' => 1, 'd-unit' => 'mm', 'a' => 0.5, 'a-unit' => 'mm', 'b' => 1.75, 'b-unit' => 'mm', 'L' => 1, 'L-unit' => 'm', 'diel' => 'air', 'er' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'er' => ['label' => 'Relative permittivity used'],
            'perm' => ['label' => 'Per metre (cable)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
