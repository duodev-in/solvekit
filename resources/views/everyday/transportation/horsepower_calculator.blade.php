<x-calc.page
    title="Horsepower Calculator - SolveKit"
    description="Free horsepower calculator: horsepower from torque and RPM, or estimated from a quarter-mile elapsed time or trap speed and vehicle weight."
    lede="Work out horsepower from torque and RPM, or from a drag strip run."
    about="Power = torque × angular speed: hp = lb-ft × rpm ÷ 5,252, which is why torque and horsepower curves cross at 5,252 rpm. From a quarter-mile run, the Hale formulas estimate power from weight with driver: hp = weight × (5.825 ÷ ET)³ or hp = weight × (trap mph ÷ 234)³. Trap speed is usually the better guide because launch and traction affect elapsed time more."
    :calc="['engine' => 'ev-transport', 'tool' => 'horsepower', 'fields' => ['mode', 'torque', 'rpm', 'weight', 'et', 'trap'], 'unitFields' => ['torque' => collect(config('units.torque'))->only(['lbfft', 'nm'])->all(), 'weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'trap' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Torque and RPM, or a drag strip run.'],
        ['name' => 'Enter the values', 'text' => 'Weight includes the driver.'],
    ]"
    :faqs="[
        ['question' => 'What is 400 lb-ft at 5,252 rpm?', 'answer' => 'About 400 hp; torque and horsepower are equal at 5,252 rpm.'],
        ['question' => 'How much power runs a 12.5 s quarter mile?', 'answer' => 'About 364 hp for a 3,600 lb car.'],
        ['question' => 'Why 5,252?', 'answer' => '33,000 ft·lb/min per hp ÷ 2π.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['torque' => 'Torque and RPM', 'et' => '¼-mile time', 'trap' => '¼-mile trap speed']" selected="torque" />

    <div data-show-when="mode:torque">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="torque" label="Torque" value="400" min="0" placeholder="Torque">
                <label for="calc-torque-unit" class="sr-only">Torque unit</label>
                <select id="calc-torque-unit" name="torque-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.torque'))->only(['lbfft', 'nm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'lbfft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="rpm" label="Engine speed" value="5252" min="1" step="1" suffix="rpm" />
        </div>
    </div>

    <div data-show-when="mode:et,trap" hidden>
        <x-calc.field name="weight" label="Weight with driver" value="3600" min="0" placeholder="Weight with driver">
            <label for="calc-weight-unit" class="sr-only">Weight with driver unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:et" hidden>
        <x-calc.field name="et" label="Elapsed time" value="12.5" min="4" step="0.01" suffix="s" />
    </div>

    <div data-show-when="mode:trap" hidden>
        <x-calc.field name="trap" label="Trap speed" value="112" min="0" placeholder="Trap speed">
            <label for="calc-trap-unit" class="sr-only">Trap speed unit</label>
            <select id="calc-trap-unit" name="trap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Horsepower" />

    <x-calc.options :examples="[
        '400 lb-ft at 5,252 rpm' => ['mode' => 'torque', 'torque' => 400, 'torque-unit' => 'lbfft', 'rpm' => 5252, 'weight' => '', 'weight-unit' => 'lb', 'et' => '', 'trap' => '', 'trap-unit' => 'mph'],
        '350 N·m at 6,000 rpm' => ['mode' => 'torque', 'torque' => 350, 'torque-unit' => 'nm', 'rpm' => 6000, 'weight' => '', 'weight-unit' => 'lb', 'et' => '', 'trap' => '', 'trap-unit' => 'mph'],
        '12.5 s, 3,600 lb' => ['mode' => 'et', 'torque' => '', 'torque-unit' => 'lbfft', 'rpm' => '', 'weight' => 3600, 'weight-unit' => 'lb', 'et' => 12.5, 'trap' => '', 'trap-unit' => 'mph'],
        '112 mph trap' => ['mode' => 'trap', 'torque' => '', 'torque-unit' => 'lbfft', 'rpm' => '', 'weight' => 3600, 'weight-unit' => 'lb', 'et' => '', 'trap' => 112, 'trap-unit' => 'mph'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kw' => ['label' => 'In kW'],
            'ps' => ['label' => 'In PS'],
            'torque' => ['label' => 'Torque or note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hp = lb-ft × rpm ÷ 5,252</li>
            <li>hp ≈ lb × (5.825 ÷ ET)³ ≈ lb × (mph ÷ 234)³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
