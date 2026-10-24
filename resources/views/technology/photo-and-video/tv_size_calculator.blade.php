<x-calc.page
    title="TV Size Calculator - SolveKit"
    description="Free TV size calculator: best TV size for your seating distance, or distance for a size (SMPTE and THX)."
    lede="Find the right TV size."
    about="Viewing-angle standards size a screen to fill 30° (SMPTE) or 40° (THX) of your view."
    :calc="['engine' => 'tc-photo', 'tool' => 'tv_size', 'fields' => ['solve', 'distance', 'diag', 'standard', 'res'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What TV suits 2.5 m away?', 'answer' => 'About 60.5″ (SMPTE).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Find" :options="['size' => 'TV size for my seating distance', 'distance' => 'Seating distance for a TV size']" selected="size" />
        <div data-show-when="solve:size">
            <x-calc.field name="distance" label="Viewing distance" value="2.5" placeholder="Viewing distance">
                <label for="calc-distance-unit" class="sr-only">Viewing distance unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:distance">
            <x-calc.field name="diag" label="TV diagonal (inches)" value="65" min="0" step="any" />
        </div>
        <x-calc.select name="standard" label="Viewing angle" :options="['smpte' => 'SMPTE 30° (comfortable)', 'thx' => 'THX 40° (cinematic)']" selected="smpte" />
        <x-calc.select name="res" label="Resolution" :options="['1080' => '1080p', '2160' => '4K', '4320' => '8K']" selected="2160" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'size', 'distance' => 2.5, 'distance-unit' => 'm', 'diag' => 65, 'standard' => 'smpte', 'res' => '2160'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'other' => ['label' => 'With the other standard'],
            'resolution' => ['label' => 'Closest distance before pixels show'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
