<x-calc.page
    title="VSWR Calculator (Voltage Standing Wave Ratio Calculator) - SolveKit"
    description="Free VSWR calculator: VSWR, reflection coefficient, return loss and mismatch loss from impedances."
    lede="Find VSWR and return loss."
    about="A load that does not match the line reflects part of the signal, setting up standing waves. VSWR 1:1 is perfect; 2:1 reflects 11%."
    :calc="['engine' => 'ph-em', 'tool' => 'vswr', 'fields' => ['mode', 'R', 'X', 'Z0', 'g', 'rl'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'X' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'Z0' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the VSWR of 75 Ω on a 50 Ω line?', 'answer' => '1.5 : 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['z' => 'Load and line impedance', 'gamma' => 'Reflection coefficient', 'rl' => 'Return loss']" selected="z" />
        <div data-show-when="mode:z">
            <x-calc.field name="R" label="Load resistance" value="75" min="0" placeholder="Load resistance">
                <label for="calc-R-unit" class="sr-only">Load resistance unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:z">
            <x-calc.field name="X" label="Load reactance" value="0" min="0" placeholder="Load reactance">
                <label for="calc-X-unit" class="sr-only">Load reactance unit</label>
                <select id="calc-X-unit" name="X-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:z">
            <x-calc.field name="Z0" label="Line impedance" value="50" min="0" placeholder="Line impedance">
                <label for="calc-Z0-unit" class="sr-only">Line impedance unit</label>
                <select id="calc-Z0-unit" name="Z0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:gamma">
            <x-calc.field name="g" label="|Γ|" value="0.2" min="0" step="any" />
        </div>
        <div data-show-when="mode:rl">
            <x-calc.field name="rl" label="Return loss (dB)" value="14" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="VSWR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'z', 'R' => 75, 'R-unit' => 'ohm', 'X' => 0, 'X-unit' => 'ohm', 'Z0' => 50, 'Z0-unit' => 'ohm', 'g' => 0.2, 'rl' => 14],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gamma' => ['label' => 'Reflection coefficient |Γ|'],
            'rl' => ['label' => 'Return loss'],
            'mismatch' => ['label' => 'Mismatch loss'],
            'reflected' => ['label' => 'Reflected power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
