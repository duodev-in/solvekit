<x-calc.page
    title="Bike Size Calculator - SolveKit"
    description="Free bike size calculator: frame size and saddle height from your inseam."
    lede="Find your bike frame size."
    about="Common fitting rules size the frame from your inseam and set saddle height at 0.883 × inseam. Makers’ charts and a test ride have the final word."
    :calc="['engine' => 'sp-cycle', 'tool' => 'bike_size', 'fields' => ['inseam', 'type'], 'unitFields' => ['inseam' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What frame suits an 81 cm inseam?', 'answer' => '53.9 cm (road).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="inseam" label="Inseam (floor to crotch, in socks)" value="81" placeholder="Inseam (floor to crotch, in socks)">
            <label for="calc-inseam-unit" class="sr-only">Inseam (floor to crotch, in socks) unit</label>
            <select id="calc-inseam-unit" name="inseam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="type" label="Bike" :options="['road' => 'Road or gravel', 'mtb' => 'Mountain', 'hybrid' => 'Hybrid or city']" selected="road" />
    </div>

    <x-calc.result label="Frame size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['inseam' => 81, 'inseam-unit' => 'cm', 'type' => 'road'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'saddle' => ['label' => 'Saddle height (centre of bottom bracket to top of saddle)'],
            'note' => ['label' => 'Fit'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
