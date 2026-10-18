<x-calc.page
    title="Spindle Speed Calculator - SolveKit"
    description="Free spindle speed calculator: RPM from cutting speed (SFM or m/min) and diameter, with feed rate from teeth and chip load."
    lede="Work out spindle RPM and feed rate."
    about="RPM = cutting speed ÷ (π × diameter): 12 × SFM ÷ (π × D in inches), or 1000 × m/min ÷ (π × D in mm). Feed = RPM × teeth × chip load. Cutting speeds and chip loads come from the tool maker for your material; starting values are only a guide."
    :calc="['engine' => 'con-mech', 'tool' => 'spindle_speed', 'fields' => ['speed', 'speed_unit', 'diameter', 'teeth', 'chip'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'chip' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the cutting speed', 'text' => 'From the tool maker.'],
        ['name' => 'Enter the diameter', 'text' => 'Of the cutter, or the work on a lathe.'],
    ]"
    :faqs="[
        ['question' => 'What RPM for a ½ in end mill at 300 SFM?', 'answer' => 'About 2,292 RPM.'],
        ['question' => 'What is SFM?', 'answer' => 'Surface feet per minute: how fast the cutting edge moves.'],
        ['question' => 'How do I get the feed rate?', 'answer' => 'RPM × flutes × chip load: 2,292 × 4 × 0.002 = 18.3 in/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="speed" label="Cutting speed" value="300" min="0" />
        <x-calc.select name="speed_unit" label="Speed unit" :options="['sfm' => 'SFM (ft/min)', 'mmin' => 'm/min']" selected="sfm" />
        <x-calc.field name="diameter" label="Tool or work diameter" value="0.5" min="0" placeholder="Tool or work diameter">
            <label for="calc-diameter-unit" class="sr-only">Tool or work diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="teeth" label="Flutes or teeth (optional)" value="4" min="0" step="1" />
        <x-calc.field name="chip" label="Chip load per tooth (optional)" value="0.002" min="0" placeholder="Chip load per tooth (optional)">
            <label for="calc-chip-unit" class="sr-only">Chip load per tooth (optional) unit</label>
            <select id="calc-chip-unit" name="chip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Spindle speed" />

    <x-calc.options :examples="[
        '½ in end mill, 300 SFM' => ['speed' => 300, 'speed_unit' => 'sfm', 'diameter' => 0.5, 'diameter-unit' => 'in', 'teeth' => 4, 'chip' => 0.002, 'chip-unit' => 'in'],
        '10 mm, 120 m/min' => ['speed' => 120, 'speed_unit' => 'mmin', 'diameter' => 10, 'diameter-unit' => 'mm', 'teeth' => 3, 'chip' => 0.05, 'chip-unit' => 'mm'],
        'Lathe, 2 in bar at 400 SFM' => ['speed' => 400, 'speed_unit' => 'sfm', 'diameter' => 2, 'diameter-unit' => 'in', 'teeth' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'feed' => ['label' => 'Feed rate'],
            'sfm' => ['label' => 'Cutting speed'],
            'exact' => ['label' => 'Exact RPM'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RPM = 12 × SFM ÷ (π × D)</li>
            <li>RPM = 1000 × vc ÷ (π × D mm)</li>
            <li>feed = RPM × z × fz</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
