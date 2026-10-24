<x-calc.page
    title="Duty Cycle Calculator - SolveKit"
    description="Free duty cycle calculator: duty cycle, frequency, average and RMS voltage of a pulse wave."
    lede="Find the duty cycle."
    about="Duty cycle is the share of each period a signal is on. PWM uses it to control power."
    :calc="['engine' => 'tc-elec', 'tool' => 'duty_cycle', 'fields' => ['on', 'period', 'v'], 'unitFields' => ['on' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'period' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['time'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the duty cycle of 2 ms on in 10 ms?', 'answer' => '20%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="on" label="Pulse width (on time)" value="2" placeholder="Pulse width (on time)">
            <label for="calc-on-unit" class="sr-only">Pulse width (on time) unit</label>
            <select id="calc-on-unit" name="on-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="period" label="Period" value="10" placeholder="Period">
            <label for="calc-period-unit" class="sr-only">Period unit</label>
            <select id="calc-period-unit" name="period-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Pulse voltage (V)" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="Duty cycle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['on' => 2, 'on-unit' => 'ms', 'period' => 10, 'period-unit' => 'ms', 'v' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'off' => ['label' => 'Off time'],
            'freq' => ['label' => 'Frequency'],
            'avg' => ['label' => 'Average voltage'],
            'rms' => ['label' => 'RMS voltage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
