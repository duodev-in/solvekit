<x-calc.page
    title="Concrete Weight Calculator - SolveKit"
    description="Free concrete weight calculator: weight of concrete by type (normal weight, reinforced, lightweight, slag, cinder) from its volume or size."
    lede="Work out how much a concrete slab, block or pour weighs."
    about="Weights are from the ASCE 7 table of design densities: reinforced stone-aggregate concrete 150 lb/ft³ and plain 144, with slag, cinder and expanded aggregates lighter. A cubic yard of reinforced normal-weight concrete weighs about 4,050 lb."
    :calc="['engine' => 'con-weight', 'tool' => 'concrete_weight', 'fields' => ['input', 'length', 'width', 'depth', 'volume', 'type'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'volume' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all()], 'data' => ['concrete' => config('construction_data.concrete')]]"
    :how-to="[
        ['name' => 'Enter the size or volume', 'text' => 'Any units.'],
        ['name' => 'Choose the concrete', 'text' => 'Reinforced normal-weight is the usual case.'],
    ]"
    :faqs="[
        ['question' => 'How much does a yard of concrete weigh?', 'answer' => 'About 4,050 lb reinforced or 3,890 lb plain (stone aggregate).'],
        ['question' => 'How much does a 4 in slab weigh per square foot?', 'answer' => 'About 50 lb/ft² reinforced.'],
        ['question' => 'What is lightweight concrete?', 'answer' => 'Concrete made with expanded shale, clay or slag, 90–115 lb/ft³.'],
    ]"
>
    <x-calc.segmented name="input" legend="From" :options="['size' => 'Length × width × thickness', 'volume' => 'Volume']" selected="size" />

    <div data-show-when="input:size">
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
            <x-calc.field name="depth" label="Thickness" value="4" min="0" placeholder="Thickness">
                <label for="calc-depth-unit" class="sr-only">Thickness unit</label>
                <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="input:volume" hidden>
        <x-calc.field name="volume" label="Volume" value="1" min="0" placeholder="Volume">
            <label for="calc-volume-unit" class="sr-only">Volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'yd3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="type" label="Concrete" :options="collect(config('construction_data.concrete'))->map(fn ($c) => $c['name'].' ('.$c['pcf'].' lb/ft³)')->all()" selected="reinforced_stone" />

    <x-calc.result label="Concrete weight" />

    <x-calc.options :examples="[
        'Slab 10 × 10 ft, 4 in' => ['input' => 'size', 'length' => 10, 'length-unit' => 'ft', 'width' => 10, 'width-unit' => 'ft', 'depth' => 4, 'depth-unit' => 'in', 'type' => 'reinforced_stone'],
        '1 yd³ plain' => ['input' => 'volume', 'volume' => 1, 'volume-unit' => 'yd3', 'type' => 'plain_stone'],
        'Lightweight 2 m³' => ['input' => 'volume', 'volume' => 2, 'volume-unit' => 'm3', 'type' => 'haydite'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms'],
            'tons' => ['label' => 'Tons'],
            'per_yd3' => ['label' => 'Per cubic yard'],
            'volume' => ['label' => 'Volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = volume × unit weight</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
