<x-calc.page
    title="Radiation Pressure Calculator - SolveKit"
    description="Free radiation pressure calculator: pressure and force of light on absorbing or reflecting surfaces, for solar sails."
    lede="Find radiation pressure."
    about="Light carries momentum, so it pushes on whatever absorbs or reflects it: I/c for absorption, twice that for a mirror. Sunlight at Earth gives about 9 µPa on a perfect mirror."
    :calc="['engine' => 'ph-astro', 'tool' => 'radiation_pressure', 'fields' => ['I', 'surface', 'refl', 'angle', 'A'], 'unitFields' => ['I' => collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'area', 'energy', 'force', 'intensity', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What pressure does sunlight put on a solar sail at Earth?', 'answer' => '9.07961 µPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="I" label="Intensity" value="1361" min="0" placeholder="Intensity">
            <label for="calc-I-unit" class="sr-only">Intensity unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'wm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="surface" label="Surface" :options="['absorb' => 'Absorbing (black)', 'reflect' => 'Perfectly reflecting', 'partial' => 'Partly reflecting']" selected="reflect" />
        <div data-show-when="surface:partial">
            <x-calc.field name="refl" label="Reflectivity (%)" value="90" min="0" step="any" />
        </div>
        <x-calc.field name="angle" label="Angle from the surface normal" value="0" placeholder="Angle from the surface normal">
            <label for="calc-angle-unit" class="sr-only">Angle from the surface normal unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="A" label="Area (optional)" value="100" min="0" placeholder="Area (optional)">
            <label for="calc-A-unit" class="sr-only">Area (optional) unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Radiation pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['I' => 1361, 'I-unit' => 'wm2', 'surface' => 'reflect', 'refl' => 90, 'angle' => 0, 'angle-unit' => 'deg', 'A' => 100, 'A-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'F' => ['label' => 'Force on that area'],
            'ua' => ['label' => 'Acceleration of a 1 kg sail of that area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
