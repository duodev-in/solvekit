<x-calc.page
    title="Rotational Kinetic Energy Calculator - SolveKit"
    description="Free rotational kinetic energy calculator: E = ½Iω² for energy, inertia or speed."
    lede="Solve E = ½Iω²."
    about="A spinning body has kinetic energy ½Iω², just as a moving one has ½mv²."
    :calc="['engine' => 'ph-mech', 'tool' => 'rot_ke', 'fields' => ['solve', 'E', 'I', 'w', 'out_E', 'out_I', 'out_w'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'I' => collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2'])->all(), 'w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'angular_momentum', 'angular_speed', 'energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What energy has I = 0.2 kg·m² at 1,000 rpm?', 'answer' => '1,096.62 J.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Rotational kinetic energy', 'I' => 'Moment of inertia', 'w' => 'Angular velocity']" selected="E" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I,w" hidden>
            <x-calc.field name="E" label="Rotational kinetic energy" value="1096.6" placeholder="Rotational kinetic energy">
                <label for="calc-E-unit" class="sr-only">Rotational kinetic energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,w">
            <x-calc.field name="I" label="Moment of inertia" value="0.2" min="0" placeholder="Moment of inertia">
                <label for="calc-I-unit" class="sr-only">Moment of inertia unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,I">
            <x-calc.field name="w" label="Angular velocity" value="1000" placeholder="Angular velocity">
                <label for="calc-w-unit" class="sr-only">Angular velocity unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['kgm2' => 'kg·m²', 'gcm2' => 'g·cm²', 'kgcm2' => 'kg·cm²', 'lbft2' => 'lb·ft²', 'lbin2' => 'lb·in²']" selected="kgm2" />
        </div>
        <div data-show-when="solve:w" hidden>
            <x-calc.select name="out_w" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rpm" />
        </div>
    </div>

    <x-calc.result label="Rotational kinetic energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'E', 'E' => 1096.6, 'E-unit' => 'j', 'out_E' => 'j', 'I' => 0.2, 'I-unit' => 'kgm2', 'out_I' => 'kgm2', 'w' => 1000, 'w-unit' => 'rpm', 'out_w' => 'rpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'L' => ['label' => 'Angular momentum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = ½ I ω²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
