<x-calc.page
    title="Conservation of Momentum Calculator - SolveKit"
    description="Free conservation of momentum calculator: find any velocity or mass in a two-body collision, with the energy check."
    lede="Solve m₁u₁ + m₂u₂ = m₁v₁ + m₂v₂ for any value."
    about="In a collision or explosion with no outside force, the total momentum before equals the total momentum after. Enter any five of the six values (two masses, two velocities before, two after) to find the last. Use negative velocities for motion in the opposite direction. The calculator also compares the kinetic energy, which shows whether the collision was elastic."
    :calc="['engine' => 'ph-mech', 'tool' => 'momentum_conservation', 'fields' => ['solve', 'm1', 'u1', 'm2', 'u2', 'v1', 'v2', 'out_m1', 'out_u1', 'out_m2', 'out_u2', 'out_v1', 'out_v2'], 'unitFields' => ['m1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'u1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'u2' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'v1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'v2' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'momentum', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'A 2 kg cart at 3 m/s hits a 1 kg cart moving at −1 m/s; the first slows to 0.5 m/s. How fast is the second?', 'answer' => '4 m/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['m1' => 'Mass 1', 'u1' => 'Velocity 1 before', 'm2' => 'Mass 2', 'u2' => 'Velocity 2 before', 'v1' => 'Velocity 1 after', 'v2' => 'Velocity 2 after']" selected="v2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:u1,m2,u2,v1,v2">
            <x-calc.field name="m1" label="Mass 1" value="2" min="0" placeholder="Mass 1">
                <label for="calc-m1-unit" class="sr-only">Mass 1 unit</label>
                <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1,m2,u2,v1,v2">
            <x-calc.field name="u1" label="Velocity 1 before" value="3" placeholder="Velocity 1 before">
                <label for="calc-u1-unit" class="sr-only">Velocity 1 before unit</label>
                <select id="calc-u1-unit" name="u1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1,u1,u2,v1,v2">
            <x-calc.field name="m2" label="Mass 2" value="1" min="0" placeholder="Mass 2">
                <label for="calc-m2-unit" class="sr-only">Mass 2 unit</label>
                <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1,u1,m2,v1,v2">
            <x-calc.field name="u2" label="Velocity 2 before" value="-1" placeholder="Velocity 2 before">
                <label for="calc-u2-unit" class="sr-only">Velocity 2 before unit</label>
                <select id="calc-u2-unit" name="u2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1,u1,m2,u2,v2">
            <x-calc.field name="v1" label="Velocity 1 after" value="0.5" placeholder="Velocity 1 after">
                <label for="calc-v1-unit" class="sr-only">Velocity 1 after unit</label>
                <select id="calc-v1-unit" name="v1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1,u1,m2,u2,v1" hidden>
            <x-calc.field name="v2" label="Velocity 2 after" value="4" placeholder="Velocity 2 after">
                <label for="calc-v2-unit" class="sr-only">Velocity 2 after unit</label>
                <select id="calc-v2-unit" name="v2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:m1" hidden>
            <x-calc.select name="out_m1" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:u1" hidden>
            <x-calc.select name="out_u1" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:m2" hidden>
            <x-calc.select name="out_m2" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:u2" hidden>
            <x-calc.select name="out_u2" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:v1" hidden>
            <x-calc.select name="out_v1" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:v2">
            <x-calc.select name="out_v2" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
    </div>

    <x-calc.result label="Velocity 2 after" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v2', 'm1' => 2, 'm1-unit' => 'kg', 'out_m1' => 'kg', 'u1' => 3, 'u1-unit' => 'ms', 'out_u1' => 'ms', 'm2' => 1, 'm2-unit' => 'kg', 'out_m2' => 'kg', 'u2' => -1, 'u2-unit' => 'ms', 'out_u2' => 'ms', 'v1' => 0.5, 'v1-unit' => 'ms', 'out_v1' => 'ms', 'v2' => 4, 'v2-unit' => 'ms', 'out_v2' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'p' => ['label' => 'Total momentum'],
            'ke' => ['label' => 'Kinetic energy before → after'],
            'type' => ['label' => 'Collision type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m₁u₁ + m₂u₂ = m₁v₁ + m₂v₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
