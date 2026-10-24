<x-calc.page
    title="Propagation Delay Calculator - SolveKit"
    description="Free propagation delay calculator: signal delay along a trace or cable from its length and dielectric."
    lede="Find the propagation delay."
    about="Signals travel slower than light in a cable or board: by the square root of the effective dielectric constant."
    :calc="['engine' => 'tc-elec', 'tool' => 'propagation_delay', 'fields' => ['len', 'type', 'er', 'vf', 'f'], 'unitFields' => ['len' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['frequency_hz', 'length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What delay over 150 mm of FR-4 microstrip?', 'answer' => '824.05 ps.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="len" label="Length" value="150" placeholder="Length">
            <label for="calc-len-unit" class="sr-only">Length unit</label>
            <select id="calc-len-unit" name="len-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="type" label="Medium" :options="['strip' => 'Stripline or cable (εeff = εr)', 'micro' => 'Microstrip (εeff ≈ 0.475 εr + 0.67)', 'vf' => 'Velocity factor known']" selected="micro" />
        <div data-show-when="type:strip,micro">
            <x-calc.field name="er" label="Dielectric constant εr" value="4.3" min="1" step="any" />
        </div>
        <div data-show-when="type:vf">
            <x-calc.field name="vf" label="Velocity factor" value="0.66" min="0" step="any" />
        </div>
        <x-calc.field name="f" label="Frequency (for electrical length)" value="100" min="0" placeholder="Frequency (for electrical length)">
            <label for="calc-f-unit" class="sr-only">Frequency (for electrical length) unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Propagation delay" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['len' => 150, 'len-unit' => 'mm', 'type' => 'micro', 'er' => 4.3, 'vf' => 0.66, 'f' => 100, 'f-unit' => 'mhz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perUnit' => ['label' => 'Per inch and per cm'],
            'speed' => ['label' => 'Signal speed'],
            'electrical' => ['label' => 'Electrical length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
