<x-calc.page
    title="Fret Calculator - SolveKit"
    description="Free fret calculator: fret positions for any scale length in equal temperament."
    lede="Find fret positions."
    about="Each fret shortens the string by the twelfth root of two, so the 12th fret is exactly halfway."
    :calc="['engine' => 'tc-music', 'tool' => 'fret', 'fields' => ['scale', 'frets'], 'unitFields' => ['scale' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Where is the 12th fret on a 25.5″ scale?', 'answer' => '323.85 mm (12.75 in) from the nut.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="scale" label="Scale length" value="25.5" placeholder="Scale length">
            <label for="calc-scale-unit" class="sr-only">Scale length unit</label>
            <select id="calc-scale-unit" name="scale-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="frets" label="Number of frets" value="22" min="1" step="any" />
    </div>

    <x-calc.result label="12th fret (half the scale)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scale' => 25.5, 'scale-unit' => 'in', 'frets' => 22],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First fret from the nut'],
            'last' => ['label' => 'Last fret from the nut'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Fret positions" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
