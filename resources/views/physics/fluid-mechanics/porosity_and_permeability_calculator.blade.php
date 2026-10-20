<x-calc.page
    title="Porosity and Permeability Calculator - SolveKit"
    description="Free porosity and permeability calculator: porosity, void ratio and Kozeny–Carman permeability."
    lede="Find porosity and permeability."
    about="Porosity is the share of empty space. Kozeny–Carman estimates permeability from porosity and grain size for well-sorted granular material."
    :calc="['engine' => 'ph-fluid', 'tool' => 'porosity', 'fields' => ['mode', 'Vp', 'Vb', 'rb', 'rg', 'd'], 'unitFields' => ['Vp' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'Vb' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'rb' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'rg' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the porosity of the example sand?', 'answer' => '39.62%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['volumes' => 'Pore and bulk volume', 'densities' => 'Bulk and grain density']" selected="densities" />
        <div data-show-when="mode:volumes">
            <x-calc.field name="Vp" label="Pore volume" value="30" min="0" placeholder="Pore volume">
                <label for="calc-Vp-unit" class="sr-only">Pore volume unit</label>
                <select id="calc-Vp-unit" name="Vp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:volumes">
            <x-calc.field name="Vb" label="Bulk volume" value="100" min="0" placeholder="Bulk volume">
                <label for="calc-Vb-unit" class="sr-only">Bulk volume unit</label>
                <select id="calc-Vb-unit" name="Vb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:densities">
            <x-calc.field name="rb" label="Bulk (dry) density" value="1.6" min="0" placeholder="Bulk (dry) density">
                <label for="calc-rb-unit" class="sr-only">Bulk (dry) density unit</label>
                <select id="calc-rb-unit" name="rb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:densities">
            <x-calc.field name="rg" label="Grain density" value="2.65" min="0" placeholder="Grain density">
                <label for="calc-rg-unit" class="sr-only">Grain density unit</label>
                <select id="calc-rg-unit" name="rg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="d" label="Mean grain diameter (for permeability)" value="0.3" placeholder="Mean grain diameter (for permeability)">
            <label for="calc-d-unit" class="sr-only">Mean grain diameter (for permeability) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Porosity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'densities', 'Vp' => 30, 'Vp-unit' => 'ml', 'Vb' => 100, 'Vb-unit' => 'ml', 'rb' => 1.6, 'rb-unit' => 'gcm3', 'rg' => 2.65, 'rg-unit' => 'gcm3', 'd' => 0.3, 'd-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'e' => ['label' => 'Void ratio'],
            'k' => ['label' => 'Permeability (Kozeny–Carman)'],
            'darcy' => ['label' => 'In darcys'],
            'K' => ['label' => 'Hydraulic conductivity for water at 20 °C'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
