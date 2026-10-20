<x-calc.page
    title="ERG Calculator - SolveKit"
    description="Free rowing erg calculator: convert split per 500 m, watts and calories per hour."
    lede="Convert erg pace and watts."
    about="Concept2 rowing machines link pace and power exactly: watts = 2.80 ÷ pace³."
    :calc="['engine' => 'sp-fit', 'tool' => 'erg', 'fields' => ['by', 'split', 'P', 'cal', 'd'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many watts is a 2:00 split?', 'answer' => '202.5 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['split' => 'Split per 500 m', 'watts' => 'Watts', 'cal' => 'Calories per hour']" selected="split" />
        <div data-show-when="by:split">
            <x-calc.field name="split" label="Split per 500 m (m:ss.s)" value="2:00.0" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:watts">
            <x-calc.field name="P" label="Watts" value="203" min="1" step="any" />
        </div>
        <div data-show-when="by:cal">
            <x-calc.field name="cal" label="Calories per hour" value="999" min="301" step="any" />
        </div>
        <x-calc.field name="d" label="Distance (for the finish time)" value="2000" placeholder="Distance (for the finish time)">
            <label for="calc-d-unit" class="sr-only">Distance (for the finish time) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Split per 500 m" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'split', 'split' => '2:00.0', 'P' => 203, 'cal' => 999, 'd' => 2000, 'd-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'watts' => ['label' => 'Watts'],
            'cal' => ['label' => 'Calories per hour'],
            'time' => ['label' => 'Time for the distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
