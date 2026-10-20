<x-calc.page
    title="Skin Depth Calculator - SolveKit"
    description="Free skin depth calculator: how deep AC current penetrates a conductor at any frequency."
    lede="Find skin depth."
    about="At high frequency current crowds near a conductor’s surface. In copper the skin depth is 9.3 mm at 50 Hz but only 65 µm at 1 MHz."
    :calc="['engine' => 'ph-em', 'tool' => 'skin_depth', 'fields' => ['mat', 'rho', 'mur', 'f', 'out'], 'unitFields' => ['rho' => collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'resistivity', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['conductors'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the skin depth of copper at 1 MHz?', 'answer' => '66.0848 µm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Conductor" :options="['copper' => 'Copper (annealed)', 'aluminium' => 'Aluminium (EC grade)', 'silver' => 'Silver', 'gold' => 'Gold', 'tungsten' => 'Tungsten', 'brass' => 'Brass', 'iron' => 'Iron (pure)', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'constantan' => 'Constantan', 'nichrome' => 'Nichrome (80/20)', 'custom' => 'Other (enter the value)']" selected="copper" />
        <div data-show-when="mat:custom">
            <x-calc.field name="rho" label="Resistivity" value="1.7e-08" min="0" placeholder="Resistivity">
                <label for="calc-rho-unit" class="sr-only">Resistivity unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohmm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="mur" label="Relative permeability" value="1" min="0" step="any" />
        </div>
        <x-calc.field name="f" label="Frequency" value="1" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="um" />
    </div>

    <x-calc.result label="Skin depth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'um', 'mat' => 'copper', 'rho' => 1.7e-08, 'rho-unit' => 'ohmm', 'mur' => 1, 'f' => 1, 'f-unit' => 'mhz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rs' => ['label' => 'Surface resistance'],
            'at50' => ['label' => 'At 50 Hz'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
