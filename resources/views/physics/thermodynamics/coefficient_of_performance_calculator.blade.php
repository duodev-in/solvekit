<x-calc.page
    title="Coefficient of Performance Calculator - SolveKit"
    description="Free COP calculator: coefficient of performance of heat pumps and refrigerators, measured or ideal."
    lede="Find the COP."
    about="A heat pump moves more heat than the electricity it uses. Its COP is heat moved over work; the Carnot limit depends only on the two temperatures."
    :calc="['engine' => 'ph-thermo', 'tool' => 'cop', 'fields' => ['kind', 'mode', 'Q', 'W', 'Th', 'Tc'], 'unitFields' => ['Q' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'W' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'Th' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tc' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the COP for 10 kW of heat from 3 kW?', 'answer' => '3.333.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Machine" :options="['hp' => 'Heat pump (heating)', 'fridge' => 'Refrigerator or air conditioner (cooling)']" selected="hp" />
        <x-calc.select name="mode" label="I know" :options="['qw' => 'Heat moved and work input', 'temps' => 'The two temperatures (ideal limit)']" selected="qw" />
        <div data-show-when="mode:qw">
            <x-calc.field name="Q" label="Heat delivered or removed" value="10" min="0" placeholder="Heat delivered or removed">
                <label for="calc-Q-unit" class="sr-only">Heat delivered or removed unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:qw">
            <x-calc.field name="W" label="Electrical input" value="3" min="0" placeholder="Electrical input">
                <label for="calc-W-unit" class="sr-only">Electrical input unit</label>
                <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:temps">
            <x-calc.field name="Th" label="Hot side" value="35" placeholder="Hot side">
                <label for="calc-Th-unit" class="sr-only">Hot side unit</label>
                <select id="calc-Th-unit" name="Th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:temps">
            <x-calc.field name="Tc" label="Cold side" value="0" placeholder="Cold side">
                <label for="calc-Tc-unit" class="sr-only">Cold side unit</label>
                <select id="calc-Tc-unit" name="Tc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Coefficient of performance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'hp', 'mode' => 'qw', 'Q' => 10, 'Q-unit' => 'kw', 'W' => 3, 'W-unit' => 'kw', 'Th' => 35, 'Th-unit' => 'c', 'Tc' => 0, 'Tc-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'eer' => ['label' => 'EER (BTU/h per W)'],
            'note' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
