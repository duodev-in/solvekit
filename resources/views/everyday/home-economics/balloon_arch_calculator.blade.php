<x-calc.page
    title="Balloon Arch Calculator - SolveKit"
    description="Free balloon arch calculator: balloons needed for a classic quad-cluster arch or an organic garland from its width and height or length."
    lede="Work out how many balloons an arch or garland needs."
    about="The arch length is half the perimeter of an ellipse with the arch's width and height (Ramanujan's formula). A classic arch uses 4-balloon clusters, about one cluster per balloon diameter of length; an organic garland is usually built at about 15–20 mixed balloons per foot (a decorator's rule of thumb). Add spares for pops."
    :calc="['engine' => 'ev-home', 'tool' => 'balloon_arch', 'fields' => ['shape', 'width', 'height', 'length', 'style', 'size', 'per_foot'], 'unitFields' => ['width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the arch size', 'text' => 'Or the garland length.'],
        ['name' => 'Pick the style', 'text' => 'Classic clusters or organic.'],
    ]"
    :faqs="[
        ['question' => 'How many balloons for a 10 × 8 ft arch?', 'answer' => 'About 92 balloons of 11 inches: 23 clusters of 4.'],
        ['question' => 'How many balloons per foot of garland?', 'answer' => 'About 15–20 for an organic garland.'],
        ['question' => 'How long is an arch?', 'answer' => 'A 10 ft wide, 8 ft tall arch is about 20.7 ft along the curve.'],
    ]"
>
    <x-calc.segmented name="shape" legend="Shape" :options="['arch' => 'Arch', 'garland' => 'Garland']" selected="arch" />

    <div data-show-when="shape:arch">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="width" label="Arch width" value="10" min="0" placeholder="Arch width">
                <label for="calc-width-unit" class="sr-only">Arch width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="height" label="Arch height" value="8" min="0" placeholder="Arch height">
                <label for="calc-height-unit" class="sr-only">Arch height unit</label>
                <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="shape:garland" hidden>
        <x-calc.field name="length" label="Garland length" value="12" min="0" placeholder="Garland length">
            <label for="calc-length-unit" class="sr-only">Garland length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="style" legend="Style" :options="['classic' => 'Classic quad clusters', 'organic' => 'Organic garland']" selected="classic" />

    <div data-show-when="style:classic">
        <x-calc.select name="size" label="Balloon size" :options="['5' => '5 inch', '11' => '11 inch', '16' => '16 inch']" selected="11" />
    </div>

    <div data-show-when="style:organic" hidden>
        <x-calc.field name="per_foot" label="Balloons per foot" value="15" min="1" step="1" />
    </div>

    <x-calc.result label="Balloons needed" />

    <x-calc.options :examples="[
        '10 × 8 ft arch' => ['shape' => 'arch', 'width' => 10, 'width-unit' => 'ft', 'height' => 8, 'height-unit' => 'ft', 'length' => '', 'length-unit' => 'ft', 'style' => 'classic', 'size' => '11', 'per_foot' => ''],
        '12 ft organic garland' => ['shape' => 'garland', 'width' => '', 'width-unit' => 'ft', 'height' => '', 'height-unit' => 'ft', 'length' => 12, 'length-unit' => 'ft', 'style' => 'organic', 'size' => '11', 'per_foot' => 18],
        '3 × 2.5 m arch' => ['shape' => 'arch', 'width' => 3, 'width-unit' => 'm', 'height' => 2.5, 'height-unit' => 'm', 'length' => '', 'length-unit' => 'ft', 'style' => 'classic', 'size' => '11', 'per_foot' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'length' => ['label' => 'Arch length'],
            'spare' => ['label' => 'With spares'],
            'note' => ['label' => 'Basis'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>arch ≈ ½ π (a + b)(1 + 3h ÷ (10 + √(4 − 3h)))</li>
            <li>balloons = 4 × length ÷ balloon size</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
