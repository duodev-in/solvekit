<x-calc.page
    title="Quilt Binding Calculator - SolveKit"
    description="Free quilt binding calculator: how many binding strips to cut and the fabric needed to bind a quilt."
    lede="Work out the binding strips and fabric for a quilt."
    about="Binding length = the quilt's perimeter + about 10 in for corners and joining. Strips are cut across the fabric width; joining them on the diagonal uses about one strip width each, so usable length per strip = fabric width − strip width. 2½ in strips are the most common for double-fold binding."
    :calc="['engine' => 'ev-clothing', 'tool' => 'binding', 'fields' => ['width', 'length', 'strip', 'fabric'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'strip' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the quilt size', 'text' => 'Finished size.'],
        ['name' => 'Choose the strip width', 'text' => 'And the fabric width.'],
    ]"
    :faqs="[
        ['question' => 'How much binding for a 60 × 72 in quilt?', 'answer' => '7 strips of 2½ in: about ½ yd.'],
        ['question' => 'How long should binding be?', 'answer' => 'The perimeter plus about 10 in.'],
        ['question' => 'Why join on the diagonal?', 'answer' => 'It spreads the bulk of the seam.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Quilt width" value="60" min="0" placeholder="Quilt width">
            <label for="calc-width-unit" class="sr-only">Quilt width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Quilt length" value="72" min="0" placeholder="Quilt length">
            <label for="calc-length-unit" class="sr-only">Quilt length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="strip" label="Strip width" value="2.5" min="0" placeholder="Strip width">
            <label for="calc-strip-unit" class="sr-only">Strip width unit</label>
            <select id="calc-strip-unit" name="strip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fabric" label="Usable fabric width" value="42" min="0" placeholder="Usable fabric width">
            <label for="calc-fabric-unit" class="sr-only">Usable fabric width unit</label>
            <select id="calc-fabric-unit" name="fabric-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Strips" />

    <x-calc.options :examples="[
        '60 × 72 in' => ['width' => 60, 'width-unit' => 'in', 'length' => 72, 'length-unit' => 'in', 'strip' => 2.5, 'strip-unit' => 'in', 'fabric' => 42, 'fabric-unit' => 'in'],
        'King 108 × 108' => ['width' => 108, 'width-unit' => 'in', 'length' => 108, 'length-unit' => 'in', 'strip' => 2.25, 'strip-unit' => 'in', 'fabric' => 42, 'fabric-unit' => 'in'],
        'Metric' => ['width' => 150, 'width-unit' => 'cm', 'length' => 200, 'length-unit' => 'cm', 'strip' => 6, 'strip-unit' => 'cm', 'fabric' => 107, 'fabric-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fabric' => ['label' => 'Fabric'],
            'joins' => ['label' => 'Joins'],
            'note' => ['label' => 'Width'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>length = perimeter + 10 in</li>
            <li>strips = ⌈length ÷ (WOF − strip width)⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
