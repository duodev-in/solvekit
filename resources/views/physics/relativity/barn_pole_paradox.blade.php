<x-calc.page
    title="Barn-Pole Paradox - SolveKit"
    description="Free barn-pole paradox calculator: length contraction and simultaneity for a fast pole and a short barn."
    lede="Explore the barn-pole paradox."
    about="A runner carries a 20 m pole into a 10 m barn at high speed. The barn sees a short pole that fits; the runner sees a tiny barn. Both are right, because the two frames disagree about when the doors close."
    :calc="['engine' => 'ph-astro', 'tool' => 'barn_pole', 'fields' => ['pole', 'barn', 'v'], 'unitFields' => ['pole' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'barn' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Does a 20 m pole fit in a 10 m barn at 0.9c?', 'answer' => 'In the barn frame it is 8.718 m long: Yes, for an instant, in the barn frame.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pole" label="Pole length (at rest)" value="20" placeholder="Pole length (at rest)">
            <label for="calc-pole-unit" class="sr-only">Pole length (at rest) unit</label>
            <select id="calc-pole-unit" name="pole-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="barn" label="Barn length (at rest)" value="10" placeholder="Barn length (at rest)">
            <label for="calc-barn-unit" class="sr-only">Barn length (at rest) unit</label>
            <select id="calc-barn-unit" name="barn-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed" value="0.9" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="In the barn’s frame, the pole is" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pole' => 20, 'pole-unit' => 'm', 'barn' => 10, 'barn-unit' => 'm', 'v' => 0.9, 'v-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pole' => ['label' => 'Pole length seen by the barn'],
            'barn' => ['label' => 'Barn length seen by the runner'],
            'fits' => ['label' => 'Fits with both doors shut?'],
            'runner' => ['label' => 'Runner’s view'],
            'resolution' => ['label' => 'Resolution'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
