<x-calc.page
    title="kg to Newtons Calculator - SolveKit"
    description="Free kg to newtons calculator: the weight of a mass in newtons on Earth, the Moon, Mars or any gravity."
    lede="Convert a mass to its weight in newtons."
    about="Kilograms measure mass; newtons measure force. Weight is mass times gravity: 1 kg weighs 9.80665 N in standard Earth gravity, 1.62 N on the Moon."
    :calc="['engine' => 'ph-mech', 'tool' => 'kg_newtons', 'fields' => ['m', 'body', 'g', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many newtons is 1 kg?', 'answer' => '9.80665 N in standard gravity.'],
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
        <x-calc.select name="body" label="Gravity of" :options="['standard' => 'Earth (standard g₀ = 9.80665 m/s²)', 'moon' => 'Moon', 'mars' => 'Mars', 'jupiter' => 'Jupiter', 'custom' => 'Custom']" selected="standard" />
        <div data-show-when="body:custom">
            <x-calc.field name="g" label="Custom gravity" value="9.81" placeholder="Custom gravity">
                <label for="calc-g-unit" class="sr-only">Custom gravity unit</label>
                <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'm' => 1, 'm-unit' => 'kg', 'body' => 'standard', 'g' => 9.81, 'g-unit' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lbf' => ['label' => 'In pound-force'],
            'kgf' => ['label' => 'In kilogram-force'],
            'g' => ['label' => 'Gravity used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
