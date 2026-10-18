<x-calc.page
    title="Material Removal Rate Calculator - SolveKit"
    description="Free material removal rate calculator: MRR for milling, turning and drilling in in³/min and cm³/min, with an optional power estimate."
    lede="Work out the material removal rate for milling, turning or drilling."
    about="Milling: MRR = width of cut × depth of cut × table feed. Turning: MRR = cutting speed × feed per revolution × depth of cut. Drilling: MRR = π ÷ 4 × D² × feed × RPM. Multiply by the material's unit power (hp per in³/min, from a machining handbook) for the power at the cutter."
    :calc="['engine' => 'con-mech', 'tool' => 'mrr', 'fields' => ['process', 'width', 'table', 'table_unit', 'speed', 'speed_unit', 'diameter', 'rpm', 'doc', 'feed', 'unit_power'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'doc' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'feed' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the process', 'text' => 'Milling, turning or drilling.'],
        ['name' => 'Enter the cutting values', 'text' => 'In any units.'],
    ]"
    :faqs="[
        ['question' => 'What is MRR in milling?', 'answer' => 'Width × depth × feed: 0.5 × 0.1 in × 20 in/min = 1 in³/min.'],
        ['question' => 'How is MRR used?', 'answer' => 'To compare strategies and estimate cutting power and time.'],
        ['question' => 'What is unit power?', 'answer' => 'Power needed per in³/min removed; about 0.3 hp for aluminum and 1–1.5 hp for steels.'],
    ]"
>
    <x-calc.select name="process" label="Process" :options="['milling' => 'Milling', 'turning' => 'Turning', 'drilling' => 'Drilling']" selected="milling" />

    <div data-show-when="process:milling">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="width" label="Width of cut" value="0.5" min="0" placeholder="Width of cut">
                <label for="calc-width-unit" class="sr-only">Width of cut unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="table" label="Table feed" value="20" min="0" />
            <x-calc.select name="table_unit" label="Feed unit" :options="['inmin' => 'in/min', 'mmmin' => 'mm/min']" selected="inmin" />
        </div>
    </div>

    <div data-show-when="process:turning" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="speed" label="Cutting speed" value="500" min="0" />
            <x-calc.select name="speed_unit" label="Speed unit" :options="['sfm' => 'SFM (ft/min)', 'mmin' => 'm/min']" selected="sfm" />
        </div>
    </div>

    <div data-show-when="process:drilling" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="diameter" label="Drill diameter" value="0.5" min="0" placeholder="Drill diameter">
                <label for="calc-diameter-unit" class="sr-only">Drill diameter unit</label>
                <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="rpm" label="RPM" value="1000" min="0" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="process:milling,turning">
            <x-calc.field name="doc" label="Depth of cut" value="0.1" min="0" placeholder="Depth of cut">
                <label for="calc-doc-unit" class="sr-only">Depth of cut unit</label>
                <select id="calc-doc-unit" name="doc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="process:turning,drilling" hidden>
            <x-calc.field name="feed" label="Feed per revolution" value="0.008" min="0" placeholder="Feed per revolution">
                <label for="calc-feed-unit" class="sr-only">Feed per revolution unit</label>
                <select id="calc-feed-unit" name="feed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.field name="unit_power" label="Unit power (optional)" value="" min="0" step="0.01" suffix="hp per in³/min" placeholder="From a handbook" />

    <x-calc.result label="Material removal rate" />

    <x-calc.options :examples="[
        'Milling ½ × 0.1 in at 20 in/min' => ['process' => 'milling', 'width' => 0.5, 'width-unit' => 'in', 'doc' => 0.1, 'doc-unit' => 'in', 'table' => 20, 'table_unit' => 'inmin'],
        'Turning 500 SFM' => ['process' => 'turning', 'speed' => 500, 'speed_unit' => 'sfm', 'feed' => 0.008, 'feed-unit' => 'in', 'doc' => 0.1, 'doc-unit' => 'in'],
        'Drilling ½ in at 1,000 RPM' => ['process' => 'drilling', 'diameter' => 0.5, 'diameter-unit' => 'in', 'rpm' => 1000, 'feed' => 0.008, 'feed-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm3' => ['label' => 'Cubic centimeters per minute'],
            'mm3' => ['label' => 'Cubic millimeters per second'],
            'power' => ['label' => 'Power at the cutter'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>milling: MRR = ae × ap × vf</li>
            <li>turning: MRR = vc × f × ap</li>
            <li>drilling: MRR = π ÷ 4 × D² × f × N</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
