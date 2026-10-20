<x-calc.page
    title="Luminosity Calculator - SolveKit"
    description="Free stellar luminosity calculator: luminosity from radius and temperature, or from flux and distance."
    lede="Find a star’s luminosity."
    about="A star’s power output is its surface area times σT⁴. Alternatively, the flux measured at distance d spreads over a sphere of area 4πd²."
    :calc="['engine' => 'ph-astro', 'tool' => 'luminosity', 'fields' => ['mode', 'Rs', 'T', 'F', 'd', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'F' => collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2'])->all(), 'd' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'intensity', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Sun’s luminosity from its radius and temperature?', 'answer' => '3.82799 × 10²⁶ W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['rt' => 'Radius and temperature', 'flux' => 'Flux and distance']" selected="rt" />
        <div data-show-when="mode:rt">
            <x-calc.field name="Rs" label="Radius (in solar radii)" value="1" min="0" step="any" />
        </div>
        <div data-show-when="mode:rt">
            <x-calc.field name="T" label="Surface temperature" value="5772" placeholder="Surface temperature">
                <label for="calc-T-unit" class="sr-only">Surface temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:flux">
            <x-calc.field name="F" label="Measured flux" value="1361" min="0" placeholder="Measured flux">
                <label for="calc-F-unit" class="sr-only">Measured flux unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:flux">
            <x-calc.field name="d" label="Distance" value="1" min="0" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'au')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
    </div>

    <x-calc.result label="Luminosity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'w', 'mode' => 'rt', 'Rs' => 1, 'T' => 5772, 'T-unit' => 'k', 'F' => 1361, 'F-unit' => 'wm2', 'd' => 1, 'd-unit' => 'au'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sun' => ['label' => 'In solar luminosities'],
            'mag' => ['label' => 'Absolute bolometric magnitude'],
            'peak' => ['label' => 'Peak wavelength'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
