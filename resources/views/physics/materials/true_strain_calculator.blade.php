<x-calc.page
    title="True Strain Calculator - SolveKit"
    description="Free true strain calculator: logarithmic strain ln(L/L₀) and true stress from engineering values."
    lede="Convert to true strain."
    about="Engineering strain uses the original length; true strain adds up small increments on the current length, giving ln(L/L₀). They match for small strains and differ a lot in forming."
    :calc="['engine' => 'ph-mat', 'tool' => 'true_strain', 'fields' => ['mode', 'L0', 'L', 'e', 's'], 'unitFields' => ['L0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 's' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the true strain stretching 50 mm to 60 mm?', 'answer' => '0.18232.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['lengths' => 'Original and final lengths', 'eng' => 'Engineering strain']" selected="lengths" />
        <div data-show-when="mode:lengths">
            <x-calc.field name="L0" label="Original length" value="50" placeholder="Original length">
                <label for="calc-L0-unit" class="sr-only">Original length unit</label>
                <select id="calc-L0-unit" name="L0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:lengths">
            <x-calc.field name="L" label="Final length" value="60" placeholder="Final length">
                <label for="calc-L-unit" class="sr-only">Final length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:eng">
            <x-calc.field name="e" label="Engineering strain" value="0.2" step="any" />
        </div>
        <x-calc.field name="s" label="Engineering stress (optional)" value="400" min="0" placeholder="Engineering stress (optional)">
            <label for="calc-s-unit" class="sr-only">Engineering stress (optional) unit</label>
            <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="True strain" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'lengths', 'L0' => 50, 'L0-unit' => 'mm', 'L' => 60, 'L-unit' => 'mm', 'e' => 0.2, 's' => 400, 's-unit' => 'mpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'eng' => ['label' => 'Engineering strain'],
            'ts' => ['label' => 'True stress (constant volume)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
