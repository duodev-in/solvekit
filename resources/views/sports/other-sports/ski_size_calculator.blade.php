<x-calc.page
    title="Ski Size Calculator - SolveKit"
    description="Free ski size calculator: ski length from height, ability, style and build."
    lede="Find your ski length."
    about="Beginners use shorter skis (about chin height); experts use longer ones (about head height)."
    :calc="['engine' => 'sp-misc', 'tool' => 'ski_size', 'fields' => ['h', 'level', 'style', 'weight', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What length for a 175 cm intermediate?', 'answer' => 'About 165 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Height" value="175" placeholder="Height">
            <label for="calc-h-unit" class="sr-only">Height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="level" label="Ability" :options="['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced', 'expert' => 'Expert']" selected="intermediate" />
        <x-calc.select name="style" label="Skiing" :options="['piste' => 'On piste', 'all' => 'All-mountain', 'powder' => 'Powder or freeride']" selected="all" />
        <x-calc.select name="weight" label="Build" :options="['light' => 'Light for my height', 'average' => 'Average', 'heavy' => 'Heavy for my height']" selected="average" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Ski length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'h' => 175, 'h-unit' => 'cm', 'level' => 'intermediate', 'style' => 'all', 'weight' => 'average'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Range to try'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
