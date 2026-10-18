<x-calc.page
    title="French Drain Calculator - SolveKit"
    description="Free French drain calculator: gravel for the trench less the pipe, filter fabric to wrap it, pipe length and fall."
    lede="Work out the gravel, pipe and fabric for a French drain."
    about="A French drain is a trench lined with filter fabric, a perforated pipe on a bed of gravel, and more gravel on top. The gravel is the trench volume less the pipe. A fall of at least 1% (1 in per 8 ft) is the usual minimum; the fabric wraps both sides, the bottom and the top with an overlap."
    :calc="['engine' => 'con-bulk', 'tool' => 'french_drain', 'fields' => ['length', 'width', 'depth', 'pipe', 'slope', 'overlap', 'material', 'density', 'price', 'price_basis'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'pipe' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'overlap' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Enter the trench', 'text' => 'Length, width and depth.'],
        ['name' => 'Enter the pipe and slope', 'text' => 'Usually 4 in perforated pipe at 1%.'],
    ]"
    :faqs="[
        ['question' => 'How deep is a French drain?', 'answer' => 'Usually 18–24 in deep and 9–12 in wide.'],
        ['question' => 'What slope does a French drain need?', 'answer' => 'At least 1%, which is 1 in of fall per 8 ft.'],
        ['question' => 'What gravel goes in a French drain?', 'answer' => 'Washed ¾–1½ in stone (such as #57) that water flows through freely.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Trench length" value="50" min="0" placeholder="Trench length">
            <label for="calc-length-unit" class="sr-only">Trench length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Trench width" value="12" min="0" placeholder="Trench width">
            <label for="calc-width-unit" class="sr-only">Trench width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Trench depth" value="18" min="0" placeholder="Trench depth">
            <label for="calc-depth-unit" class="sr-only">Trench depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pipe" label="Pipe diameter" value="4" min="0" placeholder="Pipe diameter">
            <label for="calc-pipe-unit" class="sr-only">Pipe diameter unit</label>
            <select id="calc-pipe-unit" name="pipe-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="slope" label="Slope" value="1" min="0" step="0.1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="overlap" label="Fabric overlap at the top" value="12" min="0" placeholder="Fabric overlap at the top">
            <label for="calc-overlap-unit" class="sr-only">Fabric overlap at the top unit</label>
            <select id="calc-overlap-unit" name="overlap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="material" label="Gravel" :options="collect(config('construction_data.products'))->map(fn ($p) => $p['name'])->all()" selected="gravel" />
    </div>

    <x-calc.field name="density" label="Your gravel density (optional)" value="" min="0" placeholder="Your gravel density (optional)">
        <label for="calc-density-unit" class="sr-only">Your gravel density (optional) unit</label>
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

    <x-calc.result label="Drain gravel" />

    <x-calc.options :examples="[
        '50 ft drain' => ['length' => 50, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'in', 'depth' => 18, 'depth-unit' => 'in', 'pipe' => 4, 'pipe-unit' => 'in', 'slope' => 1, 'overlap' => 12, 'overlap-unit' => 'in', 'material' => 'gravel'],
        '20 m drain' => ['length' => 20, 'length-unit' => 'm', 'width' => 300, 'width-unit' => 'mm', 'depth' => 450, 'depth-unit' => 'mm', 'pipe' => 100, 'pipe-unit' => 'mm', 'slope' => 1, 'overlap' => 300, 'overlap-unit' => 'mm', 'material' => 'crushed_stone'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pipe' => ['label' => 'Pipe'],
            'fabric' => ['label' => 'Filter fabric'],
            'fall' => ['label' => 'Fall'],
            'trench' => ['label' => 'Trench'],
            'tonnes' => ['label' => 'Metric tons'],
            'pounds' => ['label' => 'Pounds'],
            'yd3' => ['label' => 'Cubic yards'],
            'ft3' => ['label' => 'Cubic feet'],
            'm3' => ['label' => 'Cubic meters'],
            'bags' => ['label' => 'Bags'],
            'density' => ['label' => 'Density used'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gravel = L × W × D − π ÷ 4 × d² × L</li>
            <li>fall = L × slope</li>
            <li>fabric width = 2D + 2W + overlap</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
