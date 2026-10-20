<x-calc.page
    title="Walking Calorie Calculator - SolveKit"
    description="Free walking calorie calculator: calories from distance, speed, incline and load (ACSM equation)."
    lede="Find calories burned walking."
    about="The ACSM walking equation estimates oxygen use from speed and incline; carrying a load adds to the mass moved."
    :calc="['engine' => 'sp-fit', 'tool' => 'walking_cal', 'fields' => ['w', 'load', 'd', 'v', 'grade'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'load' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 5 km walk burn for 70 kg?', 'answer' => 'About 248.5 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="load" label="Carried load" value="0" min="0" placeholder="Carried load">
            <label for="calc-load-unit" class="sr-only">Carried load unit</label>
            <select id="calc-load-unit" name="load-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance" value="5" placeholder="Distance">
            <label for="calc-d-unit" class="sr-only">Distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed" value="5" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="grade" label="Incline (%)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 70, 'w-unit' => 'kg', 'load' => 0, 'load-unit' => 'kg', 'd' => 5, 'd-unit' => 'km', 'v' => 5, 'v-unit' => 'kmh', 'grade' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perKm' => ['label' => 'Per km'],
            'time' => ['label' => 'Walking time'],
            'vo2' => ['label' => 'Oxygen use'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
