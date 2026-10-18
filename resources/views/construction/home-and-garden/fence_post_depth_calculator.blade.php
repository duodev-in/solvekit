<x-calc.page
    title="Fence Post Depth Calculator - SolveKit"
    description="Free fence post depth calculator: post hole depth by the one-third or one-half rule and the frost line, with hole size, post length and concrete."
    lede="Work out how deep to set a fence post."
    about="Common practice buries a third of the post's height above ground (a half for gates, tall or windy fences), never less than 2 ft, and below the local frost line so frost cannot heave it. These are trade conventions, not a structural calculation. Holes are usually three times the post width."
    :calc="['engine' => 'con-framing', 'tool' => 'post_depth', 'fields' => ['height', 'post', 'rule', 'frost', 'below'], 'unitFields' => ['height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'post' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'frost' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'below' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the post height', 'text' => 'Above the ground.'],
        ['name' => 'Enter your frost depth', 'text' => 'From the local building department.'],
    ]"
    :faqs="[
        ['question' => 'How deep for a 6 ft fence post?', 'answer' => 'At least 2 ft (a third of 6 ft), and below the frost line.'],
        ['question' => 'How wide should the hole be?', 'answer' => 'About three times the post width: 10–12 in for a 4×4.'],
        ['question' => 'How long a post for a 6 ft fence?', 'answer' => 'Usually 8 ft, or longer where the frost is deep.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height above ground" value="6" min="0" placeholder="Height above ground">
            <label for="calc-height-unit" class="sr-only">Height above ground unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="rule" label="Rule" :options="['third' => 'One third (most fences)', 'half' => 'One half (gates, tall, windy)']" selected="third" />
        <x-calc.field name="frost" label="Frost depth (optional)" value="30" min="0" placeholder="Frost depth (optional)">
            <label for="calc-frost-unit" class="sr-only">Frost depth (optional) unit</label>
            <select id="calc-frost-unit" name="frost-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="below" label="Extra below frost" value="6" min="0" placeholder="Extra below frost">
            <label for="calc-below-unit" class="sr-only">Extra below frost unit</label>
            <select id="calc-below-unit" name="below-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Post hole depth" />

    <x-calc.options :examples="[
        '6 ft fence, 30 in frost' => ['height' => 6, 'height-unit' => 'ft', 'post' => 3.5, 'post-unit' => 'in', 'rule' => 'third', 'frost' => 30, 'frost-unit' => 'in', 'below' => 6, 'below-unit' => 'in'],
        'Gate post 6 ft' => ['height' => 6, 'height-unit' => 'ft', 'post' => 5.5, 'post-unit' => 'in', 'rule' => 'half', 'frost' => 24, 'frost-unit' => 'in', 'below' => 6, 'below-unit' => 'in'],
        'Warm climate 4 ft' => ['height' => 4, 'height-unit' => 'ft', 'post' => 3.5, 'post-unit' => 'in', 'rule' => 'third', 'frost' => '', 'below' => 0, 'below-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rule' => ['label' => 'By the rule'],
            'frost' => ['label' => 'By frost'],
            'hole' => ['label' => 'Hole diameter'],
            'post' => ['label' => 'Post length'],
            'concrete' => ['label' => 'Concrete'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>depth = max(height × ⅓ or ½, frost + extra, 2 ft)</li>
            <li>hole = 3 × post width</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
