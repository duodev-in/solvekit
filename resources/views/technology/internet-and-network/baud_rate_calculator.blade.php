<x-calc.page
    title="Baud Rate Calculator - SolveKit"
    description="Free baud rate calculator: convert between baud and bit rate for any modulation, with UART timing."
    lede="Convert baud and bit rate."
    about="Baud counts symbols per second; each symbol can carry several bits."
    :calc="['engine' => 'tc-net', 'tool' => 'baud', 'fields' => ['mode', 'rate', 'baud', 'bps'], 'unitFields' => ['rate' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all()], 'data' => ['units' => collect(config('units'))->only(['data_rate'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What baud carries 9600 bit/s with 2 bits per symbol?', 'answer' => '4,800 Bd.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['baud' => 'Baud rate from bit rate', 'bits' => 'Bit rate from baud rate']" selected="baud" />
        <div data-show-when="mode:baud">
            <x-calc.field name="rate" label="Bit rate" value="9600" min="0" placeholder="Bit rate">
                <label for="calc-rate-unit" class="sr-only">Bit rate unit</label>
                <select id="calc-rate-unit" name="rate-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'bps')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:bits">
            <x-calc.field name="baud" label="Baud rate (symbols per second)" value="2400" min="0" step="any" />
        </div>
        <x-calc.select name="bps" label="Bits per symbol (modulation)" :options="['1' => '1 (binary, FSK, BPSK, UART)', '2' => '2 (QPSK, 4-level)', '3' => '3 (8-PSK)', '4' => '4 (16-QAM)', '6' => '6 (64-QAM)', '8' => '8 (256-QAM)', '10' => '10 (1024-QAM)']" selected="2" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'baud', 'rate' => 9600, 'rate-unit' => 'bps', 'baud' => 2400, 'bps' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'symbol' => ['label' => 'Symbol time'],
            'uart' => ['label' => 'UART 8N1 bytes per second'],
            'bitTime' => ['label' => 'Bit time'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
