<x-calc.page
    title="Grain Bin Calculator - SolveKit"
    description="Free grain bin calculator: bushels and tons in a round bin from diameter, grain depth and peak height."
    lede="Work out how many bushels a round grain bin holds."
    about="A round bin holds a cylinder of grain to the eave plus a cone if the grain is peaked. One bushel is 1.2445 cubic feet. Weight uses the standard test weight of the grain; packing in tall bins can add a few percent."
    :calc="['engine' => 'livestock', 'tool' => 'grain_bin', 'fields' => ['grain', 'diameter', 'eave', 'peak'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'eave' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'peak' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => config('biology_data.grain_test_weights')]"
    :how-to="[
        ['name' => 'Pick the grain', 'text' => 'For its test weight.'],
        ['name' => 'Measure the bin', 'text' => 'Diameter and grain depth at the wall.'],
        ['name' => 'Add the peak', 'text' => 'Height of the cone above the eave, if any.'],
    ]"
    :faqs="[
        ['question' => 'How many bushels in a 30 × 24 ft bin?', 'answer' => 'About 13,600 bushels level full.'],
        ['question' => 'What is a bushel?', 'answer' => 'A volume of 1.2445 ft³; weight depends on the grain.'],
        ['question' => 'Why does my bin hold more?', 'answer' => 'Grain packs under its own weight in tall bins, often 3 to 8%.'],
    ]"
>
    <x-calc.select name="grain" label="Grain" :options="collect(config('biology_data.grain_test_weights'))->map(fn ($item) => $item['name'])->all()" selected="corn" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="diameter" label="Bin diameter" value="30" min="0" placeholder="Bin diameter">
            <label for="calc-diameter-unit" class="sr-only">Bin diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eave" label="Grain depth to eave" value="24" min="0" placeholder="Grain depth to eave">
            <label for="calc-eave-unit" class="sr-only">Grain depth to eave unit</label>
            <select id="calc-eave-unit" name="eave-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="peak" label="Peak height (optional)" value="8" min="0" placeholder="Peak height (optional)">
            <label for="calc-peak-unit" class="sr-only">Peak height (optional) unit</label>
            <select id="calc-peak-unit" name="peak-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Bin capacity" />

    <x-calc.options :examples="[
        '30 × 24 ft corn' => ['grain' => 'corn', 'diameter' => 30, 'diameter-unit' => 'ft', 'eave' => 24, 'eave-unit' => 'ft', 'peak' => 8, 'peak-unit' => 'ft'],
        '18 ft wheat, level' => ['grain' => 'wheat', 'diameter' => 18, 'diameter-unit' => 'ft', 'eave' => 16, 'eave-unit' => 'ft', 'peak' => 0, 'peak-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ft3' => ['label' => 'Volume'],
            'tons' => ['label' => 'Weight'],
            'tonnes' => ['label' => 'Weight, metric'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ft³ = π × (D ÷ 2)² × depth + π × (D ÷ 2)² × peak ÷ 3</li>
            <li>bushels = ft³ ÷ 1.2445</li>
            <li>lb = bushels × test weight</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
