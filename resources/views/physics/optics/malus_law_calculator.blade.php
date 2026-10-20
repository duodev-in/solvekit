<x-calc.page
    title="Malus Law Calculator - SolveKit"
    description="Free Malus's law calculator: intensity through a polariser, I = I₀cos²θ, solved for any value."
    lede="Solve I = I₀ cos²θ."
    about="Polarised light passing through a polariser at angle θ keeps a fraction cos²θ of its intensity. At 90° nothing passes."
    :calc="['engine' => 'ph-wave', 'tool' => 'malus', 'fields' => ['solve', 'I', 'I0', 'theta', 'out_I', 'out_I0', 'out_theta'], 'unitFields' => ['I' => collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2'])->all(), 'I0' => collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2'])->all(), 'theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'intensity', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much light passes at 30°?', 'answer' => '75 W/m² of 100 W/m².'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['I' => 'Transmitted intensity', 'I0' => 'Incident (polarised) intensity', 'theta' => 'Angle between polariser axes']" selected="I" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I0,theta" hidden>
            <x-calc.field name="I" label="Transmitted intensity" value="75" min="0" placeholder="Transmitted intensity">
                <label for="calc-I-unit" class="sr-only">Transmitted intensity unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:I,theta">
            <x-calc.field name="I0" label="Incident (polarised) intensity" value="100" min="0" placeholder="Incident (polarised) intensity">
                <label for="calc-I0-unit" class="sr-only">Incident (polarised) intensity unit</label>
                <select id="calc-I0-unit" name="I0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.intensity'))->only(['wm2', 'kwm2', 'mwcm2', 'wcm2', 'btuhft2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:I,I0">
            <x-calc.field name="theta" label="Angle between polariser axes" value="30" placeholder="Angle between polariser axes">
                <label for="calc-theta-unit" class="sr-only">Angle between polariser axes unit</label>
                <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:I">
            <x-calc.select name="out_I" label="Show the result in" :options="['wm2' => 'W/m²', 'kwm2' => 'kW/m²', 'mwcm2' => 'mW/cm²', 'wcm2' => 'W/cm²', 'btuhft2' => 'BTU/(h·ft²)']" selected="wm2" />
        </div>
        <div data-show-when="solve:I0" hidden>
            <x-calc.select name="out_I0" label="Show the result in" :options="['wm2' => 'W/m²', 'kwm2' => 'kW/m²', 'mwcm2' => 'mW/cm²', 'wcm2' => 'W/cm²', 'btuhft2' => 'BTU/(h·ft²)']" selected="wm2" />
        </div>
        <div data-show-when="solve:theta" hidden>
            <x-calc.select name="out_theta" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Transmitted intensity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'I', 'I' => 75, 'I-unit' => 'wm2', 'out_I' => 'wm2', 'I0' => 100, 'I0-unit' => 'wm2', 'out_I0' => 'wm2', 'theta' => 30, 'theta-unit' => 'deg', 'out_theta' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'share' => ['label' => 'Transmitted share'],
            'unpol' => ['label' => 'If the incident light were unpolarised'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>I = I₀ cos² θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
