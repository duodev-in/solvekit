<x-calc.page
    title="Livestock Fence Cost Calculator - SolveKit"
    description="Free livestock fence cost calculator: wire, posts, gates and labour for barbed, high-tensile or electric fencing."
    lede="Estimate the cost of a wire fence for livestock."
    about="The cost adds wire (length × strands), posts (length ÷ spacing, plus one), gates and labour. Prices change a lot by region and material; the defaults are examples only, so enter your supplier's prices."
    :calc="['engine' => 'livestock', 'tool' => 'fence_cost', 'fields' => ['perimeter', 'strands', 'spacing', 'wire_price', 'post_price', 'labour', 'gates', 'gate_price'], 'unitFields' => ['perimeter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'spacing' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the length', 'text' => 'The perimeter to fence.'],
        ['name' => 'Set strands and spacing', 'text' => 'For your fence type.'],
        ['name' => 'Enter prices', 'text' => 'From your supplier.'],
    ]"
    :faqs="[
        ['question' => 'How many strands for cattle?', 'answer' => '4 to 5 barbed or high-tensile strands; 1 to 2 for electric on gentle cattle.'],
        ['question' => 'How far apart are posts?', 'answer' => 'About 10 to 15 ft for barbed wire, up to 50 ft or more for high-tensile with stays.'],
        ['question' => 'Do I need corner braces?', 'answer' => 'Yes, corners, ends and gates need braced posts, which cost extra.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="perimeter" label="Fence length" value="2640" min="0" placeholder="Fence length">
            <label for="calc-perimeter-unit" class="sr-only">Fence length unit</label>
            <select id="calc-perimeter-unit" name="perimeter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="strands" label="Wire strands" value="4" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spacing" label="Post spacing" value="12" min="0" placeholder="Post spacing">
            <label for="calc-spacing-unit" class="sr-only">Post spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="wire_price" label="Wire price per ft" value="0.06" min="0" suffix="$" help="Example price" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="post_price" label="Price per post" value="8" min="0" suffix="$" />
        <x-calc.field name="labour" label="Labour per ft (optional)" value="0" min="0" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gates" label="Gates" value="1" min="0" step="1" />
        <x-calc.field name="gate_price" label="Price per gate" value="200" min="0" suffix="$" />
    </div>

    <x-calc.result label="Estimated cost" />

    <x-calc.options :examples="[
        'Half-mile barbed' => ['perimeter' => 2640, 'perimeter-unit' => 'ft', 'strands' => 4, 'spacing' => 12, 'spacing-unit' => 'ft', 'wire_price' => 0.06, 'post_price' => 8, 'gates' => 1, 'gate_price' => 200, 'labour' => 0],
        '1 km electric' => ['perimeter' => 1000, 'perimeter-unit' => 'm', 'strands' => 2, 'spacing' => 15, 'spacing-unit' => 'm', 'wire_price' => 0.03, 'post_price' => 4, 'gates' => 2, 'gate_price' => 40, 'labour' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'wire' => ['label' => 'Wire'],
            'posts' => ['label' => 'Posts'],
            'gates' => ['label' => 'Gates'],
            'labour' => ['label' => 'Labour'],
            'per_foot' => ['label' => 'Per foot'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>wire = length × strands</li>
            <li>posts = ⌈length ÷ spacing⌉ + 1</li>
            <li>total = wire + posts + gates + labour</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
