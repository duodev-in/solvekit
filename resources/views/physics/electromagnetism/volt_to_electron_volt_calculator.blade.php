<x-calc.page
    title="Volt to Electron Volt Calculator - SolveKit"
    description="Free volt to electronvolt calculator: energy gained by a charge accelerated through a voltage."
    lede="Convert volts to electronvolts."
    about="An electronvolt is the energy an electron gains crossing one volt: 1.602 × 10⁻¹⁹ J. A charge of z e through V volts gains zV eV."
    :calc="['engine' => 'ph-em', 'tool' => 'volt_ev', 'fields' => ['V', 'z'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does an electron gain through 1,000 V?', 'answer' => '1,000 eV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V" label="Voltage" value="1000" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="z" label="Charge (in units of e)" value="1" step="any" />
    </div>

    <x-calc.result label="Energy gained" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['V' => 1000, 'V-unit' => 'v', 'z' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'J' => ['label' => 'In joules'],
            'kev' => ['label' => 'In keV'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
