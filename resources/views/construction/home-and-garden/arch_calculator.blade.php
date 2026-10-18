<x-calc.page
    title="Arch Calculator - SolveKit"
    description="Free arch calculator: radius, arc length and angle of a segmental arch from its span and rise, or span and radius, with the area under it."
    lede="Work out the radius and arc length of an arch."
    about="A segmental arch is part of a circle: radius = ((span ÷ 2)² + rise²) ÷ (2 × rise). The arc length is radius × angle, and the circle's center is radius − rise below the springing line, which is where to put the trammel point."
    :calc="['engine' => 'con-trig', 'tool' => 'arch', 'fields' => ['mode', 'span', 'rise', 'radius'], 'unitFields' => ['span' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'radius' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the span', 'text' => 'Width of the opening.'],
        ['name' => 'Enter the rise or radius', 'text' => 'The other is worked out.'],
    ]"
    :faqs="[
        ['question' => 'What radius for a 48 in span and 8 in rise?', 'answer' => '40 in.'],
        ['question' => 'How long is the arch trim?', 'answer' => 'The arc length: about 51.5 in for a 48 in span with 8 in rise.'],
        ['question' => 'What is a half-round arch?', 'answer' => 'One whose rise is half its span.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Know" :options="['rise' => 'Span and rise', 'radius' => 'Span and radius']" selected="rise" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Span" value="48" min="0" placeholder="Span">
            <label for="calc-span-unit" class="sr-only">Span unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:rise">
            <x-calc.field name="rise" label="Rise" value="8" min="0" placeholder="Rise">
                <label for="calc-rise-unit" class="sr-only">Rise unit</label>
                <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:radius" hidden>
        <x-calc.field name="radius" label="Radius" value="40" min="0" placeholder="Radius">
            <label for="calc-radius-unit" class="sr-only">Radius unit</label>
            <select id="calc-radius-unit" name="radius-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Arch radius" />

    <x-calc.options :examples="[
        '48 in span, 8 in rise' => ['mode' => 'rise', 'span' => 48, 'span-unit' => 'in', 'rise' => 8, 'rise-unit' => 'in'],
        'Half round 36 in' => ['mode' => 'rise', 'span' => 36, 'span-unit' => 'in', 'rise' => 18, 'rise-unit' => 'in'],
        '1.2 m span, 1 m radius' => ['mode' => 'radius', 'span' => 1.2, 'span-unit' => 'm', 'radius' => 1, 'radius-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'arc' => ['label' => 'Arc length'],
            'rise' => ['label' => 'Rise'],
            'angle' => ['label' => 'Arc angle'],
            'area' => ['label' => 'Area under the arch'],
            'center' => ['label' => 'Center'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = ((S ÷ 2)² + h²) ÷ 2h</li>
            <li>arc = r × 2 asin(S ÷ 2r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
