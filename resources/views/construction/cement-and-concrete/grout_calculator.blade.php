<x-calc.page
    title="Grout Calculator - SolveKit"
    description="Free tile grout calculator: pounds of grout for a tiled area from tile size, joint width and depth, with bags."
    lede="Work out how much tile grout you need."
    about="The grout fills the joints: per tile, the joint area is j × (L + W + j) and its depth is about the tile thickness. Cured sanded grout typically weighs 1.6–1.9 kg per liter; the default of 1.8 is typical, so enter your product's figure (or compare with its coverage chart) for an exact result."
    :calc="['engine' => 'con-concrete', 'tool' => 'grout', 'fields' => ['area', 'joint', 'tile_length', 'tile_width', 'depth', 'density', 'bag', 'waste'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'joint' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tile_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tile_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all(), 'bag' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the area and tile size', 'text' => 'With the tile thickness.'],
        ['name' => 'Set the joint', 'text' => 'And check the grout density.'],
    ]"
    :faqs="[
        ['question' => 'How much grout for 100 ft² of 12 in tile?', 'answer' => 'About 7 lb with ⅛ in joints and ⅜ in thick tile, before waste.'],
        ['question' => 'Do small tiles need more grout?', 'answer' => 'Yes: there are more joints per square foot.'],
        ['question' => 'When should I use sanded grout?', 'answer' => 'For joints wider than ⅛ in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Tiled area" value="100" min="0" placeholder="Tiled area">
            <label for="calc-area-unit" class="sr-only">Tiled area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="joint" label="Joint width" value="0.125" min="0" placeholder="Joint width">
            <label for="calc-joint-unit" class="sr-only">Joint width unit</label>
            <select id="calc-joint-unit" name="joint-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="tile_length" label="Tile length" value="12" min="0" placeholder="Tile length">
            <label for="calc-tile_length-unit" class="sr-only">Tile length unit</label>
            <select id="calc-tile_length-unit" name="tile_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="tile_width" label="Tile width" value="12" min="0" placeholder="Tile width">
            <label for="calc-tile_width-unit" class="sr-only">Tile width unit</label>
            <select id="calc-tile_width-unit" name="tile_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Joint depth (tile thickness)" value="0.375" min="0" placeholder="Joint depth (tile thickness)">
            <label for="calc-depth-unit" class="sr-only">Joint depth (tile thickness) unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="density" label="Grout density" value="1.8" min="0" placeholder="Grout density">
            <label for="calc-density-unit" class="sr-only">Grout density unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bag" label="Bag size" value="25" min="0" placeholder="Bag size">
            <label for="calc-bag-unit" class="sr-only">Bag size unit</label>
            <select id="calc-bag-unit" name="bag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Grout needed" />

    <x-calc.options :examples="[
        '12 in tile, ⅛ in joints' => ['area' => 100, 'area-unit' => 'ft2', 'joint' => 0.125, 'joint-unit' => 'in', 'tile_length' => 12, 'tile_length-unit' => 'in', 'tile_width' => 12, 'tile_width-unit' => 'in', 'depth' => 0.375, 'depth-unit' => 'in', 'density' => 1.8, 'density-unit' => 'gcm3', 'bag' => 25, 'bag-unit' => 'lb', 'waste' => 10],
        '2 in mosaic' => ['area' => 40, 'area-unit' => 'ft2', 'joint' => 0.0625, 'joint-unit' => 'in', 'tile_length' => 2, 'tile_length-unit' => 'in', 'tile_width' => 2, 'tile_width-unit' => 'in', 'depth' => 0.25, 'depth-unit' => 'in', 'density' => 1.8, 'density-unit' => 'gcm3', 'bag' => 10, 'bag-unit' => 'lb', 'waste' => 10],
        'Metric 600 × 300 mm, 3 mm' => ['area' => 12, 'area-unit' => 'm2', 'joint' => 3, 'joint-unit' => 'mm', 'tile_length' => 600, 'tile_length-unit' => 'mm', 'tile_width' => 300, 'tile_width-unit' => 'mm', 'depth' => 9, 'depth-unit' => 'mm', 'density' => 1.8, 'density-unit' => 'gcm3', 'bag' => 5, 'bag-unit' => 'kg', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms'],
            'volume' => ['label' => 'Volume'],
            'per_area' => ['label' => 'Per area'],
            'bags' => ['label' => 'Bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume per area = j (L + W + j) D ÷ ((L + j)(W + j))</li>
            <li>weight = volume × density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
