<x-calc.page
    title="Sweat Rate Calculator - SolveKit"
    description="Free sweat rate calculator: fluid lost per hour from weight before and after exercise."
    lede="Find your sweat rate."
    about="Weigh yourself before and after training; add what you drank. The difference is sweat, about 1 litre per kilogram."
    :calc="['engine' => 'sp-run', 'tool' => 'sweat_rate', 'fields' => ['before', 'after', 'drank', 'urine', 't', 'out'], 'unitFields' => ['before' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'after' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'drank' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'urine' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the sweat rate in the example?', 'answer' => '1.3 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="before" label="Weight before" value="70" min="0" placeholder="Weight before">
            <label for="calc-before-unit" class="sr-only">Weight before unit</label>
            <select id="calc-before-unit" name="before-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="after" label="Weight after" value="69.2" min="0" placeholder="Weight after">
            <label for="calc-after-unit" class="sr-only">Weight after unit</label>
            <select id="calc-after-unit" name="after-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="drank" label="Fluid drunk" value="500" min="0" placeholder="Fluid drunk">
            <label for="calc-drank-unit" class="sr-only">Fluid drunk unit</label>
            <select id="calc-drank-unit" name="drank-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="urine" label="Urine passed" value="0" min="0" placeholder="Urine passed">
            <label for="calc-urine-unit" class="sr-only">Urine passed unit</label>
            <select id="calc-urine-unit" name="urine-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Exercise time" value="60" placeholder="Exercise time">
            <label for="calc-t-unit" class="sr-only">Exercise time unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
    </div>

    <x-calc.result label="Sweat rate per hour" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'l', 'before' => 70, 'before-unit' => 'kg', 'after' => 69.2, 'after-unit' => 'kg', 'drank' => 500, 'drank-unit' => 'ml', 'urine' => 0, 'urine-unit' => 'ml', 't' => 60, 't-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'loss' => ['label' => 'Body-weight loss'],
            'drink' => ['label' => 'Drink per hour to stay within 2% loss'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
