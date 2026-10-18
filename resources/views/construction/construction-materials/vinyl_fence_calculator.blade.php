<x-calc.page
    title="Vinyl Fence Calculator - SolveKit"
    description="Free vinyl fence calculator: panels, posts, caps and post concrete for a vinyl fence run with gates."
    lede="Work out the vinyl fence panels, posts and concrete."
    about="Vinyl fence panels come in fixed widths measured post center to post center (commonly 6 or 8 ft). Panels = (length − gates) ÷ panel width; posts = panels + 1 + one per gate, each with a cap."
    :calc="['engine' => 'con-framing', 'tool' => 'vinyl_fence', 'fields' => ['length', 'panel', 'gates', 'gate_width', 'price', 'hole', 'depth', 'post'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'panel' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'gate_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'hole' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'post' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the length and panel width', 'text' => 'Panel width is post center to center.'],
        ['name' => 'Add gates and holes', 'text' => 'For posts and concrete.'],
    ]"
    :faqs="[
        ['question' => 'How many vinyl panels for 120 ft?', 'answer' => 'With 8 ft panels and a 4 ft gate: 15 panels and 17 posts.'],
        ['question' => 'How big are vinyl fence posts?', 'answer' => 'Usually 4 × 4 or 5 × 5 in.'],
        ['question' => 'Do vinyl posts need concrete?', 'answer' => 'Most makers call for concrete-set posts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Fence length" value="120" min="0" placeholder="Fence length">
            <label for="calc-length-unit" class="sr-only">Fence length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="panel" label="Panel width (on center)" value="8" min="0" placeholder="Panel width (on center)">
            <label for="calc-panel-unit" class="sr-only">Panel width (on center) unit</label>
            <select id="calc-panel-unit" name="panel-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gates" label="Gates" value="1" min="0" step="1" />
        <x-calc.field name="gate_width" label="Gate width" value="4" min="0" placeholder="Gate width">
            <label for="calc-gate_width-unit" class="sr-only">Gate width unit</label>
            <select id="calc-gate_width-unit" name="gate_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per panel (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hole" label="Hole diameter" value="10" min="0" placeholder="Hole diameter">
            <label for="calc-hole-unit" class="sr-only">Hole diameter unit</label>
            <select id="calc-hole-unit" name="hole-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Hole depth" value="30" min="0" placeholder="Hole depth">
            <label for="calc-depth-unit" class="sr-only">Hole depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="post" label="Post width" value="5" min="0" placeholder="Post width">
            <label for="calc-post-unit" class="sr-only">Post width unit</label>
            <select id="calc-post-unit" name="post-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Fence panels" />

    <x-calc.options :examples="[
        '120 ft, 8 ft panels' => ['length' => 120, 'length-unit' => 'ft', 'panel' => 8, 'panel-unit' => 'ft', 'gates' => 1, 'gate_width' => 4, 'gate_width-unit' => 'ft', 'hole' => 10, 'hole-unit' => 'in', 'depth' => 30, 'depth-unit' => 'in', 'post' => 5, 'post-unit' => 'in'],
        '6 ft panels, two gates' => ['length' => 90, 'length-unit' => 'ft', 'panel' => 6, 'panel-unit' => 'ft', 'gates' => 2, 'gate_width' => 5, 'gate_width-unit' => 'ft', 'hole' => 10, 'hole-unit' => 'in', 'depth' => 30, 'depth-unit' => 'in', 'post' => 4, 'post-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'posts' => ['label' => 'Posts and caps'],
            'gates' => ['label' => 'Gates'],
            'concrete' => ['label' => 'Concrete'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>panels = ⌈(length − gates) ÷ panel⌉</li>
            <li>posts = panels + 1 + gates</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
