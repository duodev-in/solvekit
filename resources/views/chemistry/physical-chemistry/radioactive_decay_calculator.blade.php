<x-calc.page
    title="Radioactive Decay Calculator - SolveKit"
    description="Free radioactive decay calculator: amount and activity left after a time for common isotopes using NUBASE2020 half-lives."
    lede="Work out how much of a radioactive isotope remains, and its activity."
    about="Radioactive decay is first order: N = N₀ e^(−λt) with λ = ln 2 ÷ t½. Half-lives for 24 common isotopes are from NUBASE2020, the IAEA-endorsed evaluation (1 year = 365.2422 days). Activity in becquerels is λ times the number of atoms."
    :calc="['engine' => 'chem-physical', 'tool' => 'radioactive_decay', 'fields' => ['isotope', 'half_life', 'initial', 'amount_unit', 'time'], 'unitFields' => ['half_life' => collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year'])->all(), 'time' => collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year'])->all()], 'data' => ['isotopes' => config('chemistry_data.isotopes')]]"
    :how-to="[
        ['name' => 'Pick the isotope', 'text' => 'Or enter a half-life.'],
        ['name' => 'Enter the amount and time', 'text' => 'Grams give the activity too.'],
    ]"
    :faqs="[
        ['question' => 'How long is the half-life of carbon-14?', 'answer' => '5,700 years (NUBASE2020).'],
        ['question' => 'What is a becquerel?', 'answer' => 'One decay per second; a curie is 3.7 × 10¹⁰ Bq.'],
        ['question' => 'Why does iodine-131 matter after accidents?', 'answer' => 'Its 8-day half-life makes it very active in the first weeks.'],
    ]"
>
    <x-calc.select name="isotope" label="Isotope" :options="collect(config('chemistry_data.isotopes'))->map(fn ($i) => $i['name'].' (t½ '.$i['shown'].')')->put('custom', 'Custom half-life')->all()" selected="carbon_14" />

    <div data-show-when="isotope:custom" hidden>
        <x-calc.field name="half_life" label="Half-life" value="8" min="0" placeholder="Half-life">
            <label for="calc-half_life-unit" class="sr-only">Half-life unit</label>
            <select id="calc-half_life-unit" name="half_life-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="initial" label="Initial amount" value="1" min="0" />
        <x-calc.segmented name="amount_unit" legend="Amount in" :options="['g' => 'grams', 'bq' => 'Bq', 'percent' => '%', 'atoms' => 'atoms']" selected="g" />
    </div>

    <x-calc.field name="time" label="Time elapsed" value="1000" min="0" placeholder="Time elapsed">
        <label for="calc-time-unit" class="sr-only">Time elapsed unit</label>
        <select id="calc-time-unit" name="time-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Amount remaining" />

    <x-calc.options :examples="[
        '1 g carbon-14, 1,000 years' => ['isotope' => 'carbon_14', 'initial' => 1, 'amount_unit' => 'g', 'time' => 1000, 'time-unit' => 'year'],
        'Iodine-131 after 30 days' => ['isotope' => 'iodine_131', 'initial' => 100, 'amount_unit' => 'percent', 'time' => 30, 'time-unit' => 'day'],
        'Technetium-99m after a day' => ['isotope' => 'technetium_99m', 'initial' => 1000000000, 'amount_unit' => 'bq', 'time' => 24, 'time-unit' => 'h'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fraction' => ['label' => 'Remaining'],
            'lambda' => ['label' => 'Decay constant'],
            'half' => ['label' => 'Half-life'],
            'activity' => ['label' => 'Activity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = N₀ e^(−λt)</li>
            <li>λ = ln 2 ÷ t½</li>
            <li>A = λN</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
