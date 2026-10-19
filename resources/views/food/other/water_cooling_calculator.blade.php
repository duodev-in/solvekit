<x-calc.page
    title="Water Cooling Calculator - SolveKit"
    description="Free water cooling calculator: how long hot water, coffee or soup takes to cool to a temperature in a mug, glass or pot, by Newton's law of cooling, optionally fitted to a reading you take."
    lede="Estimate how long hot water takes to cool."
    about="Newton's law of cooling: T(t) = T_room + (T₀ − T_room) e^(−t/τ). The time constant τ depends on the container: about 35 minutes for a mug in still air, 2–3 hours for a pot of soup. For a better estimate take one reading (minutes and temperature) and the calculator fits τ to it. Cooked food must be cooled quickly for safety: the FDA Food Code allows 2 hours from 135 °F to 70 °F and 4 more to 41 °F."
    :calc="['engine' => 'fd-other', 'tool' => 'water_cool', 'fields' => ['start', 'target', 'room', 'vessel', 'after', 'measured'], 'unitFields' => ['start' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'target' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'room' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'measured' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter the start, target and room temperatures', 'text' => ''],
        ['name' => 'Choose the container', 'text' => 'Or add one reading to fit it.'],
    ]"
    :faqs="[
        ['question' => 'How long does a mug of 90 °C water take to cool to 60 °C?', 'answer' => '20 min in a 21 °C room.'],
        ['question' => 'A pot of soup to 21 °C plus a bit?', 'answer' => '5.27 h to 30 °C (use an ice bath for food).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Start" value="90" placeholder="Start">
            <label for="calc-start-unit" class="sr-only">Start unit</label>
            <select id="calc-start-unit" name="start-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Target" value="60" placeholder="Target">
            <label for="calc-target-unit" class="sr-only">Target unit</label>
            <select id="calc-target-unit" name="target-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="room" label="Room" value="21" placeholder="Room">
            <label for="calc-room-unit" class="sr-only">Room unit</label>
            <select id="calc-room-unit" name="room-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="vessel" label="Container" :options="['mug' => 'Mug (250 ml)', 'glass' => 'Glass (250 ml)', 'pan' => 'Saucepan (1 L)', 'pot' => 'Stock pot (4 L)']" selected="mug" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="after" label="Your reading after (optional)" value="" min="0" step="any" suffix="min" placeholder="Optional" />
        <x-calc.field name="measured" label="Temperature at that time" value="" placeholder="Optional">
            <label for="calc-measured-unit" class="sr-only">Temperature at that time unit</label>
            <select id="calc-measured-unit" name="measured-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Time to cool" />

    <x-calc.options :decimals="false" :examples="[
        'Mug' => ['start' => 90, 'start-unit' => 'c', 'target' => 60, 'target-unit' => 'c', 'room' => 21, 'room-unit' => 'c', 'vessel' => 'mug', 'after' => '', 'measured' => '', 'measured-unit' => 'c'],
        'Soup pot' => ['start' => 95, 'start-unit' => 'c', 'target' => 30, 'target-unit' => 'c', 'room' => 21, 'room-unit' => 'c', 'vessel' => 'pot', 'after' => '', 'measured' => '', 'measured-unit' => 'c'],
        'Fitted reading' => ['start' => 200, 'start-unit' => 'f', 'target' => 140, 'target-unit' => 'f', 'room' => 70, 'room-unit' => 'f', 'vessel' => 'mug', 'after' => 10, 'measured' => 170, 'measured-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Temperature" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'minutes' => ['label' => 'Minutes'],
            'after30' => ['label' => 'After 30 minutes'],
            'drink' => ['label' => 'Drinking'],
            'food' => ['label' => 'Food safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T(t) = T_room + (T₀ − T_room) e^(−t/τ)</li>
            <li>τ = t ÷ ln((T₀ − T_room) ÷ (T − T_room))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
