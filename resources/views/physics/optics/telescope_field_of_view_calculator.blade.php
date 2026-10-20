<x-calc.page
    title="Telescope Field of View Calculator - SolveKit"
    description="Free telescope field of view calculator: true field from the eyepiece apparent field or field stop."
    lede="Find a telescope’s true field."
    about="The true field of view is the eyepiece’s apparent field divided by the magnification, or more exactly the field stop diameter divided by the telescope focal length."
    :calc="['engine' => 'ph-wave', 'tool' => 'telescope_fov', 'fields' => ['mode', 'F', 'f', 'afov', 'stop', 'out'], 'unitFields' => ['F' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'afov' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'stop' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 25 mm, 52° eyepiece show on a 1,000 mm telescope?', 'answer' => '1.3 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Method" :options="['afov' => 'Eyepiece apparent field', 'stop' => 'Eyepiece field stop']" selected="afov" />
        <x-calc.field name="F" label="Telescope focal length" value="1000" placeholder="Telescope focal length">
            <label for="calc-F-unit" class="sr-only">Telescope focal length unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:afov">
            <x-calc.field name="f" label="Eyepiece focal length" value="25" placeholder="Eyepiece focal length">
                <label for="calc-f-unit" class="sr-only">Eyepiece focal length unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:afov">
            <x-calc.field name="afov" label="Apparent field of view" value="52" placeholder="Apparent field of view">
                <label for="calc-afov-unit" class="sr-only">Apparent field of view unit</label>
                <select id="calc-afov-unit" name="afov-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:stop">
            <x-calc.field name="stop" label="Field stop diameter" value="21" placeholder="Field stop diameter">
                <label for="calc-stop-unit" class="sr-only">Field stop diameter unit</label>
                <select id="calc-stop-unit" name="stop-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="True field of view" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'mode' => 'afov', 'F' => 1000, 'F-unit' => 'mm', 'f' => 25, 'f-unit' => 'mm', 'afov' => 52, 'afov-unit' => 'deg', 'stop' => 21, 'stop-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'arcmin' => ['label' => 'In arcminutes'],
            'moons' => ['label' => 'Full Moons across (0.52° each)'],
            'M' => ['label' => 'Magnification'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
