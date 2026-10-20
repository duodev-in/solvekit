<x-calc.page
    title="Blackbody Radiation Calculator - SolveKit"
    description="Free blackbody radiation calculator: peak wavelength, radiant exitance and the Planck spectrum for any temperature."
    lede="Find the spectrum of a hot body."
    about="An ideal blackbody emits a spectrum set only by its temperature. Wien’s law gives the peak wavelength b/T, the Stefan–Boltzmann law gives the total power σT⁴ per square metre, and Planck’s law gives the full curve. The Sun’s surface (5,772 K) peaks near 500 nm."
    :calc="['engine' => 'ph-wave', 'tool' => 'blackbody', 'fields' => ['T', 'eps', 'area', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'area' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'intensity', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Where does the Sun’s spectrum peak?', 'answer' => 'At 502.039 nm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Temperature" value="5772" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eps" label="Emissivity" value="1" min="0" step="any" />
        <x-calc.field name="area" label="Surface area (optional, for total power)" value="1" min="0" placeholder="Surface area (optional, for total power)">
            <label for="calc-area-unit" class="sr-only">Surface area (optional, for total power) unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Peak wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'T' => 5772, 'T-unit' => 'k', 'eps' => 1, 'area' => 1, 'area-unit' => 'm2'],
        'Incandescent bulb' => ['out' => 'nm', 'T' => 2700, 'T-unit' => 'k', 'eps' => 1, 'area' => 1, 'area-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Spectral exitance (Planck’s law)" name="spectrum" />
        <x-calc.rows heading="Details" :rows="[
            'M' => ['label' => 'Radiant exitance σεT⁴'],
            'P' => ['label' => 'Total power from that area'],
            'fpeak' => ['label' => 'Peak frequency'],
            'visible' => ['label' => 'Share emitted as visible light (380–750 nm)'],
            'color' => ['label' => 'Appearance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
