<x-calc.page
    title="Fire Glass Calculator - SolveKit"
    description="Free fire glass calculator: pounds of fire glass to fill a round, square or rectangular fire pit to a chosen depth."
    lede="Work out how many pounds of fire glass fill your fire pit."
    about="Fire glass is sold by the pound. The calculator finds the volume to fill and multiplies by the bulk density of the glass. Loose ¼–½ in fire glass is commonly listed at about 100 lb/ft³; check the figure for your product and enter it. A layer 2–4 in deep over a filler of lava rock is typical."
    :calc="['engine' => 'con-bulk', 'tool' => 'fire_glass', 'fields' => ['shape', 'length', 'width', 'diameter', 'outer', 'inner', 'depth', 'density', 'bag'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all(), 'bag' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Pick the pit shape', 'text' => 'Round, rectangular, or a ring around a burner pan.'],
        ['name' => 'Enter the fill depth', 'text' => 'Usually 2–4 in of glass.'],
        ['name' => 'Check the density', 'text' => 'Enter the figure for your product.'],
    ]"
    :faqs="[
        ['question' => 'How much fire glass for a 36 in round pit?', 'answer' => 'About 18 lb for each inch of depth at 100 lb/ft³.'],
        ['question' => 'Can I put lava rock under the glass?', 'answer' => 'Yes, many people fill the bottom with lava rock and top it with 1–2 in of glass.'],
        ['question' => 'Why is fire glass sold by weight?', 'answer' => 'Its size and shape vary; weight is easy to measure.'],
    ]"
>
    <div class="flex flex-col gap-3">
        <x-calc.shape :shapes="['circle', 'rectangle', 'ring']" selected="circle" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="shape:rectangle" hidden>
                <x-calc.field name="length" label="Length" value="48" min="0" placeholder="Length">
                    <label for="calc-length-unit" class="sr-only">Length unit</label>
                    <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:rectangle" hidden>
                <x-calc.field name="width" label="Width" value="18" min="0" placeholder="Width">
                    <label for="calc-width-unit" class="sr-only">Width unit</label>
                    <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:circle">
                <x-calc.field name="diameter" label="Diameter" value="36" min="0" placeholder="Diameter">
                    <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                    <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:ring" hidden>
                <x-calc.field name="outer" label="Outer diameter" value="40" min="0" placeholder="Outer diameter">
                    <label for="calc-outer-unit" class="sr-only">Outer diameter unit</label>
                    <select id="calc-outer-unit" name="outer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:ring" hidden>
                <x-calc.field name="inner" label="Inner diameter" value="20" min="0" placeholder="Inner diameter">
                    <label for="calc-inner-unit" class="sr-only">Inner diameter unit</label>
                    <select id="calc-inner-unit" name="inner-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="depth" label="Fill depth" value="3" min="0" placeholder="Fill depth">
            <label for="calc-depth-unit" class="sr-only">Fill depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="density" label="Bulk density" value="100" min="0" placeholder="Bulk density">
            <label for="calc-density-unit" class="sr-only">Bulk density unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbft3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="bag" label="Bag size (optional)" value="10" min="0" placeholder="Bag size (optional)">
        <label for="calc-bag-unit" class="sr-only">Bag size (optional) unit</label>
        <select id="calc-bag-unit" name="bag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Fire glass needed" />

    <x-calc.options :examples="[
        'Round 36 in, 3 in deep' => ['shape' => 'circle', 'diameter' => 36, 'diameter-unit' => 'in', 'depth' => 3, 'depth-unit' => 'in', 'density' => 100, 'density-unit' => 'lbft3', 'bag' => 10, 'bag-unit' => 'lb'],
        'Linear 48 × 12 in' => ['shape' => 'rectangle', 'length' => 48, 'width' => 12, 'length-unit' => 'in', 'width-unit' => 'in', 'depth' => 2, 'depth-unit' => 'in', 'density' => 100, 'density-unit' => 'lbft3', 'bag' => 10, 'bag-unit' => 'lb'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms'],
            'volume' => ['label' => 'Volume'],
            'bags' => ['label' => 'Bags'],
            'area' => ['label' => 'Area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = area × depth × bulk density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
