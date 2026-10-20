<x-calc.page
    title="Crossover Calculator - SolveKit"
    description="Free speaker crossover calculator: inductor and capacitor values for first- and second-order passive crossovers."
    lede="Design a passive speaker crossover."
    about="A two-way crossover sends lows to the woofer and highs to the tweeter. Second-order Linkwitz–Riley crossovers sum flat when the tweeter is wired in reverse."
    :calc="['engine' => 'ph-elec', 'tool' => 'crossover', 'fields' => ['f', 'Rw', 'Rt', 'type'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'Rw' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Rt' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What parts does a 2.5 kHz LR2 crossover for 8 Ω drivers need?', 'answer' => 'Series L = 1.0186 mH, shunt C = 3.9789 µF on the woofer; Series C = 3.9789 µF, shunt L = 1.0186 mH on the tweeter.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f" label="Crossover frequency" value="2500" min="0" placeholder="Crossover frequency">
            <label for="calc-f-unit" class="sr-only">Crossover frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Rw" label="Woofer impedance" value="8" min="0" placeholder="Woofer impedance">
            <label for="calc-Rw-unit" class="sr-only">Woofer impedance unit</label>
            <select id="calc-Rw-unit" name="Rw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Rt" label="Tweeter impedance" value="8" min="0" placeholder="Tweeter impedance">
            <label for="calc-Rt-unit" class="sr-only">Tweeter impedance unit</label>
            <select id="calc-Rt-unit" name="Rt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="type" label="Type" :options="['first' => 'First order (6 dB/octave)', 'bw2' => 'Second-order Butterworth (12 dB/octave)', 'lr2' => 'Second-order Linkwitz–Riley (12 dB/octave)']" selected="lr2" />
    </div>

    <x-calc.result label="Crossover components" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['f' => 2500, 'f-unit' => 'hz', 'Rw' => 8, 'Rw-unit' => 'ohm', 'Rt' => 8, 'Rt-unit' => 'ohm', 'type' => 'lr2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'woofer' => ['label' => 'Woofer (low-pass)'],
            'tweeter' => ['label' => 'Tweeter (high-pass)'],
            'polarity' => ['label' => 'Tweeter polarity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
