<x-calc.page
    title="Stone Weight Calculator - SolveKit"
    description="Free stone weight calculator: weight of granite, marble, limestone, sandstone and slate blocks, slabs and columns, with a check-your-answer mode."
    lede="Work out the weight of a stone block, slab or column."
    about="Weight = volume × density. Stone densities are from the ASCE 7 table of minimum design densities: granite and crystalline limestone 165 lb/ft³, marble 173, slate 172, sandstone 144 and oolitic limestone 135. Natural stone varies by quarry; enter a measured density if you have one."
    :calc="['engine' => 'con-weight', 'tool' => 'stone_weight', 'fields' => ['form', 'length', 'width', 'height', 'diameter', 'length', 'volume', 'stone', 'count', 'density', 'answer'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'volume' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all(), 'answer' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['stone' => config('construction_data.stone')]]"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'Block, cylinder or a known volume.'],
        ['name' => 'Choose the stone', 'text' => 'Or enter a density.'],
        ['name' => 'Check an answer', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'How much does a granite countertop weigh?', 'answer' => 'About 18–19 lb per square foot at 3 cm (1¼ in).'],
        ['question' => 'Is marble heavier than granite?', 'answer' => 'Slightly: 173 against 165 lb/ft³ in the ASCE 7 table.'],
        ['question' => 'How much does a cubic foot of stone weigh?', 'answer' => '135–173 lb depending on the stone.'],
    ]"
>
    <x-calc.select name="form" label="Shape" :options="['block' => 'Block or slab', 'cylinder' => 'Cylinder or column', 'volume' => 'Known volume']" selected="block" />

    <div data-show-when="form:block">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="length" label="Length" value="24" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="12" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="height" label="Thickness" value="2" min="0" placeholder="Thickness">
                <label for="calc-height-unit" class="sr-only">Thickness unit</label>
                <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:cylinder" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="diameter" label="Diameter" value="12" min="0" placeholder="Diameter">
                <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="length" label="Length" value="48" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:volume" hidden>
        <x-calc.field name="volume" label="Volume" value="1" min="0" placeholder="Volume">
            <label for="calc-volume-unit" class="sr-only">Volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="stone" label="Stone" :options="collect(config('construction_data.stone'))->map(fn ($s) => $s['name'].' ('.$s['pcf'].' lb/ft³)')->all()" selected="granite" />
        <x-calc.field name="count" label="Pieces" value="1" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
            <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbft3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="answer" label="Your answer, to check (optional)" value="" min="0" placeholder="Your answer, to check (optional)">
            <label for="calc-answer-unit" class="sr-only">Your answer, to check (optional) unit</label>
            <select id="calc-answer-unit" name="answer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Stone weight" />

    <x-calc.options :examples="[
        'Granite slab 24 × 12 × 2 in' => ['form' => 'block', 'length' => 24, 'length-unit' => 'in', 'width' => 12, 'width-unit' => 'in', 'height' => 2, 'height-unit' => 'in', 'stone' => 'granite', 'count' => 1],
        'Marble column 30 cm × 2 m' => ['form' => 'cylinder', 'diameter' => 30, 'diameter-unit' => 'cm', 'length' => 2, 'length-unit' => 'm', 'stone' => 'marble', 'count' => 1],
        'Check: 1 ft³ of slate' => ['form' => 'volume', 'volume' => 1, 'volume-unit' => 'ft3', 'stone' => 'slate', 'count' => 1, 'answer' => 172, 'answer-unit' => 'lb'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'piece' => ['label' => 'Each piece'],
            'tons' => ['label' => 'Tons'],
            'volume' => ['label' => 'Volume'],
            'density' => ['label' => 'Density'],
            'answer' => ['label' => 'Your answer'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = volume × density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
