<x-calc.page
    title="Fish Weight Calculator - SolveKit"
    description="Free fish weight calculator: estimate weight from length and girth."
    lede="Estimate a fish’s weight."
    about="Anglers estimate weight from length and girth: length × girth² ÷ 800 (inches to pounds) for most fish."
    :calc="['engine' => 'sp-misc', 'tool' => 'fish_weight', 'fields' => ['L', 'G', 'shape', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'G' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 24 in fish with a 14 in girth weigh?', 'answer' => 'About 5.88 lb.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Length" value="24" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="G" label="Girth" value="14" placeholder="Girth">
            <label for="calc-G-unit" class="sr-only">Girth unit</label>
            <select id="calc-G-unit" name="G-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="shape" label="Shape" :options="['800' => 'Most fish (length × girth² ÷ 800)', '900' => 'Slender fish such as pike, musky (÷ 900)', '1200' => 'Bass (length × girth² ÷ 1,200)']" selected="800" />
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="lb" />
    </div>

    <x-calc.result label="Estimated weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lb', 'L' => 24, 'L-unit' => 'in', 'G' => 14, 'G-unit' => 'in', 'shape' => '800'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Accuracy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
