<x-calc.page
    title="Tonnage Calculator - SolveKit"
    description="Free tonnage calculator: tons of gravel, sand, soil, rock or any bulk material from its volume, in short, metric and long tons."
    lede="Work out the weight in tons of a volume of bulk material."
    about="Weight = volume × bulk density. Loose density is for material as delivered or dumped; bank density is for material in place before it is dug. Densities come from the Caterpillar Performance Handbook table of material characteristics."
    :calc="['engine' => 'con-bulk', 'tool' => 'tonnage', 'fields' => ['input', 'volume', 'length', 'width', 'depth', 'material', 'state', 'density', 'price', 'price_basis'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Enter the volume', 'text' => 'Or the length, width and depth.'],
        ['name' => 'Choose the material', 'text' => 'Loose for delivered material, bank for material in the ground.'],
    ]"
    :faqs="[
        ['question' => 'How many tons in a cubic yard of gravel?', 'answer' => 'About 1.42 US tons loose for dry ¼–2 in gravel.'],
        ['question' => 'What is the difference between short and metric tons?', 'answer' => 'A US (short) ton is 2000 lb (907.2 kg); a metric ton is 1000 kg.'],
        ['question' => 'What is bank density?', 'answer' => 'The density of material undisturbed in the ground; digging loosens it and it swells.'],
    ]"
>
    <x-calc.segmented name="input" legend="From" :options="['volume' => 'Volume', 'size' => 'Length × width × depth']" selected="volume" />

    <div data-show-when="input:volume">
        <x-calc.field name="volume" label="Volume" value="10" min="0" placeholder="Volume">
            <label for="calc-volume-unit" class="sr-only">Volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'yd3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="input:size" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="length" label="Length" value="10" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="10" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="depth" label="Depth" value="6" min="0" placeholder="Depth">
                <label for="calc-depth-unit" class="sr-only">Depth unit</label>
                <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Material" :options="collect(config('construction_data.bulk'))->map(fn ($b) => $b['name'])->all()" selected="gravel_dry_6_50" />
        <x-calc.segmented name="state" legend="Density" :options="['loose' => 'Loose', 'bank' => 'In place (bank)']" selected="loose" />
    </div>

    <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
        <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
        <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lbft3')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
        <x-calc.select name="price_basis" label="Price basis" :options="['ton' => 'per US ton', 'yd3' => 'per yd³', 't' => 'per metric ton']" selected="ton" />
    </div>

    <x-calc.result label="Weight" />

    <x-calc.options :examples="[
        '10 yd³ of gravel' => ['input' => 'volume', 'volume' => 10, 'volume-unit' => 'yd3', 'material' => 'gravel_dry_6_50', 'state' => 'loose'],
        'Topsoil 20 × 15 ft × 6 in' => ['input' => 'size', 'length' => 20, 'width' => 15, 'length-unit' => 'ft', 'width-unit' => 'ft', 'depth' => 6, 'depth-unit' => 'in', 'material' => 'topsoil', 'state' => 'loose'],
        'Clay in the ground, 50 m³' => ['input' => 'volume', 'volume' => 50, 'volume-unit' => 'm3', 'material' => 'clay_natural', 'state' => 'bank'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tonnes' => ['label' => 'Metric tons'],
            'pounds' => ['label' => 'Pounds'],
            'yd3' => ['label' => 'Cubic yards'],
            'ft3' => ['label' => 'Cubic feet'],
            'm3' => ['label' => 'Cubic meters'],
            'bags' => ['label' => 'Bags'],
            'density' => ['label' => 'Density used'],
            'cost' => ['label' => 'Cost'],
            'long' => ['label' => 'Long tons'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = volume × density</li>
            <li>1 US ton = 2000 lb; 1 t = 1000 kg; 1 long ton = 2240 lb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
