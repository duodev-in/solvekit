<x-calc.page
    title="Animal Unit Month Calculator - SolveKit"
    description="Free animal unit month calculator: AUMs and forage needed from head, average weight and months of grazing."
    lede="Work out animal unit months (AUMs) and forage needed."
    about="An animal unit (AU) is a 1,000 lb cow, with or without a calf. An AUM is the forage one AU eats in a month, about 780 lb of dry matter (26 lb a day). Heavier animals count as more than one AU."
    :calc="['engine' => 'livestock', 'tool' => 'aum', 'fields' => ['head', 'weight', 'months'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the herd', 'text' => 'Head and average weight.'],
        ['name' => 'Enter the months', 'text' => 'Length of the grazing season.'],
    ]"
    :faqs="[
        ['question' => 'What is an animal unit?', 'answer' => 'A 1,000 lb cow, the standard for grazing.'],
        ['question' => 'How much does one AUM weigh?', 'answer' => 'About 780 lb of forage dry matter.'],
        ['question' => 'How are other animals counted?', 'answer' => 'By weight: a 150 lb sheep is about 0.15 AU.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="head" label="Head" value="50" min="0" step="1" />
        <x-calc.field name="weight" label="Average weight" value="1200" min="0" placeholder="Average weight">
            <label for="calc-weight-unit" class="sr-only">Average weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="months" label="Months" value="5" min="0" />
    </div>

    <x-calc.result label="Animal unit months" />

    <x-calc.options :examples="[
        '50 cows, 5 months' => ['head' => 50, 'weight' => 1200, 'weight-unit' => 'lb', 'months' => 5],
        '200 ewes' => ['head' => 200, 'weight' => 150, 'weight-unit' => 'lb', 'months' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'au' => ['label' => 'Animal units'],
            'forage' => ['label' => 'Forage needed'],
            'kg' => ['label' => 'Forage, metric'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AU = weight ÷ 1,000 lb</li>
            <li>AUM = head × AU × months</li>
            <li>forage = AUM × 780 lb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
