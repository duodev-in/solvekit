<x-calc.page
    title="Hole Volume Calculator - SolveKit"
    description="Free hole volume calculator: volume of round post holes and the concrete to fill them around a round or square post."
    lede="Work out the volume of post holes and the concrete to set posts."
    about="A round hole holds π ÷ 4 × D² × depth. The post takes up part of it: subtract its volume to get the concrete. Many builders set posts in holes three times the post width."
    :calc="['engine' => 'con-concrete', 'tool' => 'hole_volume', 'fields' => ['diameter', 'depth', 'count', 'post', 'post_size', 'waste', 'price'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'post_size' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Enter the hole size', 'text' => 'Diameter and depth.'],
        ['name' => 'Choose the post', 'text' => 'Its actual size: a 4×4 is 3½ in.'],
    ]"
    :faqs="[
        ['question' => 'How much concrete for a fence post?', 'answer' => 'A 10 in hole 30 in deep around a 4×4 needs about 1.1 ft³, two 80 lb bags.'],
        ['question' => 'How big should a post hole be?', 'answer' => 'About three times the post width.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diameter" label="Hole diameter" value="10" min="0" placeholder="Hole diameter">
            <label for="calc-diameter-unit" class="sr-only">Hole diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
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
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="Holes" value="10" min="1" step="1" />
        <x-calc.select name="post" label="Post" :options="['none' => 'No post (fill the hole)', 'square' => 'Square post', 'round' => 'Round post']" selected="square" />
    </div>

    <div data-show-when="post:square,round">
        <x-calc.field name="post_size" label="Post size (actual)" value="3.5" min="0" placeholder="Post size (actual)">
            <label for="calc-post_size-unit" class="sr-only">Post size (actual) unit</label>
            <select id="calc-post_size-unit" name="post_size-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per yd³ (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Concrete for the holes" />

    <x-calc.options :examples="[
        '10 holes, 4×4 posts' => ['diameter' => 10, 'diameter-unit' => 'in', 'depth' => 30, 'depth-unit' => 'in', 'count' => 10, 'post' => 'square', 'post_size' => 3.5, 'post_size-unit' => 'in', 'waste' => 5],
        'Deck piers 12 in, no post' => ['diameter' => 12, 'diameter-unit' => 'in', 'depth' => 48, 'depth-unit' => 'in', 'count' => 6, 'post' => 'none', 'waste' => 5],
        'Round posts 150 mm' => ['diameter' => 300, 'diameter-unit' => 'mm', 'depth' => 800, 'depth-unit' => 'mm', 'count' => 8, 'post' => 'round', 'post_size' => 150, 'post_size-unit' => 'mm', 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm3' => ['label' => 'Cubic meters'],
            'ft3' => ['label' => 'Cubic feet'],
            'bags_80' => ['label' => '80 lb bags'],
            'bags_60' => ['label' => '60 lb bags'],
            'bags_50' => ['label' => '50 lb bags'],
            'bags_40' => ['label' => '40 lb bags'],
            'weight' => ['label' => 'Weight'],
            'cost' => ['label' => 'Cost'],
            'hole' => ['label' => 'Holes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = (π ÷ 4 × D² − post area) × depth × holes</li>
            <li>1 yd³ = 27 ft³ = 0.7646 m³</li>
            <li>premix yields: 80 lb = 0.60 ft³, 60 lb = 0.45 ft³, 40 lb = 0.30 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
