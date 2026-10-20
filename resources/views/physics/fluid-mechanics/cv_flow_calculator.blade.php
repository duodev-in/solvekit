<x-calc.page
    title="Cv Flow Calculator - SolveKit"
    description="Free Cv flow calculator: liquid or gas flow through a valve from its Cv and pressure drop."
    lede="Find flow through a valve."
    about="A valve’s Cv is the flow of water in US gpm at 1 psi drop. Liquid flow scales with √(ΔP/SG); gas flow follows the ISA form and chokes at large drops."
    :calc="['engine' => 'ph-fluid', 'tool' => 'cv_flow', 'fields' => ['medium', 'Cv', 'dP', 'sg', 'P1', 'T'], 'unitFields' => ['dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flows through Cv 5 at 10 psi?', 'answer' => '15.811 US gpm gpm of water.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="medium" label="Medium" :options="['liquid' => 'Liquid', 'gas' => 'Gas']" selected="liquid" />
        <x-calc.field name="Cv" label="Valve Cv" value="5" min="0" step="any" />
        <x-calc.field name="dP" label="Pressure drop" value="10" min="0" placeholder="Pressure drop">
            <label for="calc-dP-unit" class="sr-only">Pressure drop unit</label>
            <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sg" label="Specific gravity (liquid: water = 1; gas: air = 1)" value="1" min="0" step="any" />
        <div data-show-when="medium:gas">
            <x-calc.field name="P1" label="Inlet pressure (absolute)" value="100" min="0" placeholder="Inlet pressure (absolute)">
                <label for="calc-P1-unit" class="sr-only">Inlet pressure (absolute) unit</label>
                <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="medium:gas">
            <x-calc.field name="T" label="Gas temperature" value="60" placeholder="Gas temperature">
                <label for="calc-T-unit" class="sr-only">Gas temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['medium' => 'liquid', 'Cv' => 5, 'dP' => 10, 'dP-unit' => 'psi', 'sg' => 1, 'P1' => 100, 'P1-unit' => 'psi', 'T' => 60, 'T-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'si' => ['label' => 'In SI units'],
            'note' => ['label' => 'Flow state'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
