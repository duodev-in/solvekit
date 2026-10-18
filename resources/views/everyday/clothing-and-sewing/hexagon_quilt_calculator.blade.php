<x-calc.page
    title="Hexagon Quilt Calculator - SolveKit"
    description="Free hexagon quilt calculator: how many hexagons cover a quilt top from the hexagon side length, with hexagon dimensions and fabric."
    lede="Count the hexagons for a hexagon quilt."
    about="A regular hexagon with side s measures 2s from point to point and √3 × s from flat side to flat side. In a grid of flat-topped hexagons, columns repeat every 1.5 s and rows every √3 × s, so the quilt needs about ⌈width ÷ 1.5s⌉ + 1 columns and ⌈height ÷ √3s⌉ + 1 rows, trimmed at the edges. For English paper piecing, cut fabric with about ⅜ in extra all round."
    :calc="['engine' => 'ev-clothing', 'tool' => 'hexagons', 'fields' => ['width', 'height', 'side', 'allowance'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'side' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'allowance' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the quilt size', 'text' => 'Finished size.'],
        ['name' => 'Enter the hexagon side', 'text' => 'From the paper template.'],
    ]"
    :faqs="[
        ['question' => 'How many 2 in hexagons for a 60 × 72 in quilt?', 'answer' => 'About 484 (22 columns × 22 rows), trimmed at the edges.'],
        ['question' => 'How big is a 2 in hexagon?', 'answer' => '4 in point to point, 3.46 in flat to flat.'],
        ['question' => 'What is English paper piecing?', 'answer' => 'Fabric is basted around paper templates and the hexagons are whip-stitched together.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Quilt width" value="60" min="0" placeholder="Quilt width">
            <label for="calc-width-unit" class="sr-only">Quilt width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Quilt length" value="72" min="0" placeholder="Quilt length">
            <label for="calc-height-unit" class="sr-only">Quilt length unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="side" label="Hexagon side" value="2" min="0" placeholder="Hexagon side">
            <label for="calc-side-unit" class="sr-only">Hexagon side unit</label>
            <select id="calc-side-unit" name="side-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="allowance" label="Fabric allowance around each" value="0.375" min="0" placeholder="Fabric allowance around each">
        <label for="calc-allowance-unit" class="sr-only">Fabric allowance around each unit</label>
        <select id="calc-allowance-unit" name="allowance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Hexagons to cover the quilt" />

    <x-calc.options :examples="[
        '60 × 72 in, 2 in sides' => ['width' => 60, 'width-unit' => 'in', 'height' => 72, 'height-unit' => 'in', 'side' => 2, 'side-unit' => 'in', 'allowance' => 0.375, 'allowance-unit' => 'in'],
        'Baby quilt, 1½ in' => ['width' => 36, 'width-unit' => 'in', 'height' => 48, 'height-unit' => 'in', 'side' => 1.5, 'side-unit' => 'in', 'allowance' => 0.375, 'allowance-unit' => 'in'],
        'Metric' => ['width' => 150, 'width-unit' => 'cm', 'height' => 200, 'height-unit' => 'cm', 'side' => 5, 'side-unit' => 'cm', 'allowance' => 1, 'allowance-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'size' => ['label' => 'Hexagon size'],
            'fabric' => ['label' => 'Fabric'],
            'area' => ['label' => 'Area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>columns = ⌈W ÷ 1.5s⌉ + 1, rows = ⌈H ÷ √3 s⌉ + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
