<x-calc.page
    title="Body Shape Calculator - SolveKit"
    description="Free body shape calculator: hourglass, pear, apple, rectangle or inverted triangle from bust, waist and hip measurements."
    lede="Find your body shape for clothing fit."
    about="Shapes follow the FFIT for Apparel rules (Lee et al. 2007), which compare bust, waist, high hip and hip differences in inches: for example an hourglass has bust and hips within an inch and a waist at least 9 in smaller. Shapes describe proportions for clothing fit, not health. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'body_shape', 'fields' => ['bust', 'waist', 'high_hip', 'hips'], 'unitFields' => ['bust' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'high_hip' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'hips' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure bust, waist, high hip and hips', 'text' => 'High hip is about 7 in below the waist.'],
    ]"
    :faqs="[
        ['question' => 'What shape is 92–72–98?', 'answer' => 'Hourglass.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bust" label="Bust" value="92" min="0" placeholder="Bust">
            <label for="calc-bust-unit" class="sr-only">Bust unit</label>
            <select id="calc-bust-unit" name="bust-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waist" label="Waist" value="72" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="high_hip" label="High hip" value="88" min="0" placeholder="High hip">
            <label for="calc-high_hip-unit" class="sr-only">High hip unit</label>
            <select id="calc-high_hip-unit" name="high_hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hips" label="Hips" value="98" min="0" placeholder="Hips">
            <label for="calc-hips-unit" class="sr-only">Hips unit</label>
            <select id="calc-hips-unit" name="hips-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Body shape" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bust' => 92, 'bust-unit' => 'cm', 'waist' => 72, 'waist-unit' => 'cm', 'high_hip' => 88, 'high_hip-unit' => 'cm', 'hips' => 98, 'hips-unit' => 'cm'],
        'Straight' => ['bust' => 88, 'bust-unit' => 'cm', 'waist' => 78, 'waist-unit' => 'cm', 'high_hip' => 86, 'high_hip-unit' => 'cm', 'hips' => 90, 'hips-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bustHips' => ['label' => 'Bust − hips'],
            'hipsWaist' => ['label' => 'Hips − waist'],
            'bustWaist' => ['label' => 'Bust − waist'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FFIT shape rules</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
