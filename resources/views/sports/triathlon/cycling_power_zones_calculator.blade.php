<x-calc.page
    title="Cycling Power Zones Calculator - SolveKit"
    description="Free cycling power zones calculator: Coggan’s seven zones from FTP."
    lede="Find your power zones."
    about="Andrew Coggan’s training levels split power into seven zones as percentages of FTP."
    :calc="['engine' => 'sp-cycle', 'tool' => 'power_zones', 'fields' => ['ftp', 'w'], 'unitFields' => ['ftp' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'power', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What are the zones for a 250 W FTP?', 'answer' => 'See the zone table.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ftp" label="FTP" value="250" min="0" placeholder="FTP">
            <label for="calc-ftp-unit" class="sr-only">FTP unit</label>
            <select id="calc-ftp-unit" name="ftp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Body weight (optional)" value="75" min="0" placeholder="Body weight (optional)">
            <label for="calc-w-unit" class="sr-only">Body weight (optional) unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="FTP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ftp' => 250, 'ftp-unit' => 'w', 'w' => 75, 'w-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wkg' => ['label' => 'FTP per kg'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Coggan power zones" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
