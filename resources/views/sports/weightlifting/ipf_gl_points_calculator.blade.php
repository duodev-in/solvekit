<x-calc.page
    title="IPF GL Points Calculator - SolveKit"
    description="Free IPF GL points calculator: International Powerlifting Federation Goodlift points."
    lede="Find your IPF GL points."
    about="The IPF ranks lifters across classes with the Goodlift (GL) formula for each event and sex."
    :calc="['engine' => 'sp-misc', 'tool' => 'ipf_gl', 'fields' => ['sex', 'event', 'bw', 'total'], 'unitFields' => ['bw' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'total' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['strength'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What GL points is a 600 kg classic total at 90 kg?', 'answer' => '79.765.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="event" label="Event" :options="['classic_powerlifting' => 'Classic (raw) powerlifting', 'equipped_powerlifting' => 'Equipped powerlifting', 'classic_bench' => 'Classic bench press', 'equipped_bench' => 'Equipped bench press']" selected="classic_powerlifting" />
        <x-calc.field name="bw" label="Body weight" value="90" min="0" placeholder="Body weight">
            <label for="calc-bw-unit" class="sr-only">Body weight unit</label>
            <select id="calc-bw-unit" name="bw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="total" label="Total (or bench result)" value="600" min="0" placeholder="Total (or bench result)">
            <label for="calc-total-unit" class="sr-only">Total (or bench result) unit</label>
            <select id="calc-total-unit" name="total-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="IPF GL points" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sex' => 'male', 'event' => 'classic_powerlifting', 'bw' => 90, 'bw-unit' => 'kg', 'total' => 600, 'total-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'coef' => ['label' => 'Coefficient'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
