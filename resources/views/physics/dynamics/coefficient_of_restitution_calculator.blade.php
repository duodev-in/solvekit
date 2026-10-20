<x-calc.page
    title="Coefficient of Restitution Calculator - SolveKit"
    description="Free coefficient of restitution calculator: e from drop and bounce heights, with the following bounces."
    lede="Find the bounciness of a ball."
    about="The coefficient of restitution is the ratio of speeds after and before a bounce, e = √(h₂ ÷ h₁). Basketballs are about 0.8, tennis balls about 0.75."
    :calc="['engine' => 'ph-mech', 'tool' => 'restitution', 'fields' => ['h1', 'h2'], 'unitFields' => ['h1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'A ball dropped from 100 cm bounces to 64 cm. What is e?', 'answer' => '0.8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h1" label="Drop height" value="100" placeholder="Drop height">
            <label for="calc-h1-unit" class="sr-only">Drop height unit</label>
            <select id="calc-h1-unit" name="h1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h2" label="Bounce height" value="64" placeholder="Bounce height">
            <label for="calc-h2-unit" class="sr-only">Bounce height unit</label>
            <select id="calc-h2-unit" name="h2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Coefficient of restitution e" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['h1' => 100, 'h1-unit' => 'cm', 'h2' => 64, 'h2-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bounces' => ['label' => 'Next bounce heights'],
            'total' => ['label' => 'Total distance travelled (all bounces)'],
            'energy' => ['label' => 'Energy kept per bounce'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
