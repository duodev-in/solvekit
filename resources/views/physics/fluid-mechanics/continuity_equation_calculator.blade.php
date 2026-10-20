<x-calc.page
    title="Continuity Equation Calculator - SolveKit"
    description="Free continuity equation calculator: A₁v₁ = A₂v₂ for velocities and diameters, solved for any value."
    lede="Solve A₁v₁ = A₂v₂."
    about="An incompressible fluid speeds up where a pipe narrows: halving the diameter quadruples the velocity."
    :calc="['engine' => 'ph-fluid', 'tool' => 'continuity', 'fields' => ['solve', 'v2', 'v1', 'd1', 'd2', 'out_v2', 'out_v1', 'out_d1', 'out_d2'], 'unitFields' => ['v2' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'v1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'd1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'v2'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How fast is the flow after narrowing from 100 mm to 50 mm at 1 m/s?', 'answer' => '4 m/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v2' => 'Velocity at section 2', 'v1' => 'Velocity at section 1', 'd1' => 'Diameter at section 1', 'd2' => 'Diameter at section 2']" selected="v2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v1,d1,d2" hidden>
            <x-calc.field name="v2" label="Velocity at section 2" value="4" placeholder="Velocity at section 2">
                <label for="calc-v2-unit" class="sr-only">Velocity at section 2 unit</label>
                <select id="calc-v2-unit" name="v2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v2,d1,d2">
            <x-calc.field name="v1" label="Velocity at section 1" value="1" placeholder="Velocity at section 1">
                <label for="calc-v1-unit" class="sr-only">Velocity at section 1 unit</label>
                <select id="calc-v1-unit" name="v1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v2,v1,d2">
            <x-calc.field name="d1" label="Diameter at section 1" value="100" placeholder="Diameter at section 1">
                <label for="calc-d1-unit" class="sr-only">Diameter at section 1 unit</label>
                <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v2,v1,d1">
            <x-calc.field name="d2" label="Diameter at section 2" value="50" placeholder="Diameter at section 2">
                <label for="calc-d2-unit" class="sr-only">Diameter at section 2 unit</label>
                <select id="calc-d2-unit" name="d2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v2">
            <x-calc.select name="out_v2" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:v1" hidden>
            <x-calc.select name="out_v1" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:d1" hidden>
            <x-calc.select name="out_d1" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
        <div data-show-when="solve:d2" hidden>
            <x-calc.select name="out_d2" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
    </div>

    <x-calc.result label="Velocity at section 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v2', 'v2' => 4, 'v2-unit' => 'ms', 'out_v2' => 'ms', 'v1' => 1, 'v1-unit' => 'ms', 'out_v1' => 'ms', 'd1' => 100, 'd1-unit' => 'mm', 'out_d1' => 'mm', 'd2' => 50, 'd2-unit' => 'mm', 'out_d2' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'Q' => ['label' => 'Flow rate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A₁v₁ = A₂v₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
