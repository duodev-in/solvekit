<x-calc.page
    title="Recoil Energy Calculator - SolveKit"
    description="Free recoil energy calculator: free recoil energy and velocity of a firearm from bullet, powder and gun weights."
    lede="Find a firearm’s recoil."
    about="The gun’s backward momentum equals the forward momentum of the bullet and powder gases. The recoil energy is ½m_gun v². SAAMI uses about 4,000 ft/s for the gas velocity of rifle loads."
    :calc="['engine' => 'ph-mech', 'tool' => 'recoil', 'fields' => ['mb', 'vb', 'mp', 'mg', 'vp', 'out'], 'unitFields' => ['mb' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'vb' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'mp' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'mg' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'vp' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'momentum', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the recoil energy of the example rifle?', 'answer' => '15.2392 ft·lbf.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mb" label="Bullet weight" value="150" min="0" placeholder="Bullet weight">
            <label for="calc-mb-unit" class="sr-only">Bullet weight unit</label>
            <select id="calc-mb-unit" name="mb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vb" label="Muzzle velocity" value="2800" placeholder="Muzzle velocity">
            <label for="calc-vb-unit" class="sr-only">Muzzle velocity unit</label>
            <select id="calc-vb-unit" name="vb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mp" label="Powder charge" value="50" min="0" placeholder="Powder charge">
            <label for="calc-mp-unit" class="sr-only">Powder charge unit</label>
            <select id="calc-mp-unit" name="mp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mg" label="Firearm weight" value="8" min="0" placeholder="Firearm weight">
            <label for="calc-mg-unit" class="sr-only">Firearm weight unit</label>
            <select id="calc-mg-unit" name="mg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vp" label="Powder gas velocity (SAAMI)" value="4000" placeholder="Powder gas velocity (SAAMI)">
            <label for="calc-vp-unit" class="sr-only">Powder gas velocity (SAAMI) unit</label>
            <select id="calc-vp-unit" name="vp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="ftlbf" />
    </div>

    <x-calc.result label="Recoil energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ftlbf', 'mb' => 150, 'mb-unit' => 'gr', 'vb' => 2800, 'vb-unit' => 'fts', 'mp' => 50, 'mp-unit' => 'gr', 'mg' => 8, 'mg-unit' => 'lb', 'vp' => 4000, 'vp-unit' => 'fts'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Recoil velocity'],
            'impulse' => ['label' => 'Recoil impulse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
