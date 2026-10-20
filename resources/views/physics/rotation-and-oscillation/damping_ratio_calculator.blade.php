<x-calc.page
    title="Damping Ratio Calculator - SolveKit"
    description="Free damping ratio calculator: ζ from mass, stiffness and damping, with natural frequency and Q."
    lede="Find the damping ratio ζ."
    about="The damping ratio compares the damping with the critical value 2√(km). Below 1 the system oscillates; at 1 it returns fastest without overshoot."
    :calc="['engine' => 'ph-mech', 'tool' => 'damping_ratio', 'fields' => ['m', 'k', 'c'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is ζ for m = 1 kg, k = 100 N/m and c = 4 N·s/m?', 'answer' => '0.2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="k" label="Spring constant" value="100" min="0" placeholder="Spring constant">
            <label for="calc-k-unit" class="sr-only">Spring constant unit</label>
            <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'npm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="c" label="Damping coefficient (N·s/m)" value="4" min="0" step="any" />
    </div>

    <x-calc.result label="Damping ratio ζ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m' => 1, 'm-unit' => 'kg', 'k' => 100, 'k-unit' => 'npm', 'c' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'type' => ['label' => 'Behaviour'],
            'wn' => ['label' => 'Natural frequency'],
            'wd' => ['label' => 'Damped frequency'],
            'q' => ['label' => 'Quality factor Q'],
            'cc' => ['label' => 'Critical damping coefficient'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
