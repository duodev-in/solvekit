<x-calc.page
    title="Insulation Calculator - SolveKit"
    description="Free insulation calculator: thickness of insulation needed to reach a target R-value, from typical R-value per inch of each material."
    lede="Work out how thick insulation must be to reach an R-value."
    about="Thickness = (target R − existing R) ÷ R per inch. R per inch varies with density and product; the ranges are typical values from the Building America Solution Center (PNNL), so the result is a range. Check the R-value printed on the product; the IECC and IRC Table N1102.1.3 give the R-values required in each climate zone."
    :calc="['engine' => 'con-hvac', 'tool' => 'insulation', 'fields' => ['target', 'existing', 'material', 'per_inch', 'area'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => ['insulation' => config('construction_data.insulation')]]"
    :how-to="[
        ['name' => 'Enter the target and existing R', 'text' => 'From your code or plans.'],
        ['name' => 'Choose the insulation', 'text' => 'Or enter its R per inch.'],
    ]"
    :faqs="[
        ['question' => 'How thick is R-49 fiberglass?', 'answer' => 'About 12–20 in depending on density (R-2.5 to 4 per inch).'],
        ['question' => 'What R-value for an attic?', 'answer' => 'R-49 to R-60 in most US climate zones under the 2021 IECC.'],
        ['question' => 'Which insulation has the highest R per inch?', 'answer' => 'Closed-cell spray foam and polyiso, about R-6 per inch.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Target R-value" value="49" min="0" />
        <x-calc.field name="existing" label="Existing R-value (optional)" value="11" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Insulation" :options="collect(config('construction_data.insulation'))->map(fn ($m) => $m['name'])->all() + ['custom' => 'Other (enter R per inch)']" selected="fiberglass" />
        <div data-show-when="material:custom" hidden>
            <x-calc.field name="per_inch" label="R per inch" value="3.5" min="0.1" step="0.1" />
        </div>
    </div>

    <x-calc.field name="area" label="Area (optional)" value="1000" min="0" placeholder="Area (optional)">
        <label for="calc-area-unit" class="sr-only">Area (optional) unit</label>
        <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Thickness to add" />

    <x-calc.options :examples="[
        'Attic to R-49 over R-11' => ['target' => 49, 'existing' => 11, 'material' => 'fiberglass', 'area' => 1000, 'area-unit' => 'ft2'],
        'Wall foam R-15' => ['target' => 15, 'existing' => 0, 'material' => 'spf_closed', 'area' => 400, 'area-unit' => 'ft2'],
        'XPS under a slab, R-10' => ['target' => 10, 'existing' => 0, 'material' => 'xps', 'area' => 50, 'area-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mm' => ['label' => 'Millimeters'],
            'needed' => ['label' => 'R to add'],
            'volume' => ['label' => 'Volume'],
            'u' => ['label' => 'U-factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>thickness = (target − existing) ÷ R per inch</li>
            <li>U = 1 ÷ R</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
