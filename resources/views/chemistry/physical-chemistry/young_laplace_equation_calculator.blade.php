<x-calc.page
    title="Young-Laplace Equation Calculator - SolveKit"
    description="Free Young-Laplace calculator: pressure difference across a curved surface for drops, bubbles, soap bubbles and cylinders."
    lede="Work out the pressure inside a drop or bubble with the Young–Laplace equation."
    about="A curved liquid surface has a higher pressure on its concave side: ΔP = γ (1/R₁ + 1/R₂). For a sphere this is 2γ/R; a soap bubble has two surfaces, so 4γ/R. Water's surface tension comes from the IAPWS equation at your temperature; for other liquids enter your own value."
    :calc="['engine' => 'chem-physical', 'tool' => 'young_laplace', 'fields' => ['shape', 'liquid', 'temperature', 'tension', 'r1', 'r2'], 'unitFields' => ['r1' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'r2' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Pick the shape', 'text' => 'Drop, soap bubble, cylinder or general.'],
        ['name' => 'Pick the liquid', 'text' => 'Water or your own value.'],
        ['name' => 'Enter the radius', 'text' => 'Smaller radii give higher pressure.'],
    ]"
    :faqs="[
        ['question' => 'Why is the pressure higher inside a small bubble?', 'answer' => 'ΔP rises as 1/R, so smaller bubbles have more pressure.'],
        ['question' => 'Why is a soap bubble 4γ/R?', 'answer' => 'The film has two surfaces, inside and outside.'],
        ['question' => 'What is water\'s surface tension?', 'answer' => '71.97 mN/m at 25 °C (IAPWS).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape" :options="['drop' => 'Drop or bubble in liquid', 'soap' => 'Soap bubble (two surfaces)', 'cylinder' => 'Cylinder or jet', 'general' => 'Two radii']" selected="drop" />
        <x-calc.select name="liquid" label="Liquid" :options="['water' => 'Water (IAPWS)', 'custom' => 'Custom surface tension']" selected="water" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="liquid:water">
            <x-calc.field name="temperature" label="Water temperature" value="25" suffix="°C" />
        </div>
        <div data-show-when="liquid:custom" hidden>
            <x-calc.field name="tension" label="Surface tension" value="25" min="0" suffix="mN/m" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r1" label="Radius R₁" value="1" min="0" placeholder="Radius R₁">
            <label for="calc-r1-unit" class="sr-only">Radius R₁ unit</label>
            <select id="calc-r1-unit" name="r1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="shape:general" hidden>
            <x-calc.field name="r2" label="Radius R₂" value="2" min="0" placeholder="Radius R₂">
                <label for="calc-r2-unit" class="sr-only">Radius R₂ unit</label>
                <select id="calc-r2-unit" name="r2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Laplace pressure" />

    <x-calc.options :examples="[
        '1 mm water drop' => ['shape' => 'drop', 'liquid' => 'water', 'temperature' => 25, 'r1' => 1, 'r1-unit' => 'mm'],
        'Soap bubble, 2 cm' => ['shape' => 'soap', 'liquid' => 'custom', 'tension' => 25, 'r1' => 2, 'r1-unit' => 'cm'],
        'Tiny bubble, 1 µm' => ['shape' => 'drop', 'liquid' => 'water', 'temperature' => 25, 'r1' => 0.001, 'r1-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kpa' => ['label' => 'In kPa'],
            'mmhg' => ['label' => 'In mmHg'],
            'tension' => ['label' => 'Surface tension'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔP = γ (1/R₁ + 1/R₂)</li>
            <li>sphere 2γ/R; soap bubble 4γ/R</li>
            <li>water: IAPWS σ = 235.8 τ^1.256 (1 − 0.625 τ) mN/m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
