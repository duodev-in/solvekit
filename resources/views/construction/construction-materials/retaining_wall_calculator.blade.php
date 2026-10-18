<x-calc.page
    title="Retaining Wall Calculator - SolveKit"
    description="Free retaining wall calculator: segmental retaining wall blocks, caps, base stone and drainage gravel from the wall length and height."
    lede="Work out the blocks, caps, base and drainage stone for a block retaining wall."
    about="Courses = (exposed height + buried depth) ÷ block height; blocks per course = length ÷ block length. Block makers commonly bury the first course (about 6 in, or 1 in per 8 in of height) on a compacted gravel base about 6 in deep and twice the block depth wide, with free-draining gravel behind the wall. Follow your block maker's guide; walls over 4 ft need an engineered design (IRC R404.4)."
    :calc="['engine' => 'con-concrete', 'tool' => 'retaining_wall', 'fields' => ['length', 'height', 'block_length', 'block_height', 'block_depth', 'buried', 'cap_length', 'base_depth', 'base_extra', 'drain_width', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'block_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'block_height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'block_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'buried' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'cap_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'base_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'base_extra' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'drain_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Enter the wall length and height', 'text' => 'Exposed height above the ground.'],
        ['name' => 'Enter the block size', 'text' => 'From the block maker.'],
        ['name' => 'Set the base and drainage', 'text' => 'From the installation guide.'],
    ]"
    :faqs="[
        ['question' => 'How many blocks for a 40 ft wall 3 ft high?', 'answer' => 'With 12 × 6 in blocks and 6 in buried: 7 courses of 40 blocks, 280 blocks.'],
        ['question' => 'How deep should the base be?', 'answer' => 'About 6 in of compacted crushed stone for most small walls.'],
        ['question' => 'When do I need an engineer?', 'answer' => 'For walls over 4 ft, or walls holding up a slope, driveway or building.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Wall length" value="40" min="0" placeholder="Wall length">
            <label for="calc-length-unit" class="sr-only">Wall length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Exposed height" value="3" min="0" placeholder="Exposed height">
            <label for="calc-height-unit" class="sr-only">Exposed height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="block_length" label="Block length" value="12" min="0" placeholder="Block length">
            <label for="calc-block_length-unit" class="sr-only">Block length unit</label>
            <select id="calc-block_length-unit" name="block_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="block_height" label="Block height" value="6" min="0" placeholder="Block height">
            <label for="calc-block_height-unit" class="sr-only">Block height unit</label>
            <select id="calc-block_height-unit" name="block_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="block_depth" label="Block depth" value="12" min="0" placeholder="Block depth">
            <label for="calc-block_depth-unit" class="sr-only">Block depth unit</label>
            <select id="calc-block_depth-unit" name="block_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="buried" label="Buried depth" value="6" min="0" placeholder="Buried depth">
            <label for="calc-buried-unit" class="sr-only">Buried depth unit</label>
            <select id="calc-buried-unit" name="buried-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cap_length" label="Cap length (optional)" value="12" min="0" placeholder="Cap length (optional)">
            <label for="calc-cap_length-unit" class="sr-only">Cap length (optional) unit</label>
            <select id="calc-cap_length-unit" name="cap_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="base_depth" label="Base stone depth" value="6" min="0" placeholder="Base stone depth">
            <label for="calc-base_depth-unit" class="sr-only">Base stone depth unit</label>
            <select id="calc-base_depth-unit" name="base_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="base_extra" label="Base wider each side" value="6" min="0" placeholder="Base wider each side">
            <label for="calc-base_extra-unit" class="sr-only">Base wider each side unit</label>
            <select id="calc-base_extra-unit" name="base_extra-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="drain_width" label="Drainage gravel width" value="12" min="0" placeholder="Drainage gravel width">
            <label for="calc-drain_width-unit" class="sr-only">Drainage gravel width unit</label>
            <select id="calc-drain_width-unit" name="drain_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per block (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Wall blocks" />

    <x-calc.options :examples="[
        '40 ft × 3 ft garden wall' => ['length' => 40, 'length-unit' => 'ft', 'height' => 3, 'height-unit' => 'ft', 'block_length' => 12, 'block_length-unit' => 'in', 'block_height' => 6, 'block_height-unit' => 'in', 'block_depth' => 12, 'block_depth-unit' => 'in', 'buried' => 6, 'buried-unit' => 'in', 'cap_length' => 12, 'cap_length-unit' => 'in', 'base_depth' => 6, 'base_depth-unit' => 'in', 'base_extra' => 6, 'base_extra-unit' => 'in', 'drain_width' => 12, 'drain_width-unit' => 'in'],
        'Small border 10 m × 0.6 m' => ['length' => 10, 'length-unit' => 'm', 'height' => 0.6, 'height-unit' => 'm', 'block_length' => 300, 'block_length-unit' => 'mm', 'block_height' => 150, 'block_height-unit' => 'mm', 'block_depth' => 250, 'block_depth-unit' => 'mm', 'buried' => 150, 'buried-unit' => 'mm', 'cap_length' => 300, 'cap_length-unit' => 'mm', 'base_depth' => 150, 'base_depth-unit' => 'mm', 'base_extra' => 150, 'base_extra-unit' => 'mm', 'drain_width' => 300, 'drain_width-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'courses' => ['label' => 'Courses'],
            'caps' => ['label' => 'Caps'],
            'base' => ['label' => 'Base stone'],
            'drain' => ['label' => 'Drainage gravel'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>courses = ⌈(height + buried) ÷ block height⌉</li>
            <li>blocks = courses × ⌈length ÷ block length⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
