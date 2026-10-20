<x-calc.page
    title="Pace Calculator - SolveKit"
    description="Free pace calculator: pace, time or distance from the other two."
    lede="Find pace, time or distance."
    about="Pace is time per distance. Know any two of distance, time and pace and you have the third. Also known as 5k Pace Calculator."
    :calc="['engine' => 'sp-run', 'tool' => 'pace', 'fields' => ['want', 'd', 't', 'p'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the pace for 5 km in 25:00?', 'answer' => '5:00 /km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="want" label="Find" :options="['pace' => 'Pace', 'time' => 'Time', 'dist' => 'Distance']" selected="pace" />
        <div data-show-when="want:pace,time">
            <x-calc.field name="d" label="Distance" value="5" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="want:pace,dist">
            <x-calc.field name="t" label="Time (h:mm:ss)" value="25:00" type="text" inputmode="text" />
        </div>
        <div data-show-when="want:time,dist">
            <x-calc.field name="p" label="Pace per km (m:ss)" value="5:00" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['want' => 'pace', 'd' => 5, 'd-unit' => 'km', 't' => '25:00', 'p' => '5:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pace' => ['label' => 'Pace'],
            'speed' => ['label' => 'Speed'],
            'time' => ['label' => 'Time'],
            'dist' => ['label' => 'Distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
