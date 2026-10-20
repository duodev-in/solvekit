<x-calc.page
    title="Newton's Third Law Calculator - SolveKit"
    description="Free Newton's third law calculator: equal and opposite forces and the acceleration each body gets."
    lede="Find the reaction on the other body."
    about="For every action there is an equal and opposite reaction: when A pushes B, B pushes A just as hard. The lighter body accelerates more because a = F ÷ m."
    :calc="['engine' => 'ph-mech', 'tool' => 'newton3', 'fields' => ['m1', 'a1', 'm2', 'out'], 'unitFields' => ['m1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'a1' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'A 70 kg skater pushes a 35 kg one and accelerates at 0.5 m/s². What about the other?', 'answer' => '1 m/s², in the opposite direction.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="Mass of body A" value="70" min="0" placeholder="Mass of body A">
            <label for="calc-m1-unit" class="sr-only">Mass of body A unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a1" label="Acceleration of A" value="0.5" placeholder="Acceleration of A">
            <label for="calc-a1-unit" class="sr-only">Acceleration of A unit</label>
            <select id="calc-a1-unit" name="a1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Mass of body B" value="35" min="0" placeholder="Mass of body B">
            <label for="calc-m2-unit" class="sr-only">Mass of body B unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Acceleration of B" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'm1' => 70, 'm1-unit' => 'kg', 'a1' => 0.5, 'a1-unit' => 'ms2', 'm2' => 35, 'm2-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'F' => ['label' => 'Force on each (equal and opposite)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
