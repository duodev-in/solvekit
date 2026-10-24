<x-calc.page
    title="Rain to Snow Calculator - SolveKit"
    description="Free rain to snow calculator: snow depth from liquid precipitation and temperature."
    lede="Convert rain to snow."
    about="Snow is fluffier in colder air: the same water makes deeper snow."
    :calc="['engine' => 'ot-misc', 'tool' => 'rain_snow', 'fields' => ['rain', 'temp', 'by', 'ratio'], 'unitFields' => ['rain' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'other' => collect(config('other_data'))->only(['snow_ratio'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much snow from 10 mm of water at 25 °F?', 'answer' => '15 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rain" label="Liquid precipitation (rain equivalent)" value="10" placeholder="Liquid precipitation (rain equivalent)">
            <label for="calc-rain-unit" class="sr-only">Liquid precipitation (rain equivalent) unit</label>
            <select id="calc-rain-unit" name="rain-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="by:table">
            <x-calc.field name="temp" label="Surface temperature (°F)" value="25" step="any" />
        </div>
        <x-calc.select name="by" label="Ratio" :options="['table' => 'From temperature (NWS table)', 'fixed' => 'My own ratio']" selected="table" />
        <div data-show-when="by:fixed">
            <x-calc.field name="ratio" label="Snow : liquid ratio" value="10" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Snow depth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rain' => 10, 'rain-unit' => 'mm', 'temp' => 25, 'by' => 'table', 'ratio' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratioUsed' => ['label' => 'Ratio used'],
            'inches' => ['label' => 'In inches'],
            'range' => ['label' => 'Plausible range (5:1 to 20:1)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
