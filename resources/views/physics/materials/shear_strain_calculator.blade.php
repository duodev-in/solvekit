<x-calc.page
    title="Shear Strain Calculator - SolveKit"
    description="Free shear strain calculator: γ from sideways displacement and height, or from shear stress and modulus."
    lede="Find shear strain."
    about="Shear strain is the change in angle of an originally square element: the sideways displacement divided by the height for small angles."
    :calc="['engine' => 'ph-mat', 'tool' => 'shear_strain', 'fields' => ['mode', 'dx', 'h', 'tau', 'G'], 'unitFields' => ['dx' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'tau' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'G' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is γ for 0.5 mm over 100 mm?', 'answer' => '0.005 rad.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['disp' => 'Sideways displacement and height', 'stress' => 'Shear stress and shear modulus']" selected="disp" />
        <div data-show-when="mode:disp">
            <x-calc.field name="dx" label="Sideways displacement" value="0.5" placeholder="Sideways displacement">
                <label for="calc-dx-unit" class="sr-only">Sideways displacement unit</label>
                <select id="calc-dx-unit" name="dx-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:disp">
            <x-calc.field name="h" label="Height" value="100" placeholder="Height">
                <label for="calc-h-unit" class="sr-only">Height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:stress">
            <x-calc.field name="tau" label="Shear stress" value="50" min="0" placeholder="Shear stress">
                <label for="calc-tau-unit" class="sr-only">Shear stress unit</label>
                <select id="calc-tau-unit" name="tau-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:stress">
            <x-calc.field name="G" label="Shear modulus" value="79.3" min="0" placeholder="Shear modulus">
                <label for="calc-G-unit" class="sr-only">Shear modulus unit</label>
                <select id="calc-G-unit" name="G-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Shear strain γ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'disp', 'dx' => 0.5, 'dx-unit' => 'mm', 'h' => 100, 'h-unit' => 'mm', 'tau' => 50, 'tau-unit' => 'mpa', 'G' => 79.3, 'G-unit' => 'gpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'deg' => ['label' => 'Angle of distortion'],
            'micro' => ['label' => 'In microstrain'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
