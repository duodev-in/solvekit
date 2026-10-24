<x-calc.page
    title="TV Mounting Height Calculator - SolveKit"
    description="Free TV mounting height calculator: height of the screen centre, top and bottom for comfortable viewing."
    lede="Find the TV mounting height."
    about="The most comfortable height puts the middle of the screen at your eye level when seated."
    :calc="['engine' => 'tc-photo', 'tool' => 'tv_mount', 'fields' => ['diag', 'eye', 'offset'], 'unitFields' => ['eye' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'offset' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How high should a 65″ TV be?', 'answer' => 'Centre at about 1.07 m (3.51 ft).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diag" label="TV diagonal (inches)" value="65" min="0" step="any" />
        <x-calc.field name="eye" label="Seated eye height" value="107" placeholder="Seated eye height">
            <label for="calc-eye-unit" class="sr-only">Seated eye height unit</label>
            <select id="calc-eye-unit" name="eye-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="offset" label="Raise above eye level (optional)" value="0" placeholder="Raise above eye level (optional)">
            <label for="calc-offset-unit" class="sr-only">Raise above eye level (optional) unit</label>
            <select id="calc-offset-unit" name="offset-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Height to the centre of the TV" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['diag' => 65, 'eye' => 107, 'eye-unit' => 'cm', 'offset' => 0, 'offset-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bottom' => ['label' => 'Height to the bottom edge'],
            'top' => ['label' => 'Height to the top edge'],
            'screenH' => ['label' => 'Screen height'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
