<x-calc.page
    title="Linear Inches Calculator - SolveKit"
    description="Free linear inches calculator: total linear inches (length + width + height) of luggage or a package and whether it fits an airline's size limit."
    lede="Check whether your bag fits an airline's size limit."
    about="Linear inches (or linear dimensions) = length + width + height, measured with wheels and handles. Many airlines allow 62 linear inches (158 cm) for checked bags, but limits vary, so check your airline before you fly."
    :calc="['engine' => 'ev-care', 'tool' => 'linear_inches', 'fields' => ['length', 'width', 'height', 'limit'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'limit' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the bag', 'text' => 'Including wheels and handles.'],
        ['name' => 'Enter the limit', 'text' => 'From your airline.'],
    ]"
    :faqs="[
        ['question' => 'Is a 27 × 18 × 11 in suitcase within 62 linear inches?', 'answer' => 'Yes, 56 linear inches.'],
        ['question' => 'What is 62 linear inches in cm?', 'answer' => '158 cm.'],
        ['question' => 'What are carry-on limits?', 'answer' => 'Often 22 × 14 × 9 in (45 linear in), but they vary.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="27" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="18" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="11" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="limit" label="Limit" value="62" min="0" placeholder="Limit">
        <label for="calc-limit-unit" class="sr-only">Limit unit</label>
        <select id="calc-limit-unit" name="limit-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Total dimensions" />

    <x-calc.options :examples="[
        'Checked bag 27 × 18 × 11' => ['length' => 27, 'length-unit' => 'in', 'width' => 18, 'width-unit' => 'in', 'height' => 11, 'height-unit' => 'in', 'limit' => 62, 'limit-unit' => 'in'],
        'Large 30 × 20 × 13' => ['length' => 30, 'length-unit' => 'in', 'width' => 20, 'width-unit' => 'in', 'height' => 13, 'height-unit' => 'in', 'limit' => 62, 'limit-unit' => 'in'],
        'Carry-on 55 × 40 × 20 cm' => ['length' => 55, 'length-unit' => 'cm', 'width' => 40, 'width-unit' => 'cm', 'height' => 20, 'height-unit' => 'cm', 'limit' => 115, 'limit-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'limit' => ['label' => 'Limit check'],
            'note' => ['label' => 'Typical limits'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>linear = L + W + H</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
