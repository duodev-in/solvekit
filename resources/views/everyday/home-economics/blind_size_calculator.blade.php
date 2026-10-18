<x-calc.page
    title="Blind Size Calculator - SolveKit"
    description="Free blind size calculator: the size of blinds to order for an inside-mount or outside-mount window."
    lede="Work out what size blinds to order."
    about="For an inside mount, measure the opening in three places and order the narrowest width and the longest height; the maker takes off a small clearance so the blind fits. For an outside mount, add about 1½–3 inches each side for overlap and room above for the headrail. Always follow the maker's measuring guide."
    :calc="['engine' => 'ev-home', 'tool' => 'blind_size', 'fields' => ['mount', 'width', 'height', 'overlap', 'top'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'overlap' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'top' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose inside or outside mount', 'text' => 'Inside sits in the frame.'],
        ['name' => 'Enter the opening', 'text' => 'Narrowest width, longest height.'],
    ]"
    :faqs="[
        ['question' => 'Do I deduct for an inside mount?', 'answer' => 'No, give the exact opening; the maker deducts.'],
        ['question' => 'How much overlap for outside mount?', 'answer' => 'About 1½–3 inches each side.'],
        ['question' => 'Which way round is width × height?', 'answer' => 'Width is always first.'],
    ]"
>
    <x-calc.segmented name="mount" legend="Mount" :options="['inside' => 'Inside the window', 'outside' => 'Outside (on the wall)']" selected="inside" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Opening width" value="34.5" min="0" placeholder="Opening width">
            <label for="calc-width-unit" class="sr-only">Opening width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Opening height" value="58" min="0" placeholder="Opening height">
            <label for="calc-height-unit" class="sr-only">Opening height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mount:outside" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="overlap" label="Overlap each side" value="1.5" min="0" placeholder="Overlap each side">
                <label for="calc-overlap-unit" class="sr-only">Overlap each side unit</label>
                <select id="calc-overlap-unit" name="overlap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="top" label="Space above for headrail" value="3" min="0" placeholder="Space above for headrail">
                <label for="calc-top-unit" class="sr-only">Space above for headrail unit</label>
                <select id="calc-top-unit" name="top-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Order size" />

    <x-calc.options :examples="[
        'Inside 34½ × 58 in' => ['mount' => 'inside', 'width' => 34.5, 'width-unit' => 'in', 'height' => 58, 'height-unit' => 'in', 'overlap' => '', 'overlap-unit' => 'in', 'top' => '', 'top-unit' => 'in'],
        'Outside mount' => ['mount' => 'outside', 'width' => 34.5, 'width-unit' => 'in', 'height' => 58, 'height-unit' => 'in', 'overlap' => 2, 'overlap-unit' => 'in', 'top' => 3, 'top-unit' => 'in'],
        'Metric inside' => ['mount' => 'inside', 'width' => 90, 'width-unit' => 'cm', 'height' => 140, 'height-unit' => 'cm', 'overlap' => '', 'overlap-unit' => 'cm', 'top' => '', 'top-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'In cm'],
            'measure' => ['label' => 'How to measure'],
            'depth' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inside: order the opening</li>
            <li>outside: width + 2 × overlap, height + headrail + overlap</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
