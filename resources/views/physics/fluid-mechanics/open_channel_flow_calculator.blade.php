<x-calc.page
    title="Open Channel Flow Calculator - SolveKit"
    description="Free open channel flow calculator: Manning flow rate and velocity for common channel shapes."
    lede="Find open-channel flow with Manning."
    about="Manning’s equation gives the uniform flow in channels and part-full pipes from the slope, roughness and hydraulic radius."
    :calc="['engine' => 'ph-fluid', 'tool' => 'open_channel', 'fields' => ['shape', 'b', 'z', 'd', 'y', 'lining', 'n', 'S', 'out'], 'unitFields' => ['b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'y' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['manning'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flows in the example concrete channel?', 'answer' => '4.04806 m³/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Channel" :options="['rect' => 'Rectangular', 'trap' => 'Trapezoidal', 'tri' => 'Triangular (V)', 'circle' => 'Circular pipe, part full']" selected="trap" />
        <div data-show-when="shape:rect,trap">
            <x-calc.field name="b" label="Bottom width" value="2" placeholder="Bottom width">
                <label for="calc-b-unit" class="sr-only">Bottom width unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:trap,tri">
            <x-calc.field name="z" label="Side slope (horizontal per 1 vertical)" value="1.5" min="0" step="any" />
        </div>
        <div data-show-when="shape:circle">
            <x-calc.field name="d" label="Pipe diameter" value="1" placeholder="Pipe diameter">
                <label for="calc-d-unit" class="sr-only">Pipe diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="y" label="Water depth" value="0.8" placeholder="Water depth">
            <label for="calc-y-unit" class="sr-only">Water depth unit</label>
            <select id="calc-y-unit" name="y-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="lining" label="Lining" :options="['pvc' => 'PVC or smooth plastic', 'concrete_finished' => 'Concrete, trowel finished', 'concrete_unfinished' => 'Concrete, unfinished', 'cast_iron' => 'Cast iron', 'corrugated' => 'Corrugated metal', 'earth_clean' => 'Earth channel, clean', 'gravel' => 'Gravel bed', 'earth_weedy' => 'Earth channel, grass and weeds', 'natural' => 'Natural stream, clean and straight', 'natural_stony' => 'Natural stream, stones and weeds', 'custom' => 'Other (enter the value)']" selected="concrete_finished" />
        <div data-show-when="lining:custom">
            <x-calc.field name="n" label="Manning n" value="0.013" min="0" step="any" />
        </div>
        <x-calc.field name="S" label="Bed slope (m per m)" value="0.001" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="m3s" />
    </div>

    <x-calc.result label="Flow rate (Manning)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm3s', 'shape' => 'trap', 'b' => 2, 'b-unit' => 'm', 'z' => 1.5, 'd' => 1, 'd-unit' => 'm', 'y' => 0.8, 'y-unit' => 'm', 'lining' => 'concrete_finished', 'n' => 0.013, 'S' => 0.001],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Mean velocity'],
            'R' => ['label' => 'Hydraulic radius'],
            'Fr' => ['label' => 'Froude number'],
            'n' => ['label' => 'Manning n used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
