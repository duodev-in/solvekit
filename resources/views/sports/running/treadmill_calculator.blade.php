<x-calc.page
    title="Treadmill Calculator - SolveKit"
    description="Free treadmill calculator: equivalent flat pace and calories for treadmill speed and incline."
    lede="Convert treadmill effort."
    about="Incline raises the effort of a treadmill run. The ACSM equation finds the flat pace with the same oxygen cost."
    :calc="['engine' => 'sp-run', 'tool' => 'treadmill', 'fields' => ['v', 'incline', 'w'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flat pace matches 10 km/h at 2%?', 'answer' => '5:30 /km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Treadmill speed" value="10" placeholder="Treadmill speed">
            <label for="calc-v-unit" class="sr-only">Treadmill speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="incline" label="Incline (%)" value="2" min="0" step="any" />
        <x-calc.field name="w" label="Body weight (for calories)" value="70" min="0" placeholder="Body weight (for calories)">
            <label for="calc-w-unit" class="sr-only">Body weight (for calories) unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Equivalent flat pace" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['v' => 10, 'v-unit' => 'kmh', 'incline' => 2, 'w' => 70, 'w-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tread' => ['label' => 'Treadmill pace'],
            'vo2' => ['label' => 'Oxygen use'],
            'kcal' => ['label' => 'Calories per hour'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
