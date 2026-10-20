<x-calc.page
    title="Muzzle Velocity Calculator - SolveKit"
    description="Free muzzle velocity calculator: velocity from muzzle energy and bullet weight, or energy from velocity."
    lede="Find muzzle velocity from energy and bullet weight."
    about="Muzzle energy and velocity are linked by E = ½mv². If a load table quotes energy in foot-pounds and bullet weight in grains, this gives the velocity, and the other way round."
    :calc="['engine' => 'ph-mech', 'tool' => 'muzzle_velocity', 'fields' => ['solve', 'E', 'm', 'v', 'out_E', 'out_m', 'out_v'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'energy', 'force', 'length', 'mass', 'momentum', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What velocity gives 2,700 ft·lbf with a 150-grain bullet?', 'answer' => '2,847.43 ft/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Muzzle energy', 'm' => 'Bullet mass', 'v' => 'Muzzle velocity']" selected="v" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,v">
            <x-calc.field name="E" label="Muzzle energy" value="2700" placeholder="Muzzle energy">
                <label for="calc-E-unit" class="sr-only">Muzzle energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ftlbf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,v">
            <x-calc.field name="m" label="Bullet mass" value="150" min="0" placeholder="Bullet mass">
                <label for="calc-m-unit" class="sr-only">Bullet mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,m" hidden>
            <x-calc.field name="v" label="Muzzle velocity" value="2820" placeholder="Muzzle velocity">
                <label for="calc-v-unit" class="sr-only">Muzzle velocity unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E" hidden>
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="ftlbf" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="gr" />
        </div>
        <div data-show-when="solve:v">
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="fts" />
        </div>
    </div>

    <x-calc.result label="Muzzle velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v', 'E' => 2700, 'E-unit' => 'ftlbf', 'out_E' => 'ftlbf', 'm' => 150, 'm-unit' => 'gr', 'out_m' => 'gr', 'v' => 2820, 'v-unit' => 'fts', 'out_v' => 'fts'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'momentum' => ['label' => 'Momentum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = ½ m v²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
