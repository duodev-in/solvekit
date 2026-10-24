<x-calc.page
    title="Projector Calculator - SolveKit"
    description="Free projector throw distance calculator: distance for an image size, or image size at a distance."
    lede="Place a projector."
    about="A projector’s throw ratio links its distance from the screen to the width of the picture."
    :calc="['engine' => 'tc-photo', 'tool' => 'projector', 'fields' => ['throw', 'solve', 'width', 'distance', 'aspect'], 'unitFields' => ['width' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'distance' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How far back for a 2.5 m wide image at 1.5:1?', 'answer' => '3.75 m (12.3 ft).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="throw" label="Throw ratio (distance ÷ image width)" value="1.5" min="0" step="any" />
        <x-calc.select name="solve" label="Find" :options="['distance' => 'Distance for an image width', 'width' => 'Image size at a distance']" selected="distance" />
        <div data-show-when="solve:distance">
            <x-calc.field name="width" label="Image width" value="2.5" placeholder="Image width">
                <label for="calc-width-unit" class="sr-only">Image width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:width">
            <x-calc.field name="distance" label="Distance from the screen" value="3.5" placeholder="Distance from the screen">
                <label for="calc-distance-unit" class="sr-only">Distance from the screen unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="aspect" label="Aspect ratio" value="16:9" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['throw' => 1.5, 'solve' => 'distance', 'width' => 2.5, 'width-unit' => 'm', 'distance' => 3.5, 'distance-unit' => 'm', 'aspect' => '16:9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'width' => ['label' => 'Image width'],
            'height' => ['label' => 'Image height'],
            'diag' => ['label' => 'Diagonal'],
            'distance' => ['label' => 'Throw distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
