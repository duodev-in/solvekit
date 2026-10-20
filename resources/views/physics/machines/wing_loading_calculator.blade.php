<x-calc.page
    title="Wing Loading Calculator - SolveKit"
    description="Free wing loading calculator: weight per wing area and stall speed of an aircraft."
    lede="Find wing loading and stall speed."
    about="Wing loading is weight divided by wing area. Higher loading means a faster stall speed and a smoother ride in turbulence."
    :calc="['engine' => 'ph-mach', 'tool' => 'wing_loading', 'fields' => ['m', 'S', 'cl'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'S' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the wing loading of a 1,100 kg aircraft with 16.2 m² of wing?', 'answer' => '67.901 kg/m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Aircraft mass" value="1100" min="0" placeholder="Aircraft mass">
            <label for="calc-m-unit" class="sr-only">Aircraft mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="S" label="Wing area" value="16.2" min="0" placeholder="Wing area">
            <label for="calc-S-unit" class="sr-only">Wing area unit</label>
            <select id="calc-S-unit" name="S-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cl" label="Maximum lift coefficient (for stall speed)" value="1.6" min="0" step="any" />
    </div>

    <x-calc.result label="Wing loading" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m' => 1100, 'm-unit' => 'kg', 'S' => 16.2, 'S-unit' => 'm2', 'cl' => 1.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'si' => ['label' => 'In N/m²'],
            'imp' => ['label' => 'In lb/ft²'],
            'stall' => ['label' => 'Stall speed at sea level'],
            'compare' => ['label' => 'For comparison'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
