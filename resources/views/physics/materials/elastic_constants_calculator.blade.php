<x-calc.page
    title="Elastic Constants Calculator - SolveKit"
    description="Free elastic constants calculator: convert any two of Young's modulus, shear modulus, bulk modulus, Poisson's ratio and Lamé λ to all the others."
    lede="Convert between elastic constants."
    about="An isotropic elastic material has only two independent constants. Knowing any two of E, G, K, ν and λ fixes the rest."
    :calc="['engine' => 'ph-mat', 'tool' => 'elastic_constants', 'fields' => ['pair', 'E', 'G', 'Km', 'lam', 'nu', 'out'], 'unitFields' => ['E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'G' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'Km' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'lam' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What are G and K for E = 200 GPa and ν = 0.29?', 'answer' => 'ν = 0.29 gives G = 77.5194 GPa (11,243.2 ksi) and K = 158.73 GPa (23,021.9 ksi).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pair" label="I know" :options="['Enu' => 'E and ν', 'EG' => 'E and G', 'EK' => 'E and K', 'Gnu' => 'G and ν', 'Knu' => 'K and ν', 'KG' => 'K and G', 'lG' => 'λ and G']" selected="Enu" />
        <div data-show-when="pair:Enu,EG,EK">
            <x-calc.field name="E" label="Young's modulus E" value="200" min="0" placeholder="Young's modulus E">
                <label for="calc-E-unit" class="sr-only">Young's modulus E unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:EG,Gnu,KG,lG">
            <x-calc.field name="G" label="Shear modulus G" value="79.3" min="0" placeholder="Shear modulus G">
                <label for="calc-G-unit" class="sr-only">Shear modulus G unit</label>
                <select id="calc-G-unit" name="G-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:EK,Knu,KG">
            <x-calc.field name="Km" label="Bulk modulus K" value="160" min="0" placeholder="Bulk modulus K">
                <label for="calc-Km-unit" class="sr-only">Bulk modulus K unit</label>
                <select id="calc-Km-unit" name="Km-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:lG">
            <x-calc.field name="lam" label="Lamé λ" value="115" min="0" placeholder="Lamé λ">
                <label for="calc-lam-unit" class="sr-only">Lamé λ unit</label>
                <select id="calc-lam-unit" name="lam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="pair:Enu,Gnu,Knu">
            <x-calc.field name="nu" label="Poisson's ratio ν" value="0.29" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="gpa" />
    </div>

    <x-calc.result label="Young's modulus E" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'gpa', 'pair' => 'Enu', 'E' => 200, 'E-unit' => 'gpa', 'G' => 79.3, 'G-unit' => 'gpa', 'Km' => 160, 'Km-unit' => 'gpa', 'lam' => 115, 'lam-unit' => 'gpa', 'nu' => 0.29],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E' => ['label' => 'Young\'s modulus E'],
            'G' => ['label' => 'Shear modulus G'],
            'K' => ['label' => 'Bulk modulus K'],
            'lam' => ['label' => 'Lamé λ'],
            'M' => ['label' => 'P-wave modulus M'],
            'nu' => ['label' => 'Poisson\'s ratio ν'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
