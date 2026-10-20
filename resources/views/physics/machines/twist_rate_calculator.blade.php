<x-calc.page
    title="Twist Rate Calculator - SolveKit"
    description="Free twist rate calculator: barrel twist needed to stabilise a bullet, by the Miller rule."
    lede="Find the barrel twist you need."
    about="Longer bullets need faster spin. Don Miller’s rule estimates the slowest twist that keeps a bullet gyroscopically stable (S_g ≥ 1.4–1.5 for accuracy)."
    :calc="['engine' => 'ph-mach', 'tool' => 'twist_rate', 'fields' => ['d', 'L', 'm', 'v', 's', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What twist does a 168-grain .308 at 2,700 ft/s need?', 'answer' => '1:12.8 in or faster (Miller rule, standard air).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Bullet diameter" value="0.308" placeholder="Bullet diameter">
            <label for="calc-d-unit" class="sr-only">Bullet diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Bullet length" value="1.215" placeholder="Bullet length">
            <label for="calc-L-unit" class="sr-only">Bullet length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m" label="Bullet weight" value="168" min="0" placeholder="Bullet weight">
            <label for="calc-m-unit" class="sr-only">Bullet weight unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Muzzle velocity" value="2700" placeholder="Muzzle velocity">
            <label for="calc-v-unit" class="sr-only">Muzzle velocity unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="s" label="Target stability factor" value="1.5" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
    </div>

    <x-calc.result label="Slowest twist for stability (1 turn in)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'in', 'd' => 0.308, 'd-unit' => 'in', 'L' => 1.215, 'L-unit' => 'in', 'm' => 168, 'm-unit' => 'gr', 'v' => 2700, 'v-unit' => 'fts', 's' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cal' => ['label' => 'Twist in calibers'],
            'sg' => ['label' => 'Stability with a 1:10 twist'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
