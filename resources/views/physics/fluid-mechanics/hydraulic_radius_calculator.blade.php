<x-calc.page
    title="Hydraulic Radius Calculator - SolveKit"
    description="Free hydraulic radius calculator: R_h = A/P for rectangular, trapezoidal, triangular and part-full circular channels."
    lede="Find the hydraulic radius."
    about="The hydraulic radius, flow area over wetted perimeter, measures how efficiently a channel carries water."
    :calc="['engine' => 'ph-fluid', 'tool' => 'hydraulic_radius', 'fields' => ['shape', 'b', 'z', 'd', 'y', 'out'], 'unitFields' => ['b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'y' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is R_h of the example trapezoid?', 'answer' => '0.524113 m.'],
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
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Hydraulic radius" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'shape' => 'trap', 'b' => 2, 'b-unit' => 'm', 'z' => 1.5, 'd' => 1, 'd-unit' => 'm', 'y' => 0.8, 'y-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'A' => ['label' => 'Flow area'],
            'P' => ['label' => 'Wetted perimeter'],
            'D' => ['label' => 'Hydraulic depth A/T'],
            'Dh' => ['label' => 'Hydraulic diameter 4A/P'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
