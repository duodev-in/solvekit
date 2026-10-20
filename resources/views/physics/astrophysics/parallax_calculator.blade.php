<x-calc.page
    title="Parallax Calculator - SolveKit"
    description="Free parallax calculator: star distance in parsecs and light years from parallax angle, or the reverse."
    lede="Solve d = 1/p."
    about="As Earth orbits the Sun, nearby stars shift against distant ones. A parallax of one arcsecond means a distance of one parsec (3.26 light years)."
    :calc="['engine' => 'ph-astro', 'tool' => 'parallax', 'fields' => ['solve', 'd', 'p', 'out_d', 'out_p'], 'unitFields' => ['d' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'p' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'astronomical', 'd', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How far is Alpha Centauri at 0.768″?', 'answer' => '1.30197 pc.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['d' => 'Distance', 'p' => 'Parallax angle']" selected="d" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:p" hidden>
            <x-calc.field name="d" label="Distance" value="1.30197" min="0" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'pc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:d">
            <x-calc.field name="p" label="Parallax angle" value="0.768067" placeholder="Parallax angle">
                <label for="calc-p-unit" class="sr-only">Parallax angle unit</label>
                <select id="calc-p-unit" name="p-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'arcsec')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:d">
            <x-calc.select name="out_d" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="pc" />
        </div>
        <div data-show-when="solve:p" hidden>
            <x-calc.select name="out_p" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="arcsec" />
        </div>
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'd', 'd' => 1.30197, 'd-unit' => 'pc', 'out_d' => 'pc', 'p' => 0.768067, 'p-unit' => 'arcsec', 'out_p' => 'arcsec'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ly' => ['label' => 'In light years'],
            'mas' => ['label' => 'Parallax in milliarcseconds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = 1 ÷ p (parsecs and arcseconds)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
