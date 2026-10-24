<x-calc.page
    title="Snowman Calculator - SolveKit"
    description="Free snowman calculator: snow volume, weight and ball sizes for a snowman of any height."
    lede="Plan a snowman."
    about="A classic snowman is three balls in the ratio 3 : 2 : 1."
    :calc="['engine' => 'ot-misc', 'tool' => 'snowman', 'fields' => ['height', 'snow', 'fresh'], 'unitFields' => ['height' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'fresh' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much snow for a 1.5 m snowman?', 'answer' => '0.4396 m³ of packed snow.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Snowman height" value="1.5" placeholder="Snowman height">
            <label for="calc-height-unit" class="sr-only">Snowman height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="snow" label="Snow" :options="['packed' => 'Packed snowball (about 400 kg/m³)', 'wet' => 'Wet, heavy snow (about 500 kg/m³)']" selected="packed" />
        <x-calc.field name="fresh" label="Depth of fresh snow on the ground" value="10" placeholder="Depth of fresh snow on the ground">
            <label for="calc-fresh-unit" class="sr-only">Depth of fresh snow on the ground unit</label>
            <select id="calc-fresh-unit" name="fresh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Snow needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 1.5, 'height-unit' => 'm', 'snow' => 'packed', 'fresh' => 10, 'fresh-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'balls' => ['label' => 'Ball diameters (3 : 2 : 1)'],
            'weight' => ['label' => 'Weight'],
            'area' => ['label' => 'Area of fresh snow to gather'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
