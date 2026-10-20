<x-calc.page
    title="Triathlon Nutrition Calculator - SolveKit"
    description="Free triathlon nutrition calculator: carbohydrate, fluid and sodium per hour for your race."
    lede="Plan race fuelling."
    about="Long races need carbohydrate every hour: 30–60 g for medium races and up to 90 g for long ones."
    :calc="['engine' => 'sp-run', 'tool' => 'tri_nutrition', 'fields' => ['hours', 'w', 'sweat'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'sweat' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much carbohydrate for a 5½-hour race?', 'answer' => 'None needed per hour.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Expected race time (h:mm)" value="5:30" type="text" inputmode="text" />
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sweat" label="Sweat rate" value="0.8" min="0" placeholder="Sweat rate">
            <label for="calc-sweat-unit" class="sr-only">Sweat rate unit</label>
            <select id="calc-sweat-unit" name="sweat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Carbohydrate per hour" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hours' => '5:30', 'w' => 70, 'w-unit' => 'kg', 'sweat' => 0.8, 'sweat-unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'carbTotal' => ['label' => 'Carbohydrate in total'],
            'fluid' => ['label' => 'Fluid per hour'],
            'sodium' => ['label' => 'Sodium per hour'],
            'pre' => ['label' => 'Before the race'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
