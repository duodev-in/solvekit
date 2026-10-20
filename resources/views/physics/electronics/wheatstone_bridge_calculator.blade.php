<x-calc.page
    title="Wheatstone Bridge Calculator - SolveKit"
    description="Free Wheatstone bridge calculator: unknown resistance at balance, or bridge output voltage."
    lede="Solve a Wheatstone bridge."
    about="A Wheatstone bridge compares resistor ratios. At balance the output is zero and R_x = R₂R₃/R₁; strain gauges use the small output when unbalanced."
    :calc="['engine' => 'ph-elec', 'tool' => 'wheatstone', 'fields' => ['mode', 'R1', 'R2', 'R3', 'Rx', 'Vs'], 'unitFields' => ['R1' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R2' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'R3' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Rx' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Vs' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What R_x balances 100, 200 and 150 Ω?', 'answer' => '300 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['balance' => 'The unknown resistor at balance', 'output' => 'The output voltage for a given Rx']" selected="balance" />
        <x-calc.field name="R1" label="R1" value="100" min="0" placeholder="R1">
            <label for="calc-R1-unit" class="sr-only">R1 unit</label>
            <select id="calc-R1-unit" name="R1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="R2" label="R2" value="200" min="0" placeholder="R2">
            <label for="calc-R2-unit" class="sr-only">R2 unit</label>
            <select id="calc-R2-unit" name="R2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="R3" label="R3" value="150" min="0" placeholder="R3">
            <label for="calc-R3-unit" class="sr-only">R3 unit</label>
            <select id="calc-R3-unit" name="R3-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:output">
            <x-calc.field name="Rx" label="Rx" value="310" min="0" placeholder="Rx">
                <label for="calc-Rx-unit" class="sr-only">Rx unit</label>
                <select id="calc-Rx-unit" name="Rx-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:output">
            <x-calc.field name="Vs" label="Excitation voltage" value="5" placeholder="Excitation voltage">
                <label for="calc-Vs-unit" class="sr-only">Excitation voltage unit</label>
                <select id="calc-Vs-unit" name="Vs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'balance', 'R1' => 100, 'R1-unit' => 'ohm', 'R2' => 200, 'R2-unit' => 'ohm', 'R3' => 150, 'R3-unit' => 'ohm', 'Rx' => 310, 'Rx-unit' => 'ohm', 'Vs' => 5, 'Vs-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Bridge ratio R2/R1'],
            'note' => ['label' => 'Arrangement'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
