<x-calc.page
    title="Quilt Calculator - SolveKit"
    description="Free quilt calculator: blocks across and down, finished quilt size with sashing and borders, backing yardage and batting size."
    lede="Plan a quilt: blocks, borders, backing and batting."
    about="Blocks across = (quilt width − borders) ÷ (block + sashing), rounded to the nearest whole block, and the same down. The finished size then adds sashing between and around the blocks and the borders. Backing and batting are cut 4 inches larger all round; backing is pieced from fabric widths (about 42 in usable)."
    :calc="['engine' => 'ev-clothing', 'tool' => 'quilt', 'fields' => ['width', 'length', 'block', 'sashing', 'border', 'fabric'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'block' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'sashing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'border' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the size you want', 'text' => 'For a bed or throw.'],
        ['name' => 'Enter block, sashing and borders', 'text' => 'Finished sizes.'],
    ]"
    :faqs="[
        ['question' => 'How many 12 in blocks for a 60 × 80 in quilt?', 'answer' => '4 × 5 = 20 blocks with 2 in sashing and 4 in borders.'],
        ['question' => 'How much backing?', 'answer' => 'About 5 yd of 42 in fabric for that quilt (two widths).'],
        ['question' => 'How big is a twin quilt?', 'answer' => 'About 70 × 90 in, depending on drop.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Target quilt width" value="60" min="0" placeholder="Target quilt width">
            <label for="calc-width-unit" class="sr-only">Target quilt width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Target quilt length" value="80" min="0" placeholder="Target quilt length">
            <label for="calc-length-unit" class="sr-only">Target quilt length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="block" label="Finished block" value="12" min="0" placeholder="Finished block">
            <label for="calc-block-unit" class="sr-only">Finished block unit</label>
            <select id="calc-block-unit" name="block-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sashing" label="Sashing width" value="2" min="0" placeholder="Sashing width">
            <label for="calc-sashing-unit" class="sr-only">Sashing width unit</label>
            <select id="calc-sashing-unit" name="sashing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="border" label="Border width" value="4" min="0" placeholder="Border width">
            <label for="calc-border-unit" class="sr-only">Border width unit</label>
            <select id="calc-border-unit" name="border-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fabric" label="Backing fabric width" value="42" min="0" placeholder="Backing fabric width">
            <label for="calc-fabric-unit" class="sr-only">Backing fabric width unit</label>
            <select id="calc-fabric-unit" name="fabric-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Blocks" />

    <x-calc.options :examples="[
        'Throw 60 × 80' => ['width' => 60, 'width-unit' => 'in', 'length' => 80, 'length-unit' => 'in', 'block' => 12, 'block-unit' => 'in', 'sashing' => 2, 'sashing-unit' => 'in', 'border' => 4, 'border-unit' => 'in', 'fabric' => 42, 'fabric-unit' => 'in'],
        'Queen, no sashing' => ['width' => 90, 'width-unit' => 'in', 'length' => 96, 'length-unit' => 'in', 'block' => 10, 'block-unit' => 'in', 'sashing' => 0, 'sashing-unit' => 'in', 'border' => 5, 'border-unit' => 'in', 'fabric' => 108, 'fabric-unit' => 'in'],
        'Baby quilt' => ['width' => 36, 'width-unit' => 'in', 'length' => 48, 'length-unit' => 'in', 'block' => 6, 'block-unit' => 'in', 'sashing' => 1, 'sashing-unit' => 'in', 'border' => 3, 'border-unit' => 'in', 'fabric' => 42, 'fabric-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'backing' => ['label' => 'Backing'],
            'batting' => ['label' => 'Batting'],
            'metric' => ['label' => 'Metric'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>blocks = round((size − 2 × border) ÷ (block + sashing))</li>
            <li>backing = quilt + 8 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
