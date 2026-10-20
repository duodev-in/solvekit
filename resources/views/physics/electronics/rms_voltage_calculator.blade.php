<x-calc.page
    title="RMS Voltage Calculator - SolveKit"
    description="Free RMS voltage calculator: RMS and average values of sine, square, triangle and rectified waveforms."
    lede="Find RMS voltage."
    about="RMS is the DC voltage that would heat a resistor equally. For a sine it is the peak divided by √2: 325 V peak mains is 230 V RMS."
    :calc="['engine' => 'ph-elec', 'tool' => 'rms', 'fields' => ['wave', 'given', 'V', 'out'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the RMS of a 325 V peak sine?', 'answer' => '229.81 V.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="wave" label="Waveform" :options="['sine' => 'Sine', 'square' => 'Square', 'triangle' => 'Triangle', 'sawtooth' => 'Sawtooth', 'half' => 'Half-wave rectified sine', 'full' => 'Full-wave rectified sine']" selected="sine" />
        <x-calc.select name="given" label="Value given as" :options="['peak' => 'Peak', 'pp' => 'Peak to peak']" selected="peak" />
        <x-calc.field name="V" label="Voltage" value="325" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="RMS voltage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'wave' => 'sine', 'given' => 'peak', 'V' => 325, 'V-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'avg' => ['label' => 'Average (rectified)'],
            'crest' => ['label' => 'Crest factor'],
            'form' => ['label' => 'Form factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
