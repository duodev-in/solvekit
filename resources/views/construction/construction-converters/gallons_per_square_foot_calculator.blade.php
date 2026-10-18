<x-calc.page
    title="Gallons per Square Foot Calculator - SolveKit"
    description="Free gallons per square foot calculator: coverage rate from gallons and area, or from a liquid depth, in gal/ft², L/m² and ft² per gallon."
    lede="Work out a coverage rate in gallons per square foot, or the depth of liquid it makes."
    about="A gallon is 231 in³, so 1 gal/ft² spread evenly is 231 ÷ 144 = 1.604 in deep, and equals 40.74 L/m². Coatings, sealers, irrigation and rainfall all use these rates."
    :calc="['engine' => 'con-area', 'tool' => 'gallons_per_square_foot', 'fields' => ['mode', 'volume', 'area', 'depth', 'area'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the input', 'text' => 'A volume over an area, or a depth.'],
        ['name' => 'Read the rate', 'text' => 'In gal/ft², L/m² and ft² per gallon.'],
    ]"
    :faqs="[
        ['question' => 'How deep is 1 gallon per square foot?', 'answer' => '1.604 inches (40.7 mm).'],
        ['question' => 'How many gallons is 1 inch of water on 1,000 ft²?', 'answer' => 'About 623 gallons.'],
        ['question' => 'What is 1 L/m² in gal/ft²?', 'answer' => '0.0245 gal/ft²; 1 L/m² is also 1 mm deep.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['volume' => 'Volume and area', 'depth' => 'Liquid depth']" selected="volume" />

    <div data-show-when="mode:volume">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="volume" label="Volume" value="5" min="0" placeholder="Volume">
                <label for="calc-volume-unit" class="sr-only">Volume unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="area" label="Area covered" value="200" min="0" placeholder="Area covered">
                <label for="calc-area-unit" class="sr-only">Area covered unit</label>
                <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:depth" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="depth" label="Depth" value="1" min="0" placeholder="Depth">
                <label for="calc-depth-unit" class="sr-only">Depth unit</label>
                <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="area" label="Area (optional)" value="" min="0" placeholder="Area (optional)">
                <label for="calc-area-unit" class="sr-only">Area (optional) unit</label>
                <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Coverage rate" />

    <x-calc.options :examples="[
        '5 gal over 200 ft²' => ['mode' => 'volume', 'volume' => 5, 'volume-unit' => 'gal_us', 'area' => 200, 'area-unit' => 'ft2'],
        '1 in of water' => ['mode' => 'depth', 'depth' => 1, 'depth-unit' => 'in'],
        '10 L over 25 m²' => ['mode' => 'volume', 'volume' => 10, 'volume-unit' => 'l', 'area' => 25, 'area-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lm2' => ['label' => 'Liters per m²'],
            'ft2gal' => ['label' => 'Coverage'],
            'depth' => ['label' => 'Liquid depth'],
            'total' => ['label' => 'Total'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = volume ÷ area</li>
            <li>1 gal/ft² = 1.604 in = 40.74 L/m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
