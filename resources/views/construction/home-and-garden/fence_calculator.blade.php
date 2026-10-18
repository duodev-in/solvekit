<x-calc.page
    title="Fence Calculator - SolveKit"
    description="Free fence calculator: posts, rails, pickets and concrete for a fence run or a rectangle perimeter, with gates."
    lede="Work out the posts, rails, pickets and concrete for a fence."
    about="Sections = fence length less gates ÷ post spacing; a straight run needs one more post than sections, a closed rectangle the same number, and each gate adds a post. Pickets = length ÷ (picket width + gap). This also covers the rectangle fence perimeter: 2 × (length + width)."
    :calc="['engine' => 'con-framing', 'tool' => 'fence', 'fields' => ['layout', 'length', 'side_a', 'side_b', 'spacing', 'rails', 'gates', 'gate_width', 'picket', 'picket_gap', 'hole', 'depth', 'post'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'spacing' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'gate_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'picket' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'picket_gap' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'hole' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'post' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose a run or a rectangle', 'text' => 'And enter the size.'],
        ['name' => 'Set spacing, rails and gates', 'text' => 'And the picket size.'],
        ['name' => 'Enter the post holes', 'text' => 'For the concrete.'],
    ]"
    :faqs="[
        ['question' => 'How many posts for 100 ft of fence?', 'answer' => 'At 8 ft spacing with one 4 ft gate: 12 sections and 14 posts.'],
        ['question' => 'What is the perimeter of a 60 × 40 ft yard?', 'answer' => '200 ft.'],
        ['question' => 'How deep should fence posts be?', 'answer' => 'About a third of the post height above ground and below frost; see the Fence Post Depth Calculator.'],
    ]"
>
    <x-calc.segmented name="layout" legend="Fence" :options="['run' => 'Straight run', 'rectangle' => 'Rectangle (perimeter)']" selected="run" />

    <div data-show-when="layout:run">
        <x-calc.field name="length" label="Fence length" value="100" min="0" placeholder="Fence length">
            <label for="calc-length-unit" class="sr-only">Fence length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="layout:rectangle" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="side_a" label="Length" value="60" min="0" placeholder="Length">
                <label for="calc-side_a-unit" class="sr-only">Length unit</label>
                <select id="calc-side_a-unit" name="side_a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="side_b" label="Width" value="40" min="0" placeholder="Width">
                <label for="calc-side_b-unit" class="sr-only">Width unit</label>
                <select id="calc-side_b-unit" name="side_b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spacing" label="Post spacing" value="8" min="0" placeholder="Post spacing">
            <label for="calc-spacing-unit" class="sr-only">Post spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rails" label="Rails per section" value="2" min="0" step="1" />
        <x-calc.field name="gates" label="Gates" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gate_width" label="Gate width" value="4" min="0" placeholder="Gate width">
            <label for="calc-gate_width-unit" class="sr-only">Gate width unit</label>
            <select id="calc-gate_width-unit" name="gate_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="picket" label="Picket width" value="5.5" min="0" placeholder="Picket width">
            <label for="calc-picket-unit" class="sr-only">Picket width unit</label>
            <select id="calc-picket-unit" name="picket-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="picket_gap" label="Gap between pickets" value="0" min="0" placeholder="Gap between pickets">
            <label for="calc-picket_gap-unit" class="sr-only">Gap between pickets unit</label>
            <select id="calc-picket_gap-unit" name="picket_gap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
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
        <x-calc.field name="depth" label="Hole depth" value="24" min="0" placeholder="Hole depth">
            <label for="calc-depth-unit" class="sr-only">Hole depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="post" label="Post width (actual)" value="3.5" min="0" placeholder="Post width (actual)">
            <label for="calc-post-unit" class="sr-only">Post width (actual) unit</label>
            <select id="calc-post-unit" name="post-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Fence posts" />

    <x-calc.options :examples="[
        '100 ft run, one gate' => ['layout' => 'run', 'length' => 100, 'length-unit' => 'ft', 'spacing' => 8, 'spacing-unit' => 'ft', 'rails' => 2, 'gates' => 1, 'gate_width' => 4, 'gate_width-unit' => 'ft', 'picket' => 5.5, 'picket-unit' => 'in', 'picket_gap' => 0, 'picket_gap-unit' => 'in', 'hole' => 10, 'hole-unit' => 'in', 'depth' => 24, 'depth-unit' => 'in', 'post' => 3.5, 'post-unit' => 'in'],
        'Yard 60 × 40 ft' => ['layout' => 'rectangle', 'side_a' => 60, 'side_a-unit' => 'ft', 'side_b' => 40, 'side_b-unit' => 'ft', 'spacing' => 8, 'spacing-unit' => 'ft', 'rails' => 3, 'gates' => 2, 'gate_width' => 4, 'gate_width-unit' => 'ft', 'picket' => 3.5, 'picket-unit' => 'in', 'picket_gap' => 2, 'picket_gap-unit' => 'in', 'hole' => 10, 'hole-unit' => 'in', 'depth' => 30, 'depth-unit' => 'in', 'post' => 3.5, 'post-unit' => 'in'],
        'Metric 30 m' => ['layout' => 'run', 'length' => 30, 'length-unit' => 'm', 'spacing' => 2.4, 'spacing-unit' => 'm', 'rails' => 2, 'gates' => 0, 'gate_width' => 1, 'gate_width-unit' => 'm', 'picket' => 100, 'picket-unit' => 'mm', 'picket_gap' => 10, 'picket_gap-unit' => 'mm', 'hole' => 300, 'hole-unit' => 'mm', 'depth' => 600, 'depth-unit' => 'mm', 'post' => 90, 'post-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perimeter' => ['label' => 'Fence length'],
            'rails' => ['label' => 'Rails'],
            'pickets' => ['label' => 'Pickets'],
            'concrete' => ['label' => 'Concrete'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sections = ⌈(length − gates) ÷ spacing⌉</li>
            <li>posts = sections + 1 + gates (run) or sections + gates (closed)</li>
            <li>pickets = ⌈length ÷ (picket + gap)⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
