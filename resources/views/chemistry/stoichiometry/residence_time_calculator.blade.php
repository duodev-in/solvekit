<x-calc.page
    title="Residence Time Calculator - SolveKit"
    description="Free residence time calculator (detention time, hydraulic retention time): time, volume or flow from τ = V ÷ Q for tanks and reactors."
    lede="Work out residence time (detention time, hydraulic retention time) from volume and flow."
    about="Residence time τ is the average time fluid spends in a tank or reactor: volume ÷ flow rate. The same formula is called detention time in water treatment and hydraulic retention time (HRT) in wastewater. Space velocity is its inverse."
    :calc="['engine' => 'chem-stoich', 'tool' => 'residence_time', 'fields' => ['solve', 'volume', 'flow', 'flow_unit', 'time'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['l', 'gal_us', 'ft3', 'm3'])->all(), 'time' => collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Time, volume or flow.'],
        ['name' => 'Enter the other two', 'text' => 'Any units.'],
    ]"
    :faqs="[
        ['question' => 'What is the formula for residence time?', 'answer' => 'τ = V ÷ Q, volume divided by flow rate.'],
        ['question' => 'Is detention time the same as HRT?', 'answer' => 'Yes, both are volume ÷ flow.'],
        ['question' => 'What is space velocity?', 'answer' => '1 ÷ τ, the number of reactor volumes processed per unit time.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['tau' => 'Residence time', 'volume' => 'Volume', 'flow' => 'Flow rate']" selected="tau" />

    <div data-show-when="solve:tau,flow">
        <x-calc.field name="volume" label="Volume" value="1000" min="0" placeholder="Volume">
            <label for="calc-volume-unit" class="sr-only">Volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['l', 'gal_us', 'ft3', 'm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="solve:tau,volume">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="flow" label="Flow rate" value="10" min="0" />
            <x-calc.select name="flow_unit" label="Flow unit" :options="['l_min' => 'L/min', 'l_s' => 'L/s', 'l_h' => 'L/h', 'm3_h' => 'm³/h', 'm3_d' => 'm³/day', 'gpm' => 'US gal/min', 'mgd' => 'MGD']" selected="l_min" />
        </div>
    </div>

    <div data-show-when="solve:volume,flow" hidden>
        <x-calc.field name="time" label="Residence time" value="2" min="0" placeholder="Residence time">
            <label for="calc-time-unit" class="sr-only">Residence time unit</label>
            <select id="calc-time-unit" name="time-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'h')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '1000 L at 10 L/min' => ['solve' => 'tau', 'volume' => 1000, 'volume-unit' => 'l', 'flow' => 10, 'flow_unit' => 'l_min'],
        'Clarifier 500 m³, 100 m³/h' => ['solve' => 'tau', 'volume' => 500, 'volume-unit' => 'm3', 'flow' => 100, 'flow_unit' => 'm3_h'],
        'Tank for 2 h at 1 MGD' => ['solve' => 'volume', 'time' => 2, 'time-unit' => 'h', 'flow' => 1, 'flow_unit' => 'mgd'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'minutes' => ['label' => 'In minutes'],
            'days' => ['label' => 'In days'],
            'velocity' => ['label' => 'Space velocity'],
            'turnovers' => ['label' => 'Volume turnovers'],
            'volume' => ['label' => 'Volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>τ = V ÷ Q</li>
            <li>space velocity = 1 ÷ τ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
