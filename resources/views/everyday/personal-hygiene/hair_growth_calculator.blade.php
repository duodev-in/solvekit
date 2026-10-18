<x-calc.page
    title="Hair Growth Calculator - SolveKit"
    description="Free hair growth calculator: how many months it takes your hair to grow to a target length, and the date it gets there."
    lede="Find out how long it takes to grow your hair."
    about="Scalp hair grows on average about 0.3–0.4 mm a day, roughly 1–1.25 cm (about half an inch) a month, or 6 inches a year. Speed varies with age, genes, health and hair type, so set your own rate if you have measured it. Trims remove length, so add whatever you cut."
    :calc="['engine' => 'ev-care', 'tool' => 'hair_growth', 'fields' => ['current', 'target', 'rate', 'start'], 'unitFields' => ['current' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'target' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rate' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter current and target length', 'text' => 'Measured from the scalp.'],
        ['name' => 'Set the growth rate', 'text' => 'About half an inch a month on average.'],
    ]"
    :faqs="[
        ['question' => 'How long to grow hair 8 inches?', 'answer' => 'About 16 months at half an inch a month.'],
        ['question' => 'How fast does hair grow?', 'answer' => 'About 1–1.25 cm (½ in) a month on average.'],
        ['question' => 'Do trims make hair grow faster?', 'answer' => 'No, they remove split ends but also length.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="current" label="Current length" value="6" min="0" placeholder="Current length">
            <label for="calc-current-unit" class="sr-only">Current length unit</label>
            <select id="calc-current-unit" name="current-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Target length" value="14" min="0" placeholder="Target length">
            <label for="calc-target-unit" class="sr-only">Target length unit</label>
            <select id="calc-target-unit" name="target-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Growth per month" value="0.5" min="0" placeholder="Growth per month">
            <label for="calc-rate-unit" class="sr-only">Growth per month unit</label>
            <select id="calc-rate-unit" name="rate-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="start" label="Starting" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.result label="Time to reach your length" />

    <x-calc.options :examples="[
        '6 → 14 in' => ['current' => 6, 'current-unit' => 'in', 'target' => 14, 'target-unit' => 'in', 'rate' => 0.5, 'rate-unit' => 'in', 'start' => '2026-10-18'],
        'Pixie to shoulder' => ['current' => 2, 'current-unit' => 'in', 'target' => 10, 'target-unit' => 'in', 'rate' => 0.5, 'rate-unit' => 'in', 'start' => '2026-10-18'],
        'Metric, 1.2 cm/month' => ['current' => 20, 'current-unit' => 'cm', 'target' => 45, 'target-unit' => 'cm', 'rate' => 1.2, 'rate-unit' => 'cm', 'start' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'date' => ['label' => 'Date'],
            'years' => ['label' => 'In years'],
            'trims' => ['label' => 'Trims'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>months = (target − current) ÷ rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
