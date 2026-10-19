<x-calc.page
    title="Chilled Drink Calculator - SolveKit"
    description="Free chilled drink calculator: about how long a can, bottle or wine takes to chill in the fridge, freezer or ice water, with a temperature curve."
    lede="Estimate how long drinks take to chill."
    about="Newton's law of cooling: the drink approaches the surrounding temperature exponentially, T(t) = T_env + (T₀ − T_env) e^(−t/τ). The time constant τ depends on the container and on how well heat leaves it: still air in a fridge or freezer is slow, ice water about ten times faster. The constants here are typical values (about 75 minutes for a can in a fridge, 6 in ice water), so treat the times as estimates."
    :calc="['engine' => 'fd-drinks', 'tool' => 'chill', 'fields' => ['container', 'method', 'start', 'target', 'ambient'], 'unitFields' => ['start' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'target' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'ambient' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Choose the drink and how you chill it', 'text' => ''],
        ['name' => 'Enter the temperatures', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long does a can take to chill in the fridge?', 'answer' => '2.99 h from 72 °F to 40 °F (an estimate).'],
        ['question' => 'And in ice water?', 'answer' => '10 min.'],
        ['question' => 'A bottle of white wine in the freezer?', 'answer' => '48 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="container" label="Drink" :options="['can' => '12 oz can', 'bottle' => '12 oz glass bottle', 'wine' => '750 ml wine bottle', 'pet' => '2 L plastic bottle']" selected="can" />
        <x-calc.select name="method" label="Chill in" :options="['fridge' => 'Refrigerator', 'freezer' => 'Freezer', 'ice' => 'Ice water']" selected="fridge" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Starting temperature" value="72" placeholder="Starting temperature">
            <label for="calc-start-unit" class="sr-only">Starting temperature unit</label>
            <select id="calc-start-unit" name="start-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Target temperature" value="40" placeholder="Target temperature">
            <label for="calc-target-unit" class="sr-only">Target temperature unit</label>
            <select id="calc-target-unit" name="target-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ambient" label="Fridge or freezer temperature" value="37" placeholder="Fridge or freezer temperature">
            <label for="calc-ambient-unit" class="sr-only">Fridge or freezer temperature unit</label>
            <select id="calc-ambient-unit" name="ambient-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Time to chill" />

    <x-calc.options :decimals="false" :examples="[
        'Can in fridge' => ['container' => 'can', 'method' => 'fridge', 'start' => 72, 'start-unit' => 'f', 'target' => 40, 'target-unit' => 'f', 'ambient' => 37, 'ambient-unit' => 'f'],
        'Can in ice water' => ['container' => 'can', 'method' => 'ice', 'start' => 72, 'start-unit' => 'f', 'target' => 40, 'target-unit' => 'f', 'ambient' => 37, 'ambient-unit' => 'f'],
        'Wine in freezer' => ['container' => 'wine', 'method' => 'freezer', 'start' => 70, 'start-unit' => 'f', 'target' => 48, 'target-unit' => 'f', 'ambient' => 0, 'ambient-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Drink temperature" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'minutes' => ['label' => 'Minutes'],
            'half' => ['label' => 'Halfway'],
            'freezer' => ['label' => 'Tip'],
            'model' => ['label' => 'Model'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t = τ ln((T₀ − T_env) ÷ (T − T_env))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
