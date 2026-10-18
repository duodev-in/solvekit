<x-calc.page
    title="Stair Calculator - SolveKit"
    description="Free stair calculator: number of risers and treads, riser height, total run, stringer length and angle, checked against IRC or IBC limits."
    lede="Work out the risers, treads and stringer for a staircase."
    about="Risers = total rise ÷ maximum riser, rounded up; each riser is the rise divided equally. There is one fewer tread than risers. IRC R311.7.5 limits residential risers to 7¾ in and treads to at least 10 in; IBC 1011.5.2 uses 7 in and 11 in. The 2R + T comfort rule (24–25 in) is a convention, not code."
    :calc="['engine' => 'con-framing', 'tool' => 'stair', 'fields' => ['rise', 'code', 'max_riser', 'tread'], 'unitFields' => ['rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'max_riser' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tread' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the total rise', 'text' => 'Finished floor to finished floor.'],
        ['name' => 'Set the largest riser and tread', 'text' => 'From your code.'],
    ]"
    :faqs="[
        ['question' => 'How many steps for a 9 ft rise?', 'answer' => '14 risers of 7.71 in with the IRC limit of 7¾ in.'],
        ['question' => 'What is the maximum stair riser?', 'answer' => '7¾ in in homes (IRC), 7 in in other buildings (IBC).'],
        ['question' => 'How long is the stringer?', 'answer' => 'About the hypotenuse of the total rise and the run plus one tread.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rise" label="Total rise (floor to floor)" value="108" min="0" placeholder="Total rise (floor to floor)">
            <label for="calc-rise-unit" class="sr-only">Total rise (floor to floor) unit</label>
            <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="code" label="Code" :options="['irc' => 'IRC (homes)', 'ibc' => 'IBC (other buildings)']" selected="irc" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="max_riser" label="Largest riser" value="7.75" min="0" placeholder="Largest riser">
            <label for="calc-max_riser-unit" class="sr-only">Largest riser unit</label>
            <select id="calc-max_riser-unit" name="max_riser-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="tread" label="Tread depth (run)" value="10" min="0" placeholder="Tread depth (run)">
            <label for="calc-tread-unit" class="sr-only">Tread depth (run) unit</label>
            <select id="calc-tread-unit" name="tread-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Steps" />

    <x-calc.options :examples="[
        'House stair 9 ft' => ['rise' => 108, 'rise-unit' => 'in', 'code' => 'irc', 'max_riser' => 7.75, 'max_riser-unit' => 'in', 'tread' => 10, 'tread-unit' => 'in'],
        'Commercial 12 ft' => ['rise' => 144, 'rise-unit' => 'in', 'code' => 'ibc', 'max_riser' => 7, 'max_riser-unit' => 'in', 'tread' => 11, 'tread-unit' => 'in'],
        'Deck steps 30 in' => ['rise' => 30, 'rise-unit' => 'in', 'code' => 'irc', 'max_riser' => 7.75, 'max_riser-unit' => 'in', 'tread' => 11, 'tread-unit' => 'in'],
        'Metric 2.8 m' => ['rise' => 2.8, 'rise-unit' => 'm', 'code' => 'irc', 'max_riser' => 190, 'max_riser-unit' => 'mm', 'tread' => 260, 'tread-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'riser' => ['label' => 'Riser height'],
            'run' => ['label' => 'Total run'],
            'stringer' => ['label' => 'Stringer'],
            'angle' => ['label' => 'Angle'],
            'comfort' => ['label' => 'Comfort'],
            'code' => ['label' => 'Code check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>risers = ⌈rise ÷ max riser⌉</li>
            <li>treads = risers − 1</li>
            <li>run = treads × tread</li>
            <li>stringer = √(rise² + (run + tread)²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
