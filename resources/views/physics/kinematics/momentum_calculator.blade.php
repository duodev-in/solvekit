<x-calc.page
    title="Momentum Calculator - SolveKit"
    description="Free momentum calculator: solve p = mv for momentum, mass or velocity in any units."
    lede="Solve p = mv."
    about="Momentum is mass times velocity, a vector pointing the way the object moves. It is conserved in collisions, which is what makes it so useful."
    :calc="['engine' => 'ph-mech', 'tool' => 'momentum', 'fields' => ['solve', 'p', 'm', 'v', 'out_p', 'out_m', 'out_v'], 'unitFields' => ['p' => collect(config('units.momentum'))->only(['kgms', 'gcms', 'lbfts', 'lbfs'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'momentum', 'p', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the momentum of 10 kg moving at 3 m/s?', 'answer' => '30 kg·m/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['p' => 'Momentum', 'm' => 'Mass', 'v' => 'Velocity']" selected="p" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,v" hidden>
            <x-calc.field name="p" label="Momentum" value="30" placeholder="Momentum">
                <label for="calc-p-unit" class="sr-only">Momentum unit</label>
                <select id="calc-p-unit" name="p-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.momentum'))->only(['kgms', 'gcms', 'lbfts', 'lbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:p,v">
            <x-calc.field name="m" label="Mass" value="10" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:p,m">
            <x-calc.field name="v" label="Velocity" value="3" placeholder="Velocity">
                <label for="calc-v-unit" class="sr-only">Velocity unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:p">
            <x-calc.select name="out_p" label="Show the result in" :options="['kgms' => 'kg·m/s', 'gcms' => 'g·cm/s', 'lbfts' => 'lb·ft/s', 'lbfs' => 'lbf·s']" selected="kgms" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
    </div>

    <x-calc.result label="Momentum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'p', 'p' => 30, 'p-unit' => 'kgms', 'out_p' => 'kgms', 'm' => 10, 'm-unit' => 'kg', 'out_m' => 'kg', 'v' => 3, 'v-unit' => 'ms', 'out_v' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ke' => ['label' => 'Kinetic energy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p = m × v</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
