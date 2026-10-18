<x-calc.page
    title="Board Foot Calculator - SolveKit"
    description="Free board feet calculator: lumber board feet and log scale (Doyle, Scribner, International ¼″)."
    lede="Work out board feet for lumber, or estimate a log's volume with the standard log rules."
    about="A board foot is 144 cubic inches: 1 in × 12 in × 1 ft. For logs, the Doyle, Scribner and International ¼-inch rules estimate the lumber a log will saw out; Doyle underestimates small logs, International is the most accurate. Scribner here uses its standard formula approximation, which can read up to about 10% below the printed Scribner tables."
    :calc="['engine' => 'forestry', 'tool' => 'board_feet', 'fields' => ['mode', 'thickness', 'width', 'length', 'pieces', 'price', 'log_diameter', 'log_length', 'scale'], 'unitFields' => ['thickness' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'log_diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'log_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Choose lumber or log', 'text' => 'Lumber for sawn boards, log to estimate a log before sawing.'],
        ['name' => 'Enter the sizes', 'text' => 'Nominal sizes for lumber; small-end diameter inside the bark for logs.'],
    ]"
    :faqs="[
        ['question' => 'How many board feet in a 2×6×8?', 'answer' => '8 board feet.'],
        ['question' => 'Which log rule should I use?', 'answer' => 'Use the rule your buyer uses; Doyle is common in the US South and Midwest.'],
        ['question' => 'Why do log rules disagree?', 'answer' => 'They allow differently for saw kerf, slabs and taper.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Measure" :options="['lumber' => 'Lumber', 'log' => 'Log']" selected="lumber" />

    <div data-show-when="mode:lumber">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="thickness" label="Thickness" value="2" min="0" placeholder="Thickness">
                <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
                <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="6" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="length" label="Length" value="8" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="pieces" label="Pieces" value="10" min="1" step="1" />
        </div>
    </div>

    <div data-show-when="mode:lumber">
        <x-calc.field name="price" label="Price per board foot (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <div data-show-when="mode:log" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="log_diameter" label="Small-end diameter" value="16" min="0" placeholder="Small-end diameter">
                <label for="calc-log_diameter-unit" class="sr-only">Small-end diameter unit</label>
                <select id="calc-log_diameter-unit" name="log_diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="log_length" label="Log length" value="16" min="0" placeholder="Log length">
                <label for="calc-log_length-unit" class="sr-only">Log length unit</label>
                <select id="calc-log_length-unit" name="log_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.select name="scale" label="Log rule" :options="['doyle' => 'Doyle', 'scribner' => 'Scribner', 'international' => 'International ¼″']" selected="international" />
        </div>
    </div>

    <x-calc.result label="Board feet" />

    <x-calc.options :examples="[
        '10 boards 2×6×8' => ['mode' => 'lumber', 'thickness' => 2, 'width' => 6, 'length' => 8, 'pieces' => 10],
        'Log 16 in × 16 ft' => ['mode' => 'log', 'log_diameter' => 16, 'log_length' => 16, 'scale' => 'doyle'],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:lumber">
            <x-calc.rows heading="Details" :rows="[
                'm3' => ['label' => 'Cubic meters', 'unit' => 'm³'],
                'cost' => ['label' => 'Cost'],
            ]" />
        </div>
        <div data-show-when="mode:log" hidden>
            <x-calc.rows heading="By log rule" :rows="[
                'doyle' => ['label' => 'Doyle', 'unit' => 'bf'],
                'scribner' => ['label' => 'Scribner', 'unit' => 'bf'],
                'international' => ['label' => 'International ¼″', 'unit' => 'bf'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lumber: bf = T (in) × W (in) × L (ft) ÷ 12</li>
            <li>Doyle = (D − 4)² × L ÷ 16</li>
            <li>Scribner ≈ (0.79D² − 2D − 4) × L ÷ 16 (formula approximation)</li>
            <li>International ¼″ = Σ (0.22D² − 0.71D) per 4 ft</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
