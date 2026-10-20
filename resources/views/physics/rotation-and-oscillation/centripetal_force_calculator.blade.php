<x-calc.page
    title="Centripetal Force Calculator - SolveKit"
    description="Free centripetal force calculator: F = mv²/r for force, mass, speed or radius."
    lede="Solve F = mv² ÷ r."
    about="Moving in a circle needs a force toward the centre, mv²/r. For a car it comes from tyre friction; for a satellite, gravity."
    :calc="['engine' => 'ph-mech', 'tool' => 'centripetal', 'fields' => ['solve', 'F', 'm', 'v', 'r', 'out_F', 'out_m', 'out_v', 'out_r'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['F', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What force turns 1,000 kg at 36 km/h on a 100 m radius?', 'answer' => '1,000 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Centripetal force', 'm' => 'Mass', 'v' => 'Speed', 'r' => 'Radius']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,v,r" hidden>
            <x-calc.field name="F" label="Centripetal force" value="1000" placeholder="Centripetal force">
                <label for="calc-F-unit" class="sr-only">Centripetal force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,v,r">
            <x-calc.field name="m" label="Mass" value="1000" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m,r">
            <x-calc.field name="v" label="Speed" value="36" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m,v">
            <x-calc.field name="r" label="Radius" value="100" placeholder="Radius">
                <label for="calc-r-unit" class="sr-only">Radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
    </div>

    <x-calc.result label="Centripetal force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 1000, 'F-unit' => 'n', 'out_F' => 'n', 'm' => 1000, 'm-unit' => 'kg', 'out_m' => 'kg', 'v' => 36, 'v-unit' => 'kmh', 'out_v' => 'kmh', 'r' => 100, 'r-unit' => 'm', 'out_r' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'a' => ['label' => 'Centripetal acceleration'],
            'T' => ['label' => 'Time for one lap'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = m v² ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
