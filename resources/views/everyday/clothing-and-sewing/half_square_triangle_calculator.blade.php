<x-calc.page
    title="Half Square Triangle Calculator - SolveKit"
    description="Free half square triangle calculator: the size of squares to cut for HST quilt blocks by the 2-at-a-time or 8-at-a-time method, and how many to cut."
    lede="Work out what size squares to cut for half square triangles."
    about="For 2 HSTs at a time, cut squares the finished size + ⅞ in, sew ¼ in either side of the diagonal and cut apart. For 8 at a time, cut squares 2 × (finished + ⅞ in), sew ¼ in around both diagonals and cut twice across and on both diagonals. Adding ⅛ in (or more) lets you trim the units to an exact size."
    :calc="['engine' => 'ev-clothing', 'tool' => 'hst', 'fields' => ['finished', 'count', 'method', 'trim', 'wof'], 'unitFields' => ['finished' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'wof' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the finished size and count', 'text' => 'From your pattern.'],
        ['name' => 'Pick a method', 'text' => 'And whether to trim.'],
    ]"
    :faqs="[
        ['question' => 'What size square for a 3 in finished HST?', 'answer' => '3⅞ in for 2 at a time.'],
        ['question' => 'What size square for 8 at a time?', 'answer' => '7¾ in for 3 in finished HSTs.'],
        ['question' => 'Why add ⅞ in?', 'answer' => 'It covers the two ¼ in seams and the diagonal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="finished" label="Finished HST size" value="3" min="0" placeholder="Finished HST size">
            <label for="calc-finished-unit" class="sr-only">Finished HST size unit</label>
            <select id="calc-finished-unit" name="finished-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="HSTs needed" value="48" min="1" step="1" />
        <x-calc.segmented name="method" legend="Method" :options="['two' => '2 at a time', 'eight' => '8 at a time']" selected="two" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="trim" label="Add ⅛ in to trim" :checked="false" />
        <x-calc.field name="wof" label="Usable fabric width" value="42" min="0" placeholder="Usable fabric width">
            <label for="calc-wof-unit" class="sr-only">Usable fabric width unit</label>
            <select id="calc-wof-unit" name="wof-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Cut squares" />

    <x-calc.options :examples="[
        '48 HSTs, 3 in, 2-at-a-time' => ['finished' => 3, 'finished-unit' => 'in', 'count' => 48, 'method' => 'two', 'trim' => false, 'wof' => 42, 'wof-unit' => 'in'],
        '8 at a time, trim' => ['finished' => 3, 'finished-unit' => 'in', 'count' => 64, 'method' => 'eight', 'trim' => true, 'wof' => 42, 'wof-unit' => 'in'],
        '2 in units' => ['finished' => 2, 'finished-unit' => 'in', 'count' => 100, 'method' => 'two', 'trim' => true, 'wof' => 42, 'wof-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'squares' => ['label' => 'Squares'],
            'strips' => ['label' => 'Strips'],
            'unfinished' => ['label' => 'Unfinished size'],
            'metric' => ['label' => 'Metric'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>2 at a time: finished + ⅞ in</li>
            <li>8 at a time: 2 × (finished + ⅞ in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
