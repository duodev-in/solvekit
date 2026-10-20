<x-calc.page
    title="Moisture Content Calculator - SolveKit"
    description="Free moisture content calculator: dry-basis and wet-basis moisture from wet and dry mass."
    lede="Find moisture content."
    about="Soil and timber use dry-basis moisture (water over dry mass); food and grain use wet basis (water over wet mass)."
    :calc="['engine' => 'ph-fluid', 'tool' => 'moisture_content', 'fields' => ['wet', 'dry'], 'unitFields' => ['wet' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'dry' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the moisture of 120 g wet, 100 g dry?', 'answer' => '20%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wet" label="Wet mass" value="120" min="0" placeholder="Wet mass">
            <label for="calc-wet-unit" class="sr-only">Wet mass unit</label>
            <select id="calc-wet-unit" name="wet-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dry" label="Oven-dry mass" value="100" min="0" placeholder="Oven-dry mass">
            <label for="calc-dry-unit" class="sr-only">Oven-dry mass unit</label>
            <select id="calc-dry-unit" name="dry-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Moisture content (dry basis)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['wet' => 120, 'wet-unit' => 'g', 'dry' => 100, 'dry-unit' => 'g'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wetb' => ['label' => 'Wet basis'],
            'water' => ['label' => 'Water mass'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
