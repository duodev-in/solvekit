<x-calc.page
    title="Time Of Death Calculator - SolveKit"
    description="Free time of death calculator: estimate time since death from body cooling with the Henssge nomogram equation (educational)."
    lede="Estimate time since death from body temperature."
    about="After death the body cools in a sigmoid curve. Henssge (1988): (T_rectal − T_ambient) ÷ (37.2 − T_ambient) = 1.25 e^(B t) − 0.25 e^(5 B t), with B = −1.2815 × mass^−0.625 + 0.0284, for surroundings up to 23 °C. Clothing is allowed for with a correction factor on body mass. The 95% range is about ± 2.8 hours. For education only. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'time_of_death', 'fields' => ['rectal', 'ambient', 'weight', 'clothing'], 'unitFields' => ['rectal' => collect(config('units.temperature'))->only(['c', 'f'])->all(), 'ambient' => collect(config('units.temperature'))->only(['c', 'f'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the temperatures', 'text' => ''],
        ['name' => 'Enter body weight and clothing', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long since death for a 70 kg body at 30 °C in a room at 18 °C?', 'answer' => '12.0 h (95% range about 7.5–16.5 h (Henssge nomogram)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rectal" label="Rectal temperature" value="30" placeholder="Rectal temperature">
            <label for="calc-rectal-unit" class="sr-only">Rectal temperature unit</label>
            <select id="calc-rectal-unit" name="rectal-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ambient" label="Surroundings" value="18" placeholder="Surroundings">
            <label for="calc-ambient-unit" class="sr-only">Surroundings unit</label>
            <select id="calc-ambient-unit" name="ambient-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="clothing" label="Clothing and cover" :options="['1' => 'Naked, still air (factor 1.0)', '1.1' => 'Thin clothing (1.1)', '1.2' => 'Light clothing (1.2)', '1.4' => 'Thick clothing or covered (1.4)']" selected="1.1" />

    <x-calc.result label="Estimated time since death" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rectal' => 30, 'rectal-unit' => 'c', 'ambient' => 18, 'ambient-unit' => 'c', 'weight' => 70, 'weight-unit' => 'kg', 'clothing' => '1.1'],
        'Cool room' => ['rectal' => 25, 'rectal-unit' => 'c', 'ambient' => 10, 'ambient-unit' => 'c', 'weight' => 80, 'weight-unit' => 'kg', 'clothing' => '1.4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'q' => ['label' => 'Cooling ratio'],
            'mass' => ['label' => 'Corrected mass'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = 1.25 e^(Bt) − 0.25 e^(5Bt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
