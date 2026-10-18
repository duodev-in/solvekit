<x-calc.page
    title="Pool Calculator - SolveKit"
    description="Free pool calculator: gallons of water in a rectangular, round or oval pool with shallow and deep ends, with fill time and water weight."
    lede="Work out how many gallons a pool holds."
    about="Volume = surface area × average depth; with a sloping floor the average is (shallow + deep) ÷ 2. One cubic foot holds 7.48 US gallons."
    :calc="['engine' => 'con-water', 'tool' => 'pool', 'fields' => ['shape', 'length', 'width', 'diameter', 'shallow', 'deep', 'flow'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'shallow' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'deep' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Pick the pool shape', 'text' => 'And enter its size.'],
        ['name' => 'Enter the depths', 'text' => 'The same twice for a flat floor.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons in a 16 × 32 ft pool?', 'answer' => 'About 22,000 gallons at 3½–8 ft deep.'],
        ['question' => 'How long to fill a pool?', 'answer' => 'At 10 gal/min, about 37 hours for 22,000 gallons.'],
        ['question' => 'How many gallons in a cubic foot?', 'answer' => '7.48.'],
    ]"
>
    <div class="flex flex-col gap-3">
        <x-calc.shape :shapes="['rectangle', 'circle', 'oval']" selected="rectangle" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="shape:rectangle,oval">
                <x-calc.field name="length" label="Length" value="32" min="0" placeholder="Length">
                    <label for="calc-length-unit" class="sr-only">Length unit</label>
                    <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:rectangle,oval">
                <x-calc.field name="width" label="Width" value="16" min="0" placeholder="Width">
                    <label for="calc-width-unit" class="sr-only">Width unit</label>
                    <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:circle" hidden>
                <x-calc.field name="diameter" label="Diameter" value="24" min="0" placeholder="Diameter">
                    <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                    <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="shallow" label="Shallow end depth" value="3.5" min="0" placeholder="Shallow end depth">
            <label for="calc-shallow-unit" class="sr-only">Shallow end depth unit</label>
            <select id="calc-shallow-unit" name="shallow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="deep" label="Deep end depth" value="8" min="0" placeholder="Deep end depth">
            <label for="calc-deep-unit" class="sr-only">Deep end depth unit</label>
            <select id="calc-deep-unit" name="deep-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="flow" label="Fill rate (optional)" value="10" min="0" suffix="gal/min" />
    </div>

    <x-calc.result label="Pool volume" />

    <x-calc.options :examples="[
        '16 × 32 ft, 3½–8 ft' => ['shape' => 'rectangle', 'length' => 32, 'width' => 16, 'length-unit' => 'ft', 'width-unit' => 'ft', 'shallow' => 3.5, 'shallow-unit' => 'ft', 'deep' => 8, 'deep-unit' => 'ft', 'flow' => 10],
        'Round 24 ft, 4 ft' => ['shape' => 'circle', 'diameter' => 24, 'diameter-unit' => 'ft', 'shallow' => 4, 'shallow-unit' => 'ft', 'deep' => 4, 'deep-unit' => 'ft', 'flow' => 10],
        'Oval 7 × 4 m' => ['shape' => 'oval', 'length' => 7, 'width' => 4, 'length-unit' => 'm', 'width-unit' => 'm', 'shallow' => 1.2, 'shallow-unit' => 'm', 'deep' => 1.2, 'deep-unit' => 'm', 'flow' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'ft3' => ['label' => 'Cubic feet'],
            'weight' => ['label' => 'Water weight'],
            'fill' => ['label' => 'Fill time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = area × (shallow + deep) ÷ 2</li>
            <li>1 ft³ = 7.4805 gal</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
