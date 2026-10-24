<x-calc.page
    title="Flash Guide Number Calculator - SolveKit"
    description="Free flash guide number calculator: flash range, aperture or guide number needed at any ISO."
    lede="Use a flash guide number."
    about="A flash’s guide number is the distance it lights at f/1 and ISO 100: GN = distance × f-number."
    :calc="['engine' => 'tc-photo', 'tool' => 'guide_number', 'fields' => ['solve', 'gn', 'n', 'dist', 'iso'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How far does a GN 40 flash reach at f/8?', 'answer' => '5 m (16.4 ft).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Find" :options="['distance' => 'Flash range', 'aperture' => 'Aperture to use', 'gn' => 'Guide number needed']" selected="distance" />
        <div data-show-when="solve:distance,aperture">
            <x-calc.field name="gn" label="Guide number (metres, ISO 100)" value="40" min="0" step="any" />
        </div>
        <div data-show-when="solve:distance,gn">
            <x-calc.field name="n" label="Aperture (f-number)" value="8" min="0" step="any" />
        </div>
        <div data-show-when="solve:aperture,gn">
            <x-calc.field name="dist" label="Subject distance" value="5" placeholder="Subject distance">
                <label for="calc-dist-unit" class="sr-only">Subject distance unit</label>
                <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="iso" label="ISO" value="100" min="0" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'distance', 'gn' => 40, 'n' => 8, 'dist' => 5, 'dist-unit' => 'm', 'iso' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'effective' => ['label' => 'Guide number at this ISO'],
            'feet' => ['label' => 'Guide number in feet'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
