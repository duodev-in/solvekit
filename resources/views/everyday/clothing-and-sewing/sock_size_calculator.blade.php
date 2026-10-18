<x-calc.page
    title="Sock Size Calculator - SolveKit"
    description="Free sock size calculator: sock size from foot length or shoe size, with the matching shoe sizes."
    lede="Find your sock size."
    about="Traditional sock sizes are the foot length in inches, rounded to a half size: a 10 in foot takes size 10 socks. Packs are usually sold for a range, such as 10–13. Letter sizes (S, M, L) are each brand's range of shoe sizes, so check the pack."
    :calc="['engine' => 'ev-clothing', 'tool' => 'socks', 'fields' => ['from', 'foot', 'size'], 'unitFields' => ['foot' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter shoe size or foot length', 'text' => 'Either works.'],
    ]"
    :faqs="[
        ['question' => 'What sock size for a US men\'s 10 shoe?', 'answer' => 'About 10.5–11.'],
        ['question' => 'How are socks sized?', 'answer' => 'By foot length in inches.'],
        ['question' => 'What does 10–13 mean on a pack?', 'answer' => 'The sock sizes, or foot lengths in inches, it stretches to fit.'],
    ]"
>
    <x-calc.select name="from" label="I know" :options="['length' => 'Foot length', 'us_men' => 'US men\'s size', 'us_women' => 'US women\'s size', 'uk' => 'UK size', 'eu' => 'EU size', 'mondo' => 'Mondopoint (mm)']" selected="us_men" />

    <div data-show-when="from:length" hidden>
        <x-calc.field name="foot" label="Foot length" value="26.5" min="0" placeholder="Foot length">
            <label for="calc-foot-unit" class="sr-only">Foot length unit</label>
            <select id="calc-foot-unit" name="foot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="from:us_men,us_women,uk,eu,mondo">
        <x-calc.field name="size" label="Shoe size" value="10" min="0" step="0.5" />
    </div>

    <x-calc.result label="Sock size" />

    <x-calc.options :decimals="false" :examples="[
        'US men 10' => ['from' => 'us_men', 'foot' => '', 'foot-unit' => 'cm', 'size' => 10],
        'Foot 24 cm' => ['from' => 'length', 'foot' => 24, 'foot-unit' => 'cm', 'size' => ''],
        'EU 38' => ['from' => 'eu', 'foot' => '', 'foot-unit' => 'cm', 'size' => 38],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'shoe' => ['label' => 'Shoe sizes'],
            'range' => ['label' => 'Pack range'],
            'note' => ['label' => 'Letter sizes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sock size = foot length in inches</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
