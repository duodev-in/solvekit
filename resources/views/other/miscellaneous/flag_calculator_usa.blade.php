<x-calc.page
    title="Flag Calculator | USA - SolveKit"
    description="Free US flag calculator: official proportions of the US flag for any size (Executive Order 10834)."
    lede="Find US flag dimensions."
    about="The US flag’s proportions are fixed by Executive Order 10834: the fly is 1.9 times the hoist."
    :calc="['engine' => 'ot-misc', 'tool' => 'us_flag', 'fields' => ['hoist'], 'unitFields' => ['hoist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 3 ft high flag?', 'answer' => '5.7 ft (173.7 cm).'],
    ]"
>
    <x-calc.field name="hoist" label="Flag height (hoist)" value="3" placeholder="Flag height (hoist)">
        <label for="calc-hoist-unit" class="sr-only">Flag height (hoist) unit</label>
        <select id="calc-hoist-unit" name="hoist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Flag length (fly)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hoist' => 3, 'hoist-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'union' => ['label' => 'Union (blue field) height × length'],
            'stripe' => ['label' => 'Each stripe'],
            'star' => ['label' => 'Star diameter'],
            'area' => ['label' => 'Flag area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
