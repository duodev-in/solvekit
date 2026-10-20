<x-calc.page
    title="555 Timer Calculator - SolveKit"
    description="Free 555 timer calculator: frequency, duty cycle and pulse width for astable and monostable modes."
    lede="Design a 555 timer circuit."
    about="In astable mode the 555 charges its capacitor through R1 + R2 and discharges through R2. In monostable mode one trigger gives one pulse of 1.1RC."
    :calc="['engine' => 'ph-elec', 'tool' => 'timer555', 'fields' => ['mode', 'R1', 'R2', 'R', 'C'], 'unitFields' => ['R1' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R2' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What frequency do 1 kΩ, 10 kΩ and 10 µF give?', 'answer' => '6.87 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Mode" :options="['astable' => 'Astable (oscillator)', 'mono' => 'Monostable (one pulse)']" selected="astable" />
        <div data-show-when="mode:astable">
            <x-calc.field name="R1" label="R1" value="1" min="0" placeholder="R1">
                <label for="calc-R1-unit" class="sr-only">R1 unit</label>
                <select id="calc-R1-unit" name="R1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:astable">
            <x-calc.field name="R2" label="R2" value="10" min="0" placeholder="R2">
                <label for="calc-R2-unit" class="sr-only">R2 unit</label>
                <select id="calc-R2-unit" name="R2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:mono">
            <x-calc.field name="R" label="R" value="100" min="0" placeholder="R">
                <label for="calc-R-unit" class="sr-only">R unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="C" label="Capacitor" value="10" min="0" placeholder="Capacitor">
            <label for="calc-C-unit" class="sr-only">Capacitor unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'astable', 'R1' => 1, 'R1-unit' => 'kohm', 'R2' => 10, 'R2-unit' => 'kohm', 'R' => 100, 'R-unit' => 'kohm', 'C' => 10, 'C-unit' => 'uf'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Output waveform" name="wave" />
        <x-calc.rows heading="Details" :rows="[
            'high' => ['label' => 'Time high'],
            'low' => ['label' => 'Time low'],
            'duty' => ['label' => 'Duty cycle'],
            'period' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
