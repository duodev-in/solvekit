<x-calc.page
    title="EUI Calculator – Energy Use Intensity - SolveKit"
    description="Free EUI calculator: site and source energy use intensity of a building in kBtu per square foot from a year of energy bills, compared with the ENERGY STAR national median for its type."
    lede="Work out a building's energy use intensity and compare it."
    about="Energy use intensity (EUI) = a year's energy ÷ floor area. Site EUI uses the energy on your bills; source EUI also counts the energy used to make and deliver it, using ENERGY STAR's U.S. ratios (electricity 2.80, natural gas 1.05, fuel oil and propane 1.01, district steam 1.20). Medians come from ENERGY STAR's August 2024 table, mostly based on the CBECS survey."
    :calc="['engine' => 'ev-home', 'tool' => 'eui', 'fields' => ['electricity', 'gas', 'oil', 'propane', 'steam', 'area', 'type'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => collect(config('everyday_data'))->only(['source_site', 'eui_medians'])->all()]"
    :how-to="[
        ['name' => 'Enter a year of energy', 'text' => 'From 12 months of bills.'],
        ['name' => 'Enter floor area and type', 'text' => 'Gross floor area.'],
    ]"
    :faqs="[
        ['question' => 'What is a good EUI for an office?', 'answer' => 'The U.S. median is 52.9 kBtu/ft² site and 116.4 source.'],
        ['question' => 'Why use source EUI?', 'answer' => 'It fairly compares buildings that use different fuels.'],
        ['question' => 'What is 1 kBtu/ft² in kWh/m²?', 'answer' => 'About 3.15 kWh/m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="electricity" label="Electricity" value="120000" min="0" suffix="kWh/yr" />
        <x-calc.field name="gas" label="Natural gas" value="3500" min="0" suffix="therms/yr" />
        <x-calc.field name="oil" label="Fuel oil" value="" min="0" suffix="gal/yr" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="propane" label="Propane" value="" min="0" suffix="gal/yr" />
        <x-calc.field name="steam" label="District steam" value="" min="0" suffix="kBtu/yr" />
        <x-calc.field name="area" label="Gross floor area" value="10000" min="0" placeholder="Gross floor area">
            <label for="calc-area-unit" class="sr-only">Gross floor area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="type" label="Building type" :options="collect(config('everyday_data.eui_medians'))->map(fn ($m) => $m[0])->all()" selected="office" />

    <x-calc.result label="Site EUI" />

    <x-calc.options :examples="[
        'Office, 10,000 ft²' => ['electricity' => 120000, 'gas' => 3500, 'oil' => '', 'propane' => '', 'steam' => '', 'area' => 10000, 'area-unit' => 'ft2', 'type' => 'office'],
        'School' => ['electricity' => 650000, 'gas' => 42000, 'oil' => '', 'propane' => '', 'steam' => '', 'area' => 80000, 'area-unit' => 'ft2', 'type' => 'k12'],
        'Retail, metric area' => ['electricity' => 300000, 'gas' => '', 'oil' => '', 'propane' => 2000, 'steam' => '', 'area' => 2500, 'area-unit' => 'm2', 'type' => 'retail'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'source' => ['label' => 'Source EUI'],
            'metric' => ['label' => 'Metric'],
            'median' => ['label' => 'National median'],
        ]" />
        <x-calc.quick-ref heading="By fuel" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>site EUI = Σ energy × kBtu per unit ÷ ft²</li>
            <li>source EUI = Σ energy × kBtu × source-site ratio ÷ ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
