<x-calc.page
    title="Excavation Calculator - SolveKit"
    description="Free excavation calculator: bank (in-place) and loose volume of a dig, with sloped sides, swell from Caterpillar soil data, weight and truckloads."
    lede="Work out how much soil a dig removes and how many truckloads it makes."
    about="Bank volume is what you dig; it swells once loose, and the truck hauls the loose volume. Swell comes from the Caterpillar bank and loose densities for each soil (for example clay, natural bed swells 22%). Sloped sides use the prismoidal formula (rectangle) or a cone frustum (circle)."
    :calc="['engine' => 'con-bulk', 'tool' => 'excavation', 'fields' => ['shape', 'length', 'width', 'diameter', 'depth', 'slope', 'soil', 'truck'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'truck' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all()], 'data' => ['bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Enter the bottom size and depth', 'text' => 'Add a side slope if the sides are battered back.'],
        ['name' => 'Choose the soil', 'text' => 'Its swell turns bank volume into loose volume.'],
        ['name' => 'Enter a truck size', 'text' => 'To count loads.'],
    ]"
    :faqs="[
        ['question' => 'What is swell?', 'answer' => 'The increase in volume when soil is dug and loosened; 10–70% depending on the material.'],
        ['question' => 'How many yards is a basement dig?', 'answer' => 'A 30 × 40 ft dig 8 ft deep is about 356 yd³ in place.'],
        ['question' => 'Do I need sloped sides?', 'answer' => 'Trench safety rules (OSHA 1926 Subpart P) require sloping, benching or shoring for most digs over 5 ft.'],
    ]"
>
    <x-calc.select name="shape" label="Shape of the bottom" :options="['rectangle' => 'Rectangle', 'circle' => 'Circle']" selected="rectangle" />

    <div data-show-when="shape:rectangle">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Bottom length" value="30" min="0" placeholder="Bottom length">
                <label for="calc-length-unit" class="sr-only">Bottom length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Bottom width" value="20" min="0" placeholder="Bottom width">
                <label for="calc-width-unit" class="sr-only">Bottom width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="shape:circle" hidden>
        <x-calc.field name="diameter" label="Bottom diameter" value="10" min="0" placeholder="Bottom diameter">
            <label for="calc-diameter-unit" class="sr-only">Bottom diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="depth" label="Depth" value="4" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="slope" label="Side slope (horizontal per 1 vertical)" value="0" min="0" step="0.25" help="0 for vertical sides, 1 for 1 : 1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="soil" label="Soil" :options="collect(config('construction_data.bulk'))->map(fn ($b) => $b['name'])->all()" selected="earth_dry" />
        <x-calc.field name="truck" label="Truck capacity (optional)" value="12" min="0" placeholder="Truck capacity (optional)">
            <label for="calc-truck-unit" class="sr-only">Truck capacity (optional) unit</label>
            <select id="calc-truck-unit" name="truck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'yd3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Excavation volume" />

    <x-calc.options :examples="[
        'Basement 40 × 30 ft, 8 ft' => ['shape' => 'rectangle', 'length' => 40, 'width' => 30, 'length-unit' => 'ft', 'width-unit' => 'ft', 'depth' => 8, 'depth-unit' => 'ft', 'slope' => 0, 'soil' => 'earth_dry', 'truck' => 12, 'truck-unit' => 'yd3'],
        'Pond with 2 : 1 sides' => ['shape' => 'circle', 'diameter' => 6, 'diameter-unit' => 'm', 'depth' => 1.5, 'depth-unit' => 'm', 'slope' => 2, 'soil' => 'clay_natural', 'truck' => 10, 'truck-unit' => 'm3'],
        'Trench in sand' => ['shape' => 'rectangle', 'length' => 100, 'width' => 2, 'length-unit' => 'ft', 'width-unit' => 'ft', 'depth' => 3, 'depth-unit' => 'ft', 'slope' => 0, 'soil' => 'sand_dry', 'truck' => 12, 'truck-unit' => 'yd3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'loose' => ['label' => 'Loose volume'],
            'swell' => ['label' => 'Swell'],
            'weight' => ['label' => 'Weight'],
            'trucks' => ['label' => 'Truckloads'],
            'ft3' => ['label' => 'Cubic feet'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>prismoid: V = d ÷ 6 × (A_bottom + 4 A_middle + A_top)</li>
            <li>frustum: V = π d (r₁² + r₁r₂ + r₂²) ÷ 3</li>
            <li>loose = bank × (ρbank ÷ ρloose)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
