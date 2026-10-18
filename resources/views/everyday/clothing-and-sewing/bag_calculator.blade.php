<x-calc.page
    title="Bag Calculator - SolveKit"
    description="Free bag calculator: fabric pieces and yardage to sew a tote bag with boxed corners, handles and an optional lining."
    lede="Work out the fabric to sew a tote bag."
    about="Each panel is the finished width + depth + seam allowances wide, and the finished height + half the depth + bottom seam + top hem tall. Cutting squares half the depth from the bottom corners and sewing them flat makes a boxed base. Handles are cut four times their finished width and folded in four."
    :calc="['engine' => 'ev-clothing', 'tool' => 'bag', 'fields' => ['width', 'height', 'depth', 'seam', 'hem', 'fabric', 'handle_length', 'handle_width', 'lining'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'seam' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'hem' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'handle_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'handle_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the finished bag size', 'text' => 'Width, height and depth.'],
        ['name' => 'Enter allowances and fabric width', 'text' => 'And handle size.'],
    ]"
    :faqs="[
        ['question' => 'How much fabric for a tote bag?', 'answer' => 'About 1¼ yd of 44 in fabric for a 14 × 16 × 4 in unlined tote with 24 in handles, in this simple layout.'],
        ['question' => 'How do boxed corners work?', 'answer' => 'Cut a square of half the depth from each bottom corner, then pinch and sew across.'],
        ['question' => 'How wide should handle strips be?', 'answer' => 'Four times the finished width, folded in quarters.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Finished width" value="14" min="0" placeholder="Finished width">
            <label for="calc-width-unit" class="sr-only">Finished width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Finished height" value="16" min="0" placeholder="Finished height">
            <label for="calc-height-unit" class="sr-only">Finished height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Depth (gusset)" value="4" min="0" placeholder="Depth (gusset)">
            <label for="calc-depth-unit" class="sr-only">Depth (gusset) unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="seam" label="Seam allowance" value="0.5" min="0" placeholder="Seam allowance">
            <label for="calc-seam-unit" class="sr-only">Seam allowance unit</label>
            <select id="calc-seam-unit" name="seam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hem" label="Top hem" value="1.5" min="0" placeholder="Top hem">
            <label for="calc-hem-unit" class="sr-only">Top hem unit</label>
            <select id="calc-hem-unit" name="hem-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fabric" label="Fabric width" value="44" min="0" placeholder="Fabric width">
            <label for="calc-fabric-unit" class="sr-only">Fabric width unit</label>
            <select id="calc-fabric-unit" name="fabric-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="handle_length" label="Handle length" value="24" min="0" placeholder="Handle length">
            <label for="calc-handle_length-unit" class="sr-only">Handle length unit</label>
            <select id="calc-handle_length-unit" name="handle_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="handle_width" label="Handle finished width" value="1" min="0" placeholder="Handle finished width">
            <label for="calc-handle_width-unit" class="sr-only">Handle finished width unit</label>
            <select id="calc-handle_width-unit" name="handle_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.checkbox name="lining" label="Lined" :checked="false" />
    </div>

    <x-calc.result label="Fabric needed" />

    <x-calc.options :examples="[
        '14 × 16 × 4 in tote' => ['width' => 14, 'width-unit' => 'in', 'height' => 16, 'height-unit' => 'in', 'depth' => 4, 'depth-unit' => 'in', 'seam' => 0.5, 'seam-unit' => 'in', 'hem' => 1.5, 'hem-unit' => 'in', 'fabric' => 44, 'fabric-unit' => 'in', 'handle_length' => 24, 'handle_length-unit' => 'in', 'handle_width' => 1, 'handle_width-unit' => 'in', 'lining' => false],
        'Lined, metric' => ['width' => 35, 'width-unit' => 'cm', 'height' => 40, 'height-unit' => 'cm', 'depth' => 10, 'depth-unit' => 'cm', 'seam' => 1, 'seam-unit' => 'cm', 'hem' => 3, 'hem-unit' => 'cm', 'fabric' => 140, 'fabric-unit' => 'cm', 'handle_length' => 60, 'handle_length-unit' => 'cm', 'handle_width' => 3, 'handle_width-unit' => 'cm', 'lining' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'panel' => ['label' => 'Panels'],
            'handles' => ['label' => 'Handles'],
            'corners' => ['label' => 'Boxed corners'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>panel = (W + D + 2s) × (H + D/2 + s + hem)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
