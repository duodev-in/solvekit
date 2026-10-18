<x-calc.page
    title="Bathroom Mirror Size Calculator - SolveKit"
    description="Free bathroom mirror size calculator: how wide and tall a bathroom mirror should be for your vanity, and where to hang it."
    lede="Find the right size and height for a bathroom mirror."
    about="Designers usually make a vanity mirror 2–4 inches narrower than the vanity on each side (or one mirror per sink on a double vanity), with its bottom edge about 5 inches above the faucet and its top above the tallest user's eye level. These are guidelines, not code; lights and cabinets may change them."
    :calc="['engine' => 'ev-home', 'tool' => 'mirror', 'fields' => ['vanity', 'counter', 'faucet', 'person', 'double'], 'unitFields' => ['vanity' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'counter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'faucet' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'person' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the vanity and faucet', 'text' => 'Width, counter and faucet heights.'],
        ['name' => 'Enter the tallest user', 'text' => 'To set the top edge.'],
    ]"
    :faqs="[
        ['question' => 'How big should a mirror be over a 48-inch vanity?', 'answer' => 'About 40–44 inches wide.'],
        ['question' => 'How high should a bathroom mirror hang?', 'answer' => 'Bottom about 5 in above the faucet; center around eye level.'],
        ['question' => 'One mirror or two on a double vanity?', 'answer' => 'Either; with two, center one over each sink.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="vanity" label="Vanity width" value="48" min="0" placeholder="Vanity width">
            <label for="calc-vanity-unit" class="sr-only">Vanity width unit</label>
            <select id="calc-vanity-unit" name="vanity-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="counter" label="Counter height" value="34" min="0" placeholder="Counter height">
            <label for="calc-counter-unit" class="sr-only">Counter height unit</label>
            <select id="calc-counter-unit" name="counter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="faucet" label="Faucet height above counter" value="8" min="0" placeholder="Faucet height above counter">
            <label for="calc-faucet-unit" class="sr-only">Faucet height above counter unit</label>
            <select id="calc-faucet-unit" name="faucet-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="person" label="Tallest user's height" value="72" min="0" placeholder="Tallest user's height">
            <label for="calc-person-unit" class="sr-only">Tallest user's height unit</label>
            <select id="calc-person-unit" name="person-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.checkbox name="double" label="Double vanity (two mirrors)" :checked="false" />
    </div>

    <x-calc.result label="Mirror width" />

    <x-calc.options :examples="[
        '48 in vanity' => ['vanity' => 48, 'vanity-unit' => 'in', 'counter' => 34, 'counter-unit' => 'in', 'faucet' => 8, 'faucet-unit' => 'in', 'person' => 72, 'person-unit' => 'in', 'double' => false],
        'Double 72 in' => ['vanity' => 72, 'vanity-unit' => 'in', 'counter' => 36, 'counter-unit' => 'in', 'faucet' => 8, 'faucet-unit' => 'in', 'person' => 74, 'person-unit' => 'in', 'double' => true],
        'Metric 80 cm' => ['vanity' => 80, 'vanity-unit' => 'cm', 'counter' => 85, 'counter-unit' => 'cm', 'faucet' => 18, 'faucet-unit' => 'cm', 'person' => 180, 'person-unit' => 'cm', 'double' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'height' => ['label' => 'Height'],
            'bottom' => ['label' => 'Bottom edge'],
            'center' => ['label' => 'Center'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>width = vanity − 4 to 8 in</li>
            <li>bottom = counter + faucet + 5 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
