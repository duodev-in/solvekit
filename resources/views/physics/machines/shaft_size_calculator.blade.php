<x-calc.page
    title="Shaft Size Calculator - SolveKit"
    description="Free shaft size calculator: minimum solid shaft diameter for combined bending and torque with a safety factor."
    lede="Size a shaft for bending and torque."
    about="A shaft carrying both bending and torque is sized so the combined stress stays below yield divided by the safety factor. This is a static check; rotating shafts also need a fatigue check."
    :calc="['engine' => 'ph-mach', 'tool' => 'shaft_size', 'fields' => ['M', 'T', 'mat', 'sy', 'n', 'out'], 'unitFields' => ['M' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'T' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'sy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'torque'])->all(), 'physics' => collect(config('physics_data'))->only(['materials'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What diameter carries 300 N·m bending and 500 N·m torque in 4140?', 'answer' => '25.3984 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M" label="Bending moment" value="300" placeholder="Bending moment">
            <label for="calc-M-unit" class="sr-only">Bending moment unit</label>
            <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Torque" value="500" placeholder="Torque">
            <label for="calc-T-unit" class="sr-only">Torque unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mat" label="Material" :options="['a36' => 'Structural steel (A36)', 'steel_4140' => 'Alloy steel 4140 (quenched and tempered)', 'ss304' => 'Stainless steel 304 (annealed)', 'al6061' => 'Aluminium 6061-T6', 'al7075' => 'Aluminium 7075-T6', 'copper' => 'Copper (annealed)', 'brass' => 'Brass C360 (free-cutting)', 'ti64' => 'Titanium Ti-6Al-4V', 'cast_iron' => 'Grey cast iron (class 30)', 'concrete' => 'Concrete (30 MPa)', 'glass' => 'Soda-lime glass', 'nylon' => 'Nylon 6/6', 'pvc' => 'Rigid PVC', 'oak' => 'Oak (along the grain)', 'custom' => 'Other (enter the value)']" selected="steel_4140" />
        <div data-show-when="mat:custom">
            <x-calc.field name="sy" label="Yield strength" value="400" min="0" placeholder="Yield strength">
                <label for="calc-sy-unit" class="sr-only">Yield strength unit</label>
                <select id="calc-sy-unit" name="sy-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="n" label="Safety factor" value="2" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Minimum solid shaft diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'M' => 300, 'M-unit' => 'nm', 'T' => 500, 'T-unit' => 'nm', 'mat' => 'steel_4140', 'sy' => 400, 'sy-unit' => 'mpa', 'n' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tresca' => ['label' => 'By maximum shear (Tresca)'],
            'sy' => ['label' => 'Yield strength used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
