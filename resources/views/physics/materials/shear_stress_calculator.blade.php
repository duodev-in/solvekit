<x-calc.page
    title="Shear Stress Calculator - SolveKit"
    description="Free shear stress calculator: direct shear in bolts and pins, torsional shear in shafts and maximum beam shear."
    lede="Find shear stress."
    about="Shear stress acts parallel to a surface. Bolts and pins see roughly F/A; shafts in torsion see Tr/J at the surface; beams see the most shear at the neutral axis."
    :calc="['engine' => 'ph-mat', 'tool' => 'shear_stress', 'fields' => ['mode', 'F', 'A', 'planes', 'T', 'd', 'b', 'h', 'out'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'T' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the shear in a 10 mm pin under 10 kN?', 'answer' => '127.324 MPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Situation" :options="['direct' => 'Direct shear (bolt, pin): F ÷ A', 'torsion' => 'Shaft in torsion: Tr ÷ J', 'beam_rect' => 'Beam, rectangular section', 'beam_round' => 'Beam, solid round section']" selected="direct" />
        <div data-show-when="mode:direct,beam_rect,beam_round">
            <x-calc.field name="F" label="Shear force" value="10" placeholder="Shear force">
                <label for="calc-F-unit" class="sr-only">Shear force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:direct">
            <x-calc.field name="A" label="Shear area" value="78.54" min="0" placeholder="Shear area">
                <label for="calc-A-unit" class="sr-only">Shear area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:direct">
            <x-calc.field name="planes" label="Shear planes (2 for double shear)" value="1" min="1" step="any" />
        </div>
        <div data-show-when="mode:torsion">
            <x-calc.field name="T" label="Torque" value="500" placeholder="Torque">
                <label for="calc-T-unit" class="sr-only">Torque unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:torsion,beam_round">
            <x-calc.field name="d" label="Diameter" value="40" placeholder="Diameter">
                <label for="calc-d-unit" class="sr-only">Diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:beam_rect">
            <x-calc.field name="b" label="Width" value="50" placeholder="Width">
                <label for="calc-b-unit" class="sr-only">Width unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:beam_rect">
            <x-calc.field name="h" label="Depth" value="100" placeholder="Depth">
                <label for="calc-h-unit" class="sr-only">Depth unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
    </div>

    <x-calc.result label="Shear stress" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpa', 'mode' => 'direct', 'F' => 10, 'F-unit' => 'kn', 'A' => 78.54, 'A-unit' => 'mm2', 'planes' => 1, 'T' => 500, 'T-unit' => 'nm', 'd' => 40, 'd-unit' => 'mm', 'b' => 50, 'b-unit' => 'mm', 'h' => 100, 'h-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'avg' => ['label' => 'Average shear stress'],
            'note' => ['label' => 'Where'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
