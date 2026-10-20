<x-calc.page
    title="Engine Displacement Calculator - SolveKit"
    description="Free engine displacement calculator: engine size in litres, cc and cubic inches from bore, stroke and cylinders."
    lede="Find engine displacement."
    about="Displacement is the volume swept by all pistons: π/4 × bore² × stroke × cylinders."
    :calc="['engine' => 'ph-mach', 'tool' => 'displacement_engine', 'fields' => ['bore', 'stroke', 'n', 'out'], 'unitFields' => ['bore' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'stroke' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the displacement of an 86 × 86 mm four?', 'answer' => '1.99823 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bore" label="Bore" value="86" placeholder="Bore">
            <label for="calc-bore-unit" class="sr-only">Bore unit</label>
            <select id="calc-bore-unit" name="bore-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="stroke" label="Stroke" value="86" placeholder="Stroke">
            <label for="calc-stroke-unit" class="sr-only">Stroke unit</label>
            <select id="calc-stroke-unit" name="stroke-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Cylinders" value="4" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
    </div>

    <x-calc.result label="Engine displacement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'l', 'bore' => 86, 'bore-unit' => 'mm', 'stroke' => 86, 'stroke-unit' => 'mm', 'n' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cc' => ['label' => 'In cc'],
            'cid' => ['label' => 'In cubic inches'],
            'per' => ['label' => 'Per cylinder'],
            'ratio' => ['label' => 'Bore ÷ stroke'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
