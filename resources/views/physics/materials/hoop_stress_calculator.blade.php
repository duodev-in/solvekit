<x-calc.page
    title="Hoop Stress Calculator - SolveKit"
    description="Free hoop stress calculator: circumferential and longitudinal stress in pipes and pressure vessels, thin-wall and Lamé."
    lede="Find the hoop stress in a pipe."
    about="Internal pressure tries to split a pipe along its length; the resulting hoop stress is P r/t for thin walls, twice the longitudinal stress. Thick walls use the exact Lamé equation."
    :calc="['engine' => 'ph-mat', 'tool' => 'hoop_stress', 'fields' => ['P', 'd', 't', 'sy', 'out'], 'unitFields' => ['P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'sy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the hoop stress in a 500 mm pipe, 5 mm wall, at 10 bar?', 'answer' => '50.5 MPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Internal pressure" value="10" min="0" placeholder="Internal pressure">
            <label for="calc-P-unit" class="sr-only">Internal pressure unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'bar')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Inner diameter" value="500" placeholder="Inner diameter">
            <label for="calc-d-unit" class="sr-only">Inner diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Wall thickness" value="5" placeholder="Wall thickness">
            <label for="calc-t-unit" class="sr-only">Wall thickness unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sy" label="Allowable stress (optional)" value="138" min="0" placeholder="Allowable stress (optional)">
            <label for="calc-sy-unit" class="sr-only">Allowable stress (optional) unit</label>
            <select id="calc-sy-unit" name="sy-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
    </div>

    <x-calc.result label="Hoop stress (thin wall)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpa', 'P' => 10, 'P-unit' => 'bar', 'd' => 500, 'd-unit' => 'mm', 't' => 5, 't-unit' => 'mm', 'sy' => 138, 'sy-unit' => 'mpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'axial' => ['label' => 'Longitudinal stress (closed ends)'],
            'lame' => ['label' => 'Exact inner-surface hoop stress (Lamé)'],
            'ratio' => ['label' => 'Diameter ÷ thickness'],
            'fos' => ['label' => 'Utilisation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
