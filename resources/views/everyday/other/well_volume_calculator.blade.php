<x-calc.page
    title="Well Volume Calculator - SolveKit"
    description="Free well volume calculator: gallons or liters of water stored in a water well from its casing diameter, depth and static water level."
    lede="Work out how much water is stored in your well."
    about="Stored water = π × (casing diameter ÷ 2)² × water column, where the water column is the well depth minus the depth to the static water level. A 6-inch casing holds about 1.47 gallons per foot. This is stored water only; how much the well can deliver also depends on how fast it refills."
    :calc="['engine' => 'ev-care', 'tool' => 'well', 'fields' => ['diameter', 'depth', 'static'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'static' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the casing and depth', 'text' => 'From the well log.'],
        ['name' => 'Enter the static water level', 'text' => 'Depth to water when not pumping.'],
    ]"
    :faqs="[
        ['question' => 'How much water is in a 6-inch well?', 'answer' => 'About 1.47 gallons per foot of water.'],
        ['question' => 'What is static water level?', 'answer' => 'The depth to water when the pump has been off.'],
        ['question' => 'How much in a 200 ft well with water at 80 ft?', 'answer' => 'About 176 gallons in a 6-inch casing.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="diameter" label="Casing diameter" value="6" min="0" placeholder="Casing diameter">
            <label for="calc-diameter-unit" class="sr-only">Casing diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Well depth" value="200" min="0" placeholder="Well depth">
            <label for="calc-depth-unit" class="sr-only">Well depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="static" label="Depth to water" value="80" min="0" placeholder="Depth to water">
            <label for="calc-static-unit" class="sr-only">Depth to water unit</label>
            <select id="calc-static-unit" name="static-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Water stored in the well" />

    <x-calc.options :examples="[
        '6 in, 200 ft, water at 80 ft' => ['diameter' => 6, 'diameter-unit' => 'in', 'depth' => 200, 'depth-unit' => 'ft', 'static' => 80, 'static-unit' => 'ft'],
        '4 in, 150 ft' => ['diameter' => 4, 'diameter-unit' => 'in', 'depth' => 150, 'depth-unit' => 'ft', 'static' => 40, 'static-unit' => 'ft'],
        'Metric 15 cm, 60 m' => ['diameter' => 15, 'diameter-unit' => 'cm', 'depth' => 60, 'depth-unit' => 'm', 'static' => 20, 'static-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'In liters'],
            'perFoot' => ['label' => 'Per foot'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π r² × (depth − water level)</li>
            <li>gal per ft ≈ 0.0408 × d² (d in inches)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
