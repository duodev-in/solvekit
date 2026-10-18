<x-calc.page
    title="Gambrel Roof Calculator - SolveKit"
    description="Free gambrel roof calculator: lower and upper rafter lengths, angles, roof height and area for a barn-style gambrel roof."
    lede="Work out the rafters and height of a gambrel (barn) roof."
    about="A gambrel roof has a steep lower slope and a shallow upper slope each side. The classic layout puts four equal rafters on a half circle of the span, giving 67.5° and 22.5° slopes. Or set your own angles and where the slope breaks. Lengths are to the rafter lines."
    :calc="['engine' => 'con-roof', 'tool' => 'gambrel', 'fields' => ['span', 'length', 'method', 'lower_angle', 'upper_angle', 'lower_run'], 'unitFields' => ['span' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'lower_run' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the span', 'text' => 'And the building length for the roof area.'],
        ['name' => 'Choose the layout', 'text' => 'Half circle, or your own angles.'],
    ]"
    :faqs="[
        ['question' => 'What angles is a gambrel roof?', 'answer' => 'Classically 67.5° lower and 22.5° upper, from four equal rafters on a half circle.'],
        ['question' => 'How tall is a 16 ft gambrel?', 'answer' => '8 ft above the plates with the half-circle layout.'],
        ['question' => 'Why build a gambrel?', 'answer' => 'It gives more headroom in the loft than a gable of the same height.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Span" value="16" min="0" placeholder="Span">
            <label for="calc-span-unit" class="sr-only">Span unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Building length (optional)" value="20" min="0" placeholder="Building length (optional)">
            <label for="calc-length-unit" class="sr-only">Building length (optional) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="method" legend="Layout" :options="['semicircle' => 'Half circle (equal rafters)', 'custom' => 'My angles']" selected="semicircle" />

    <div data-show-when="method:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="lower_angle" label="Lower slope" value="60" min="1" max="89" suffix="°" />
            <x-calc.field name="upper_angle" label="Upper slope" value="25" min="1" max="89" suffix="°" />
            <x-calc.field name="lower_run" label="Lower run (in from wall)" value="3" min="0" placeholder="Lower run (in from wall)">
                <label for="calc-lower_run-unit" class="sr-only">Lower run (in from wall) unit</label>
                <select id="calc-lower_run-unit" name="lower_run-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Roof height" />

    <x-calc.options :examples="[
        '16 ft half circle' => ['span' => 16, 'span-unit' => 'ft', 'length' => 20, 'length-unit' => 'ft', 'method' => 'semicircle'],
        '24 ft, 60° and 25°' => ['span' => 24, 'span-unit' => 'ft', 'length' => 32, 'length-unit' => 'ft', 'method' => 'custom', 'lower_angle' => 60, 'upper_angle' => 25, 'lower_run' => 3, 'lower_run-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lower' => ['label' => 'Lower rafter'],
            'upper' => ['label' => 'Upper rafter'],
            'break' => ['label' => 'Slope break'],
            'area' => ['label' => 'Roof area'],
            'section' => ['label' => 'Gable end'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lower: run × tan(lower angle)</li>
            <li>upper: (span ÷ 2 − lower run) × tan(upper angle)</li>
            <li>half circle: each rafter = 2 R sin 22.5°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
