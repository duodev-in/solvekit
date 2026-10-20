<x-calc.page
    title="Calorimetry Calculator - SolveKit"
    description="Free calorimetry calculator: final temperature when two bodies mix, or an unknown specific heat."
    lede="Solve a calorimetry problem."
    about="In an insulated calorimeter the heat lost by the hot body equals the heat gained by the cold one."
    :calc="['engine' => 'ph-thermo', 'tool' => 'calorimetry', 'fields' => ['mode', 'm1', 'c1', 'T1', 'm2', 'c2', 'T2', 'Tf', 'out'], 'unitFields' => ['m1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'c1' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'c2' => collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tf' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'specific_heat', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What final temperature does 200 g of copper at 100 °C in 500 g of water at 20 °C reach?', 'answer' => '22.8413 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['tf' => 'Final temperature', 'c' => 'Unknown specific heat of body 1']" selected="tf" />
        <x-calc.field name="m1" label="Body 1 mass" value="200" min="0" placeholder="Body 1 mass">
            <label for="calc-m1-unit" class="sr-only">Body 1 mass unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:tf">
            <x-calc.field name="c1" label="Body 1 specific heat" value="385" min="0" placeholder="Body 1 specific heat">
                <label for="calc-c1-unit" class="sr-only">Body 1 specific heat unit</label>
                <select id="calc-c1-unit" name="c1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="T1" label="Body 1 temperature" value="100" placeholder="Body 1 temperature">
            <label for="calc-T1-unit" class="sr-only">Body 1 temperature unit</label>
            <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Body 2 (water) mass" value="500" min="0" placeholder="Body 2 (water) mass">
            <label for="calc-m2-unit" class="sr-only">Body 2 (water) mass unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="c2" label="Body 2 specific heat" value="4182" min="0" placeholder="Body 2 specific heat">
            <label for="calc-c2-unit" class="sr-only">Body 2 specific heat unit</label>
            <select id="calc-c2-unit" name="c2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.specific_heat'))->only(['jkgk', 'kjkgk', 'jgk', 'calgc', 'btulbf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'jkgk')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T2" label="Body 2 temperature" value="20" placeholder="Body 2 temperature">
            <label for="calc-T2-unit" class="sr-only">Body 2 temperature unit</label>
            <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:c">
            <x-calc.field name="Tf" label="Measured final temperature" value="22.9" placeholder="Measured final temperature">
                <label for="calc-Tf-unit" class="sr-only">Measured final temperature unit</label>
                <select id="calc-Tf-unit" name="Tf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Final temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'mode' => 'tf', 'm1' => 200, 'm1-unit' => 'g', 'c1' => 385, 'c1-unit' => 'jkgk', 'T1' => 100, 'T1-unit' => 'c', 'm2' => 500, 'm2-unit' => 'g', 'c2' => 4182, 'c2-unit' => 'jkgk', 'T2' => 20, 'T2-unit' => 'c', 'Tf' => 22.9, 'Tf-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Q' => ['label' => 'Heat exchanged'],
            'c1' => ['label' => 'Specific heat of body 1'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
