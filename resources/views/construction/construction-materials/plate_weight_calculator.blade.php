<x-calc.page
    title="Plate Weight Calculator - SolveKit"
    description="Free plate weight calculator: weight of steel, stainless, aluminum or other metal plate and sheet, per square foot and in total."
    lede="Work out the weight of steel or metal plate."
    about="Plate weight = length × width × thickness × density. Carbon steel plate weighs 40.8 lb/ft² per inch of thickness (7.85 g/cm³); this also covers steel plate weight."
    :calc="['engine' => 'con-weight', 'tool' => 'metal_weight', 'fields' => ['plate_width', 'plate_thickness', 'length', 'count', 'metal', 'density', 'price'], 'unitFields' => ['plate_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'plate_thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => ['metals' => config('construction_data.metals')]]"
    :how-to="[
        ['name' => 'Enter the plate size', 'text' => 'Width, length and thickness.'],
        ['name' => 'Choose the metal', 'text' => 'Steel by default.'],
    ]"
    :faqs="[
        ['question' => 'How much does a 4 × 8 ft steel plate weigh?', 'answer' => 'About 327 lb at ¼ in thick.'],
        ['question' => 'How much does ½ in steel plate weigh?', 'answer' => '20.4 lb per square foot.'],
        ['question' => 'Does stainless plate weigh more?', 'answer' => 'Slightly: 304 is about 0.6% heavier than carbon steel, 316 about 2%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="plate_width" label="Width" value="48" min="0" placeholder="Width">
            <label for="calc-plate_width-unit" class="sr-only">Width unit</label>
            <select id="calc-plate_width-unit" name="plate_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="plate_thickness" label="Thickness" value="0.25" min="0" placeholder="Thickness">
            <label for="calc-plate_thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-plate_thickness-unit" name="plate_thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="96" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Pieces" value="1" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="metal" label="Metal" :options="collect(config('construction_data.metals'))->map(fn ($m) => $m['name'])->all()" selected="steel" />
        <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
            <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per lb (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Plate weight" />

    <x-calc.options :examples="[
        'Steel 4 × 8 ft, ¼ in' => ['plate_width' => 48, 'plate_width-unit' => 'in', 'plate_thickness' => 0.25, 'plate_thickness-unit' => 'in', 'length' => 96, 'length-unit' => 'in', 'count' => 1, 'metal' => 'steel'],
        'Aluminum 1000 × 2000 × 3 mm' => ['plate_width' => 1000, 'plate_width-unit' => 'mm', 'plate_thickness' => 3, 'plate_thickness-unit' => 'mm', 'length' => 2000, 'length-unit' => 'mm', 'count' => 5, 'metal' => 'al_5052'],
        'Stainless 316, 12 × 12 × ½ in' => ['plate_width' => 12, 'plate_width-unit' => 'in', 'plate_thickness' => 0.5, 'plate_thickness-unit' => 'in', 'length' => 12, 'length-unit' => 'in', 'count' => 1, 'metal' => 'stainless_316'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total weight'],
            'piece' => ['label' => 'Each piece'],
            'per_length' => ['label' => 'Per length'],
            'area' => ['label' => 'Cross-section'],
            'density' => ['label' => 'Density'],
            'cost' => ['label' => 'Cost'],
            'per_area' => ['label' => 'Per area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = L × W × t × density</li>
            <li>steel: 40.84 lb/ft² per inch</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
