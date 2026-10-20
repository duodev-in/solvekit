<x-calc.page
    title="Stride Length Calculator - SolveKit"
    description="Free stride length calculator: step and stride length measured or estimated from height, with cadence."
    lede="Find your stride length."
    about="Count steps over a known distance for your true step length; a stride is two steps."
    :calc="['engine' => 'sp-run', 'tool' => 'stride', 'fields' => ['by', 'd', 'steps', 'h', 'pace', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What step length is 100 m in 130 steps?', 'answer' => '76.9231 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['measure' => 'Distance and steps', 'height' => 'Only my height']" selected="measure" />
        <div data-show-when="by:measure">
            <x-calc.field name="d" label="Distance covered" value="100" placeholder="Distance covered">
                <label for="calc-d-unit" class="sr-only">Distance covered unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:measure">
            <x-calc.field name="steps" label="Steps taken" value="130" min="1" step="any" />
        </div>
        <div data-show-when="by:height">
            <x-calc.field name="h" label="Height" value="170" placeholder="Height">
                <label for="calc-h-unit" class="sr-only">Height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="pace" label="Running pace per km (optional, m:ss)" value="5:30" type="text" inputmode="text" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Step length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'by' => 'measure', 'd' => 100, 'd-unit' => 'm', 'steps' => 130, 'h' => 170, 'h-unit' => 'cm', 'pace' => '5:30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'stride' => ['label' => 'Stride length (two steps)'],
            'cadence' => ['label' => 'Cadence at that pace'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
