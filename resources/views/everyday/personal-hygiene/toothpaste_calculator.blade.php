<x-calc.page
    title="Toothpaste Calculator - SolveKit"
    description="Free toothpaste calculator: how long a tube of toothpaste lasts for your household, and how many tubes you need a year."
    lede="Work out how long a tube of toothpaste lasts."
    about="Days = tube weight ÷ (amount per brushing × people × brushings a day). Dental groups advise brushing twice a day, with a pea-sized amount (about 0.25 g) for children 3–6 and a smear the size of a rice grain under 3. Adults often use about 1 g, a strip across the brush; weigh yours for an exact answer."
    :calc="['engine' => 'ev-care', 'tool' => 'toothpaste', 'fields' => ['tube', 'amount', 'people', 'brushings', 'price'], 'unitFields' => ['tube' => collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg'])->all(), 'amount' => collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the tube size', 'text' => 'Net weight on the box.'],
        ['name' => 'Enter use', 'text' => 'Amount per brushing, people, brushings.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 4.8 oz tube last?', 'answer' => 'About 34 days for two people using 1 g twice a day.'],
        ['question' => 'How much toothpaste should a child use?', 'answer' => 'A pea-sized amount from age 3 to 6.'],
        ['question' => 'How many tubes a year?', 'answer' => 'About 11 for two adults at these settings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tube" label="Tube size (net weight)" value="4.8" min="0" placeholder="Tube size (net weight)">
            <label for="calc-tube-unit" class="sr-only">Tube size (net weight) unit</label>
            <select id="calc-tube-unit" name="tube-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'oz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="amount" label="Amount per brushing" value="1" min="0" placeholder="Amount per brushing">
            <label for="calc-amount-unit" class="sr-only">Amount per brushing unit</label>
            <select id="calc-amount-unit" name="amount-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="People" value="2" min="1" step="1" />
        <x-calc.field name="brushings" label="Brushings a day" value="2" min="1" step="1" />
        <x-calc.field name="price" label="Tube price (optional)" value="4" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="A tube lasts" />

    <x-calc.options :examples="[
        'Two adults' => ['tube' => 4.8, 'tube-unit' => 'oz', 'amount' => 1, 'amount-unit' => 'g', 'people' => 2, 'brushings' => 2, 'price' => 4],
        'Child, pea-sized' => ['tube' => 4.2, 'tube-unit' => 'oz', 'amount' => 0.25, 'amount-unit' => 'g', 'people' => 1, 'brushings' => 2, 'price' => 3.5],
        '100 g tube, family' => ['tube' => 100, 'tube-unit' => 'g', 'amount' => 1, 'amount-unit' => 'g', 'people' => 4, 'brushings' => 2, 'price' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tubes' => ['label' => 'Tubes a year'],
            'cost' => ['label' => 'Cost'],
            'note' => ['label' => 'Children'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = tube ÷ (amount × people × brushings)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
