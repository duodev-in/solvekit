<x-calc.page
    title="Cigarette Butts Cleanup Calculator - SolveKit"
    description="Free cigarette butts cleanup calculator: weight of cigarette butts collected and the water each could poison, from Slaughter et al. 2011."
    lede="Work out the weight and impact of cigarette butts collected in a cleanup."
    about="A smoked cigarette butt weighs about 310 mg. In laboratory tests (Slaughter et al. 2011, Tobacco Control), chemicals leached from about one smoked butt per liter of water killed half of the marine and freshwater test fish within 96 hours. Filters are made of cellulose acetate, a plastic."
    :calc="['engine' => 'eco-living', 'tool' => 'butts', 'fields' => ['input', 'count', 'area', 'density'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => ['constants' => config('ecology_data.constants')]]"
    :how-to="[
        ['name' => 'Count the butts', 'text' => 'Or estimate from an area and density.'],
    ]"
    :faqs="[
        ['question' => 'How much does a cigarette butt weigh?', 'answer' => 'About 310 mg after smoking (Slaughter et al. 2011).'],
        ['question' => 'Are cigarette filters plastic?', 'answer' => 'Yes, cellulose acetate, which breaks into microfibers rather than biodegrading quickly.'],
        ['question' => 'How toxic are butts?', 'answer' => 'About one butt per liter killed half the test fish in 96 hours.'],
    ]"
>
    <x-calc.segmented name="input" legend="From" :options="['count' => 'Butts counted', 'area' => 'Area and density']" selected="count" />

    <div data-show-when="input:count">
        <x-calc.field name="count" label="Butts collected" value="2000" min="0" step="1" />
    </div>

    <div data-show-when="input:area" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="area" label="Area cleaned" value="1000" min="0" placeholder="Area cleaned">
                <label for="calc-area-unit" class="sr-only">Area cleaned unit</label>
                <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="density" label="Butts per m²" value="2" min="0" step="0.1" />
        </div>
    </div>

    <x-calc.result label="Weight of the butts collected" />

    <x-calc.options :examples="[
        'Beach cleanup, 2,000 butts' => ['input' => 'count', 'count' => 2000],
        'Park, 1,000 m² at 2 per m²' => ['input' => 'area', 'area' => 1000, 'area-unit' => 'm2', 'density' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water at risk'],
            'count' => ['label' => 'Butts'],
            'plastic' => ['label' => 'Material'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mass = butts × 0.31 g</li>
            <li>LC50 ≈ 1 smoked butt per liter (96 h)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
