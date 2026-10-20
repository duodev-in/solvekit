<x-calc.page
    title="Alien Civilization Calculator - SolveKit"
    description="Free alien civilization calculator: how many communicating civilisations the Drake equation gives and how far away the nearest would be."
    lede="Estimate our nearest alien neighbours."
    about="The Drake equation multiplies the rate of star formation by a chain of probabilities to estimate how many civilisations are signalling at once. Spreading them through the galactic disc gives a typical distance to the nearest one. The inputs are mostly unknown, so this is a tool for exploring assumptions."
    :calc="['engine' => 'ph-astro', 'tool' => 'alien_civilizations', 'fields' => ['preset', 'Rs', 'fp', 'ne', 'fl', 'fi', 'fc', 'L', 'Rg', 'H'], 'unitFields' => ['Rg' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'H' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'With the middle-of-the-road values, how many civilisations are there?', 'answer' => '12; Nearest about 4,810 light years away.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="preset" label="Values" :options="['custom' => 'Your own values', 'pessimistic' => 'Pessimistic', 'middle' => 'Middle of the road', 'optimistic' => 'Optimistic']" selected="middle" />
        <div data-show-when="preset:custom">
            <x-calc.field name="Rs" label="R*: new stars per year in the Milky Way" value="1.5" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fp" label="f_p: share of stars with planets" value="1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="ne" label="n_e: habitable planets per such system" value="0.4" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fl" label="f_l: share that develop life" value="0.1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fi" label="f_i: share that develop intelligence" value="0.1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fc" label="f_c: share that communicate" value="0.2" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="L" label="L: years a civilisation communicates" value="10000" min="0" step="any" />
        </div>
        <x-calc.field name="Rg" label="Galactic disc radius" value="50000" min="0" placeholder="Galactic disc radius">
            <label for="calc-Rg-unit" class="sr-only">Galactic disc radius unit</label>
            <select id="calc-Rg-unit" name="Rg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ly')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="H" label="Disc thickness" value="1000" min="0" placeholder="Disc thickness">
            <label for="calc-H-unit" class="sr-only">Disc thickness unit</label>
            <select id="calc-H-unit" name="H-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ly')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Civilisations communicating now" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['preset' => 'middle', 'Rs' => 1.5, 'fp' => 1, 'ne' => 0.4, 'fl' => 0.1, 'fi' => 0.1, 'fc' => 0.2, 'L' => 10000, 'Rg' => 50000, 'Rg-unit' => 'ly', 'H' => 1000, 'H-unit' => 'ly'],
        'Optimistic' => ['preset' => 'optimistic', 'Rs' => 1.5, 'fp' => 1, 'ne' => 0.4, 'fl' => 0.1, 'fi' => 0.1, 'fc' => 0.2, 'L' => 10000, 'Rg' => 50000, 'Rg-unit' => 'ly', 'H' => 1000, 'H-unit' => 'ly'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nearest' => ['label' => 'Typical distance to the nearest'],
            'round' => ['label' => 'Round-trip signal time to it'],
            'note' => ['label' => 'Caveat'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
