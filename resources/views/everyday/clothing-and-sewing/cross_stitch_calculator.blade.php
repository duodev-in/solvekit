<x-calc.page
    title="Cross-stitch Calculator - SolveKit"
    description="Free cross-stitch calculator: finished size of a cross-stitch design from its stitch count and Aida or evenweave fabric count, and the fabric to cut."
    lede="Work out the finished size of a cross-stitch design."
    about="Finished size = stitches ÷ fabric count (stitches per inch). On 28-count evenweave or linen stitched over two threads, the effective count is 14. Add a margin of about 3 inches on each side for framing."
    :calc="['engine' => 'ev-clothing', 'tool' => 'cross_stitch', 'fields' => ['stitches_w', 'stitches_h', 'count', 'over_two', 'margin'], 'unitFields' => ['margin' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the stitch count', 'text' => 'From the pattern.'],
        ['name' => 'Choose the fabric', 'text' => 'And the margin.'],
    ]"
    :faqs="[
        ['question' => 'How big is 140 × 180 stitches on 14-count?', 'answer' => '10 × 12.86 in.'],
        ['question' => 'What is 28-count over two?', 'answer' => 'The same size as 14-count Aida.'],
        ['question' => 'How much margin should I leave?', 'answer' => 'About 3 in each side for framing.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stitches_w" label="Stitches wide" value="140" min="1" step="1" />
        <x-calc.field name="stitches_h" label="Stitches high" value="180" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="count" label="Fabric count" :options="['11' => '11-count Aida', '14' => '14-count Aida', '16' => '16-count Aida', '18' => '18-count Aida', '25' => '25-count evenweave', '28' => '28-count evenweave', '32' => '32-count linen']" selected="14" />
        <x-calc.checkbox name="over_two" label="Stitched over two threads" :checked="false" />
        <x-calc.field name="margin" label="Margin each side" value="3" min="0" placeholder="Margin each side">
            <label for="calc-margin-unit" class="sr-only">Margin each side unit</label>
            <select id="calc-margin-unit" name="margin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Finished design size" />

    <x-calc.options :examples="[
        '140 × 180 on 14-count' => ['stitches_w' => 140, 'stitches_h' => 180, 'count' => '14', 'over_two' => false, 'margin' => 3, 'margin-unit' => 'in'],
        '28-count over two' => ['stitches_w' => 200, 'stitches_h' => 150, 'count' => '28', 'over_two' => true, 'margin' => 3, 'margin-unit' => 'in'],
        '18-count, metric margin' => ['stitches_w' => 90, 'stitches_h' => 90, 'count' => '18', 'over_two' => false, 'margin' => 8, 'margin-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'In cm'],
            'cut' => ['label' => 'Fabric to cut'],
            'stitches' => ['label' => 'Stitches'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size = stitches ÷ count</li>
            <li>cut = size + 2 × margin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
