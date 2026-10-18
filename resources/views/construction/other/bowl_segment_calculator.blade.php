<x-calc.page
    title="Bowl Segment Calculator - SolveKit"
    description="Free bowl segment calculator: miter angle, segment lengths and board length for a segmented woodturning ring."
    lede="Work out the cuts for a segmented bowl ring."
    about="n segments meet at 360° ÷ n, so each end is cut at 180° ÷ n. The segments form a polygon around the ring's outside circle: the outside length of each is D × tan(180° ÷ n) and the inside length (D − 2w) × tan(180° ÷ n). Cutting from a strip with alternating miters uses about n × the average length plus a kerf per cut."
    :calc="['engine' => 'con-trig', 'tool' => 'bowl_segment', 'fields' => ['segments', 'diameter', 'ring', 'kerf'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'ring' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'kerf' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter segments and ring size', 'text' => 'Outside diameter and width.'],
        ['name' => 'Enter the kerf', 'text' => 'For the board length.'],
    ]"
    :faqs="[
        ['question' => 'What angle for 12 segments?', 'answer' => '15° on each end.'],
        ['question' => 'How long is each segment for a 10 in ring?', 'answer' => 'About 2.68 in on the outside with 12 segments.'],
        ['question' => 'Why add to the diameter?', 'answer' => 'Leave a little extra so the turned ring cleans up.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="segments" label="Segments" value="12" min="3" step="1" />
        <x-calc.field name="diameter" label="Outside diameter" value="10" min="0" placeholder="Outside diameter">
            <label for="calc-diameter-unit" class="sr-only">Outside diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ring" label="Ring width" value="1.25" min="0" placeholder="Ring width">
            <label for="calc-ring-unit" class="sr-only">Ring width unit</label>
            <select id="calc-ring-unit" name="ring-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="kerf" label="Saw kerf" value="0.125" min="0" placeholder="Saw kerf">
        <label for="calc-kerf-unit" class="sr-only">Saw kerf unit</label>
        <select id="calc-kerf-unit" name="kerf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Miter angle" />

    <x-calc.options :examples="[
        '12 segments, 10 in' => ['segments' => 12, 'diameter' => 10, 'diameter-unit' => 'in', 'ring' => 1.25, 'ring-unit' => 'in', 'kerf' => 0.125, 'kerf-unit' => 'in'],
        '16 segments, 300 mm' => ['segments' => 16, 'diameter' => 300, 'diameter-unit' => 'mm', 'ring' => 30, 'ring-unit' => 'mm', 'kerf' => 3, 'kerf-unit' => 'mm'],
        '8 segments, 6 in' => ['segments' => 8, 'diameter' => 6, 'diameter-unit' => 'in', 'ring' => 1, 'ring-unit' => 'in', 'kerf' => 0.125, 'kerf-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'outer' => ['label' => 'Outside length'],
            'inner' => ['label' => 'Inside length'],
            'board' => ['label' => 'Board needed'],
            'polygon' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>miter = 180° ÷ n</li>
            <li>outside length = D tan(180° ÷ n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
