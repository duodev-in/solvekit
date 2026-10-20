<x-calc.page
    title="BMEP Calculator (Brake Mean Effective Pressure Calculator) - SolveKit"
    description="Free BMEP calculator: brake mean effective pressure from torque or power and engine displacement."
    lede="Find an engine’s BMEP."
    about="BMEP is the steady pressure that would produce the measured torque. It lets engines of different size be compared: a good naturally aspirated petrol engine reaches about 13 bar."
    :calc="['engine' => 'ph-mach', 'tool' => 'bmep', 'fields' => ['mode', 'T', 'P', 'rpm', 'V', 'strokes', 'out'], 'unitFields' => ['T' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'pressure', 'speed', 'torque', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the BMEP of a 2.0 L four-stroke making 400 N·m?', 'answer' => '25.1327 bar.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['torque' => 'Torque', 'power' => 'Power and rpm']" selected="torque" />
        <div data-show-when="mode:torque">
            <x-calc.field name="T" label="Torque" value="400" placeholder="Torque">
                <label for="calc-T-unit" class="sr-only">Torque unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:power">
            <x-calc.field name="P" label="Power" value="150" min="0" placeholder="Power">
                <label for="calc-P-unit" class="sr-only">Power unit</label>
                <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:power">
            <x-calc.field name="rpm" label="Engine speed (rpm)" value="5500" min="0" step="any" />
        </div>
        <x-calc.field name="V" label="Displacement" value="2" min="0" placeholder="Displacement">
            <label for="calc-V-unit" class="sr-only">Displacement unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="strokes" label="Cycle" :options="['four' => 'Four-stroke', 'two' => 'Two-stroke']" selected="four" />
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="bar" />
    </div>

    <x-calc.result label="Brake mean effective pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'bar', 'mode' => 'torque', 'T' => 400, 'T-unit' => 'nm', 'P' => 150, 'P-unit' => 'kw', 'rpm' => 5500, 'V' => 2, 'V-unit' => 'l', 'strokes' => 'four'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Torque'],
            'typical' => ['label' => 'Typical BMEP'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
