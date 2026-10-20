<x-calc.page
    title="Pool Table Room Size Calculator - SolveKit"
    description="Free pool table room size calculator: the room needed for a table and cue."
    lede="Find the room size for a pool table."
    about="You need a cue length of clear space beyond each side of the playing surface."
    :calc="['engine' => 'sp-misc', 'tool' => 'pool_room', 'fields' => ['table', 'cue', 'out'], 'unitFields' => ['cue' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long a room for an 8 ft table?', 'answer' => '17 ft.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="table" label="Table" :options="['7' => '7 ft (playing surface 39 × 78 in)', '8' => '8 ft (44 × 88 in)', '9' => '9 ft (50 × 100 in)']" selected="8" />
        <x-calc.field name="cue" label="Cue length" value="58" placeholder="Cue length">
            <label for="calc-cue-unit" class="sr-only">Cue length unit</label>
            <select id="calc-cue-unit" name="cue-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="ft" />
    </div>

    <x-calc.result label="Minimum room length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ft', 'table' => '8', 'cue' => 58, 'cue-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'width' => ['label' => 'Minimum room width'],
            'shorter' => ['label' => 'With a 52 in cue'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
