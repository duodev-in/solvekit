<x-calc.page
    title="Exhaust Diameter Calculator - SolveKit"
    description="Free exhaust diameter calculator: a starting pipe size for single or dual exhausts from horsepower."
    lede="Estimate exhaust pipe size."
    about="Exhaust pipes are sized so the gas keeps a healthy speed: too small chokes power, too big loses velocity. This uses the common flow-per-horsepower rule and is an estimate."
    :calc="['engine' => 'ph-mach', 'tool' => 'exhaust', 'fields' => ['hp', 'layout', 'out'], 'unitFields' => ['hp' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What pipe suits 400 hp with dual exhausts?', 'answer' => 'About 2.31909 in each.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hp" label="Engine power" value="400" min="0" placeholder="Engine power">
            <label for="calc-hp-unit" class="sr-only">Engine power unit</label>
            <select id="calc-hp-unit" name="hp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="layout" label="System" :options="['single' => 'Single pipe', 'dual' => 'Dual pipes']" selected="dual" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
    </div>

    <x-calc.result label="Pipe inside diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'in', 'hp' => 400, 'hp-unit' => 'hp', 'layout' => 'dual'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'flow' => ['label' => 'Estimated exhaust flow'],
            'area' => ['label' => 'Total flow area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
