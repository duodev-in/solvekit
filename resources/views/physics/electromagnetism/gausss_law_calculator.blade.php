<x-calc.page
    title="Gauss's Law Calculator - SolveKit"
    description="Free Gauss's law calculator: electric field of point, line, plane and spherical charge distributions."
    lede="Use Gauss's law to find fields."
    about="For symmetric charge distributions Gauss’s law gives the field directly: the flux through a closed surface equals the enclosed charge over ε₀."
    :calc="['engine' => 'ph-em', 'tool' => 'gauss', 'fields' => ['dist', 'Q', 'lambda', 'sigma', 'Rb', 'r', 'out'], 'unitFields' => ['Q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'Rb' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'electric_field', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What field does 10 nC/m make 10 cm from a line?', 'answer' => '1,797.51 V/m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dist" label="Charge distribution" :options="['point' => 'Point charge (or outside a charged sphere)', 'line' => 'Infinite line', 'plane' => 'Infinite plane', 'ball' => 'Uniformly charged solid sphere']" selected="line" />
        <div data-show-when="dist:point,ball">
            <x-calc.field name="Q" label="Total charge" value="10" placeholder="Total charge">
                <label for="calc-Q-unit" class="sr-only">Total charge unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="dist:line">
            <x-calc.field name="lambda" label="Line charge density (nC/m)" value="10" step="any" />
        </div>
        <div data-show-when="dist:plane">
            <x-calc.field name="sigma" label="Surface charge density (nC/m²)" value="10" step="any" />
        </div>
        <div data-show-when="dist:ball">
            <x-calc.field name="Rb" label="Sphere radius" value="5" placeholder="Sphere radius">
                <label for="calc-Rb-unit" class="sr-only">Sphere radius unit</label>
                <select id="calc-Rb-unit" name="Rb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="dist:point,line,ball">
            <x-calc.field name="r" label="Distance from the centre or line" value="10" placeholder="Distance from the centre or line">
                <label for="calc-r-unit" class="sr-only">Distance from the centre or line unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['vpm' => 'V/m', 'kvpm' => 'kV/m', 'vpcm' => 'V/cm', 'kvpcm' => 'kV/cm', 'mvpm' => 'MV/m']" selected="vpm" />
    </div>

    <x-calc.result label="Electric field" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'vpm', 'dist' => 'line', 'Q' => 10, 'Q-unit' => 'nc', 'lambda' => 10, 'sigma' => 10, 'Rb' => 5, 'Rb-unit' => 'cm', 'r' => 10, 'r-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'surface' => ['label' => 'Gaussian surface used'],
            'enclosed' => ['label' => 'Charge enclosed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
