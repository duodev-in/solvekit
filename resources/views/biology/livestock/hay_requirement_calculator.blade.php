<x-calc.page
    title="Hay Requirement Calculator - SolveKit"
    description="Free hay calculator: bales and tons of hay to feed cattle, horses or goats through winter, with waste and cost."
    lede="Work out how much hay your animals need for the winter."
    about="Animals eat about 2.5% of their body weight in dry matter a day; hay is about 88% dry matter. Feeding loses 5 to 25% depending on the feeder, so the waste allowance matters."
    :calc="['engine' => 'livestock', 'tool' => 'hay', 'fields' => ['head', 'weight', 'days', 'bale', 'waste', 'price'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'bale' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the animals', 'text' => 'Head and average weight.'],
        ['name' => 'Enter the season', 'text' => 'Days of hay feeding.'],
        ['name' => 'Set bale weight and waste', 'text' => 'Weigh a few bales if you can.'],
    ]"
    :faqs="[
        ['question' => 'How much hay does a cow eat a day?', 'answer' => 'About 30 to 35 lb as fed for a 1,200 lb cow.'],
        ['question' => 'How much waste is normal?', 'answer' => 'About 5% with a good feeder, up to 25% or more fed on the ground.'],
        ['question' => 'Does this work for horses?', 'answer' => 'Yes; horses eat about 2 to 2.5% of body weight.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="head" label="Head" value="20" min="0" step="1" />
        <x-calc.field name="weight" label="Average weight" value="1200" min="0" placeholder="Average weight">
            <label for="calc-weight-unit" class="sr-only">Average weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Days of feeding" value="150" min="0" step="1" />
        <x-calc.field name="bale" label="Bale weight" value="1000" min="0" placeholder="Bale weight">
            <label for="calc-bale-unit" class="sr-only">Bale weight unit</label>
            <select id="calc-bale-unit" name="bale-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Waste" value="15" min="0" max="90" suffix="%" />
        <x-calc.field name="price" label="Price per bale (optional)" value="60" min="0" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Hay needed" />

    <x-calc.options :examples="[
        '20 cows, winter' => ['head' => 20, 'weight' => 1200, 'weight-unit' => 'lb', 'days' => 150, 'bale' => 1000, 'bale-unit' => 'lb', 'waste' => 15],
        '2 horses, small bales' => ['head' => 2, 'weight' => 1100, 'weight-unit' => 'lb', 'days' => 180, 'bale' => 50, 'bale-unit' => 'lb', 'waste' => 10, 'price' => 9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tons' => ['label' => 'Total'],
            'daily' => ['label' => 'Per head per day'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dry matter = head × weight × 2.5% × days</li>
            <li>hay = dry matter ÷ 0.88 ÷ (1 − waste)</li>
            <li>bales = hay ÷ bale weight, rounded up</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
