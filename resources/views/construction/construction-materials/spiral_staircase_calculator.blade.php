<x-calc.page
    title="Spiral Staircase Calculator - SolveKit"
    description="Free spiral staircase calculator: treads, riser height, tread angle and depth at the walkline and headroom, checked against IRC R311.7.10.1."
    lede="Work out the treads of a spiral staircase and check them against code."
    about="Risers divide the floor-to-floor height equally; the top landing is the last step, so there is one fewer tread. The rotation is shared between the treads. IRC R311.7.10.1 requires a 26 in clear width, treads at least 6¾ in deep at the walkline 12 in from the narrow edge, risers of 9½ in or less and 6 ft 6 in headroom."
    :calc="['engine' => 'con-framing', 'tool' => 'spiral', 'fields' => ['height', 'diameter', 'rotation', 'risers', 'pole', 'thickness'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'pole' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the height and diameter', 'text' => 'Floor to floor, and the overall diameter.'],
        ['name' => 'Set the rotation', 'text' => '360° is a full turn.'],
    ]"
    :faqs="[
        ['question' => 'How many treads in a spiral stair?', 'answer' => 'For 9 ft at 9½ in risers: 12 risers, 11 treads.'],
        ['question' => 'What diameter does a spiral stair need?', 'answer' => 'At least about 60 in to give the 26 in clear width the IRC requires.'],
        ['question' => 'Why add risers?', 'answer' => 'More, shorter risers make the stair easier to climb and may help headroom.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Floor-to-floor height" value="108" min="0" placeholder="Floor-to-floor height">
            <label for="calc-height-unit" class="sr-only">Floor-to-floor height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="diameter" label="Stair diameter" value="60" min="0" placeholder="Stair diameter">
            <label for="calc-diameter-unit" class="sr-only">Stair diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rotation" label="Rotation" value="360" min="90" step="15" suffix="°" />
        <x-calc.field name="risers" label="Risers (optional)" value="" min="2" step="1" placeholder="Fewest allowed" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pole" label="Center pole diameter" value="4.5" min="0" placeholder="Center pole diameter">
            <label for="calc-pole-unit" class="sr-only">Center pole diameter unit</label>
            <select id="calc-pole-unit" name="pole-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="thickness" label="Tread thickness" value="1.5" min="0" placeholder="Tread thickness">
            <label for="calc-thickness-unit" class="sr-only">Tread thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Spiral stair" />

    <x-calc.options :examples="[
        '60 in, 9 ft, full turn' => ['height' => 108, 'height-unit' => 'in', 'diameter' => 60, 'diameter-unit' => 'in', 'rotation' => 360, 'risers' => '', 'pole' => 4.5, 'pole-unit' => 'in', 'thickness' => 1.5, 'thickness-unit' => 'in'],
        '5 ft, 14 risers, 450°' => ['height' => 112, 'height-unit' => 'in', 'diameter' => 60, 'diameter-unit' => 'in', 'rotation' => 450, 'risers' => 14, 'pole' => 4.5, 'pole-unit' => 'in', 'thickness' => 1.5, 'thickness-unit' => 'in'],
        'Metric 1.6 m' => ['height' => 2.8, 'height-unit' => 'm', 'diameter' => 1.6, 'diameter-unit' => 'm', 'rotation' => 360, 'risers' => '', 'pole' => 114, 'pole-unit' => 'mm', 'thickness' => 40, 'thickness-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rise' => ['label' => 'Riser height'],
            'angle' => ['label' => 'Tread angle'],
            'walkline' => ['label' => 'Tread at walkline'],
            'headroom' => ['label' => 'Headroom'],
            'code' => ['label' => 'Code check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>risers = ⌈height ÷ 9½ in⌉</li>
            <li>tread angle = rotation ÷ (risers − 1)</li>
            <li>walkline depth = (pole radius + 12 in) × angle</li>
            <li>headroom = riser × 360 ÷ angle − tread thickness</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
