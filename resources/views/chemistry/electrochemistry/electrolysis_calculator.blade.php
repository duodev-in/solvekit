<x-calc.page
    title="Electrolysis Calculator - SolveKit"
    description="Free electrolysis calculator: mass deposited, time or current with Faraday's laws for electroplating and electrolysis."
    lede="Work out the mass deposited, time or current in electrolysis."
    about="Faraday's law: m = I t M ÷ (z F), where z is the electrons per ion and F = 96 485.33 C/mol (exact since 2019). Real cells lose some current to side reactions; enter a current efficiency to allow for it."
    :calc="['engine' => 'chem-electro', 'tool' => 'electrolysis', 'fields' => ['solve', 'formula', 'charge_number', 'current', 'time', 'mass', 'efficiency', 'weight'], 'unitFields' => ['time' => collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Mass, time or current.'],
        ['name' => 'Enter the substance and z', 'text' => 'Electrons per ion.'],
        ['name' => 'Enter the rest', 'text' => 'Current in amps, time in any unit.'],
    ]"
    :faqs="[
        ['question' => 'How much copper does 1 A deposit in an hour?', 'answer' => 'About 1.19 g.'],
        ['question' => 'What is Faraday\'s constant?', 'answer' => '96 485.33 C per mole of electrons.'],
        ['question' => 'Why add current efficiency?', 'answer' => 'Some current may make hydrogen or other side products instead.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['mass' => 'Mass deposited', 'time' => 'Time', 'current' => 'Current']" selected="mass" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Substance" value="Cu" type="text" help="Metal or species deposited" />
        <x-calc.field name="charge_number" label="Electrons per ion z" value="2" min="1" step="1" help="2 for Cu²⁺, 1 for Ag⁺" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:mass,time">
            <x-calc.field name="current" label="Current" value="1" min="0" suffix="A" />
        </div>
        <div data-show-when="solve:mass,current">
            <x-calc.field name="time" label="Time" value="1" min="0" placeholder="Time">
                <label for="calc-time-unit" class="sr-only">Time unit</label>
                <select id="calc-time-unit" name="time-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'h')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:time,current" hidden>
            <x-calc.field name="mass" label="Mass" value="1.19" min="0" suffix="g" />
        </div>
        <x-calc.field name="efficiency" label="Current efficiency" value="100" min="1" max="100" suffix="%" />
    </div>

    <x-calc.field name="weight" label="Or molar mass" value="" min="0" suffix="g/mol" placeholder="If no formula" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Copper, 1 A for 1 h' => ['solve' => 'mass', 'formula' => 'Cu', 'charge_number' => 2, 'current' => 1, 'time' => 1, 'time-unit' => 'h', 'efficiency' => 100],
        'Silver plating 5 g' => ['solve' => 'time', 'formula' => 'Ag', 'charge_number' => 1, 'mass' => 5, 'current' => 2, 'efficiency' => 95],
        'Aluminum smelting' => ['solve' => 'mass', 'formula' => 'Al', 'charge_number' => 3, 'current' => 300000, 'time' => 1, 'time-unit' => 'day', 'efficiency' => 92],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'charge' => ['label' => 'Charge passed'],
            'moles' => ['label' => 'Moles deposited'],
            'electrons' => ['label' => 'Electrons'],
            'minutes' => ['label' => 'Time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m = I t M ÷ (z F)</li>
            <li>F = 96 485.332 12 C/mol</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
