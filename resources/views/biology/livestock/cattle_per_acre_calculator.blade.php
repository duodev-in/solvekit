<x-calc.page
    title="Cattle per Acre Calculator - SolveKit"
    description="Free cattle per acre calculator: stocking rate from pasture size, forage yield, utilisation, animal weight and grazing days."
    lede="Work out how many cattle your pasture can carry."
    about="Usable forage is acres × yield × utilisation. Take half, leave half suggests about 50% removal, but only about 25 to 35% is actually eaten after trampling and waste. A cow eats about 2.6% of its body weight in dry matter a day."
    :calc="['engine' => 'livestock', 'tool' => 'stocking_rate', 'fields' => ['acres', 'forage', 'utilisation', 'weight', 'days'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the pasture', 'text' => 'Acres and forage yield in dry matter.'],
        ['name' => 'Set utilisation', 'text' => '25 to 35% is realistic for continuous grazing.'],
        ['name' => 'Enter weight and days', 'text' => 'Average animal and grazing season.'],
    ]"
    :faqs="[
        ['question' => 'How many acres per cow?', 'answer' => 'From under 2 acres in high-rainfall pasture to 20 or more on dry range.'],
        ['question' => 'What is forage yield?', 'answer' => 'Dry matter grown per acre; clip and weigh a sample or ask your extension office.'],
        ['question' => 'Why not use all the grass?', 'answer' => 'Over-grazing damages the pasture and cuts next year\'s growth.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="acres" label="Pasture" value="40" min="0" suffix="acres" />
        <x-calc.field name="forage" label="Forage yield" value="3000" min="0" suffix="lb DM/acre" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="utilisation" label="Utilisation" value="30" min="0" max="100" suffix="%" />
        <x-calc.field name="weight" label="Animal weight" value="1200" min="0" placeholder="Animal weight">
            <label for="calc-weight-unit" class="sr-only">Animal weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="days" label="Grazing days" value="120" min="0" step="1" />
    </div>

    <x-calc.result label="Cattle the pasture carries" />

    <x-calc.options :examples="[
        '40 acres, 120 days' => ['acres' => 40, 'forage' => 3000, 'utilisation' => 30, 'weight' => 1200, 'weight-unit' => 'lb', 'days' => 120],
        'Dry range' => ['acres' => 640, 'forage' => 800, 'utilisation' => 25, 'weight' => 1100, 'weight-unit' => 'lb', 'days' => 180],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'forage' => ['label' => 'Usable forage'],
            'demand' => ['label' => 'Demand per head'],
            'aum' => ['label' => 'Animal unit months'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>forage = acres × yield × utilisation</li>
            <li>demand = weight × 2.6% × days</li>
            <li>head = forage ÷ demand</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
