<x-calc.page
    title="SCFM Calculator — Standard Cubic Feet per Minute - SolveKit"
    description="Free SCFM calculator: convert actual flow (ACFM) to standard flow for compressed air and gases."
    lede="Convert ACFM to SCFM."
    about="Compressed gas takes up less room, so flows are compared at standard conditions. SCFM scales actual flow by absolute pressure and temperature."
    :calc="['engine' => 'ph-thermo', 'tool' => 'scfm', 'fields' => ['Q', 'P', 'Patm', 'T', 'std', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'Patm' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 100 ACFM at 100 psig and 80 °F in SCFM?', 'answer' => '763.106 cfm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Actual flow" value="100" min="0" placeholder="Actual flow">
            <label for="calc-Q-unit" class="sr-only">Actual flow unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cfm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="P" label="Actual pressure (gauge)" value="100" min="0" placeholder="Actual pressure (gauge)">
            <label for="calc-P-unit" class="sr-only">Actual pressure (gauge) unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Patm" label="Atmospheric pressure" value="14.696" min="0" placeholder="Atmospheric pressure">
            <label for="calc-Patm-unit" class="sr-only">Atmospheric pressure unit</label>
            <select id="calc-Patm-unit" name="Patm-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Actual temperature" value="80" placeholder="Actual temperature">
            <label for="calc-T-unit" class="sr-only">Actual temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="std" label="Standard conditions" :options="['cagi' => '14.696 psia, 68 °F (CAGI/ISO 1217)', 'gas' => '14.696 psia, 60 °F (gas industry)', 'normal' => '101.325 kPa, 0 °C (normal, Nm³)']" selected="cagi" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="cfm" />
    </div>

    <x-calc.result label="Standard flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cfm', 'Q' => 100, 'Q-unit' => 'cfm', 'P' => 100, 'P-unit' => 'psi', 'Patm' => 14.696, 'Patm-unit' => 'psi', 'T' => 80, 'T-unit' => 'f', 'std' => 'cagi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nm3h' => ['label' => 'In m³/h at those conditions'],
            'ratio' => ['label' => 'Correction factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
