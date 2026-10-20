<x-calc.page
    title="Fishing Reel Line Capacity Calculator - SolveKit"
    description="Free reel line capacity calculator: how much line of a different diameter fits on a spool."
    lede="Find reel line capacity."
    about="A spool holds a fixed volume of line, so capacity changes with the square of line diameter."
    :calc="['engine' => 'sp-misc', 'tool' => 'reel_capacity', 'fields' => ['yards', 'd1', 'd2'], 'unitFields' => ['d1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much 0.28 mm line fits where 200 of 0.35 mm do?', 'answer' => '312.5 (same length unit as the rating).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="yards" label="Rated capacity (length on the spool)" value="200" min="1" step="any" />
        <x-calc.field name="d1" label="Rated line diameter" value="0.35" placeholder="Rated line diameter">
            <label for="calc-d1-unit" class="sr-only">Rated line diameter unit</label>
            <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d2" label="Your line diameter" value="0.28" placeholder="Your line diameter">
            <label for="calc-d2-unit" class="sr-only">Your line diameter unit</label>
            <select id="calc-d2-unit" name="d2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Capacity with your line" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['yards' => 200, 'd1' => 0.35, 'd1-unit' => 'mm', 'd2' => 0.28, 'd2-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Change'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
