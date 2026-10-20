<x-calc.page
    title="Gold Weight Calculator - SolveKit"
    description="Free gold weight calculator: weight and pure gold content of rings, bars, wire and beads by karat."
    lede="Find the weight of a gold item."
    about="Gold weight is volume × alloy density. Lower karats contain more of lighter metals, so the same ring weighs less in 14k than in 22k. Densities are typical for yellow gold."
    :calc="['engine' => 'ph-mat', 'tool' => 'gold_weight', 'fields' => ['karat', 'shape', 'd', 'w', 't', 'L', 'V', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'volume'])->all(), 'physics' => collect(config('physics_data'))->only(['gold'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does a 4 mm × 1.5 mm 22k band of 18 mm inner diameter weigh?', 'answer' => '6.54268 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="karat" label="Gold" :options="['k24' => '24 karat (99.9%)', 'k22' => '22 karat (91.6%)', 'k18' => '18 karat (75%)', 'k14' => '14 karat (58.5%)', 'k10' => '10 karat (41.7%)', 'k9' => '9 karat (37.5%)']" selected="k22" />
        <x-calc.select name="shape" label="Shape" :options="['ring' => 'Ring band', 'bar' => 'Bar or sheet', 'wire' => 'Wire or cylinder', 'sphere' => 'Bead or sphere', 'volume' => 'Known volume']" selected="ring" />
        <div data-show-when="shape:ring,wire,sphere">
            <x-calc.field name="d" label="Inner diameter (ring) or diameter" value="18" placeholder="Inner diameter (ring) or diameter">
                <label for="calc-d-unit" class="sr-only">Inner diameter (ring) or diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:ring,bar">
            <x-calc.field name="w" label="Band width or bar width" value="4" placeholder="Band width or bar width">
                <label for="calc-w-unit" class="sr-only">Band width or bar width unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:ring,bar">
            <x-calc.field name="t" label="Thickness" value="1.5" placeholder="Thickness">
                <label for="calc-t-unit" class="sr-only">Thickness unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:bar,wire">
            <x-calc.field name="L" label="Length" value="50" placeholder="Length">
                <label for="calc-L-unit" class="sr-only">Length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:volume">
            <x-calc.field name="V" label="Volume" value="1" min="0" placeholder="Volume">
                <label for="calc-V-unit" class="sr-only">Volume unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="g" />
    </div>

    <x-calc.result label="Weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'g', 'karat' => 'k22', 'shape' => 'ring', 'd' => 18, 'd-unit' => 'mm', 'w' => 4, 'w-unit' => 'mm', 't' => 1.5, 't-unit' => 'mm', 'L' => 50, 'L-unit' => 'mm', 'V' => 1, 'V-unit' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pure' => ['label' => 'Pure gold content'],
            'troy' => ['label' => 'In troy ounces'],
            'vol' => ['label' => 'Volume'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
