<x-calc.page
    title="Free Space Path Loss Calculator - SolveKit"
    description="Free FSPL calculator: radio path loss in dB from distance and frequency, with received power."
    lede="Find free-space path loss."
    about="A radio signal spreads over an ever larger sphere. FSPL = 20 log(4πdf/c): doubling the distance or the frequency costs 6 dB."
    :calc="['engine' => 'ph-em', 'tool' => 'fspl', 'fields' => ['d', 'f', 'gt', 'gr', 'pt'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the loss over 1 km at 2.4 GHz?', 'answer' => '100.05 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Distance" value="1" placeholder="Distance">
            <label for="calc-d-unit" class="sr-only">Distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Frequency" value="2.4" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ghz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gt" label="Transmit antenna gain (dBi)" value="0" step="any" />
        <x-calc.field name="gr" label="Receive antenna gain (dBi)" value="0" step="any" />
        <x-calc.field name="pt" label="Transmit power (dBm, optional)" value="20" step="any" />
    </div>

    <x-calc.result label="Free-space path loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d' => 1, 'd-unit' => 'km', 'f' => 2.4, 'f-unit' => 'ghz', 'gt' => 0, 'gr' => 0, 'pt' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pr' => ['label' => 'Received power'],
            'lambda' => ['label' => 'Wavelength'],
            'per' => ['label' => 'Extra loss per doubling of distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
