<x-calc.page
    title="Ladder Angle Calculator - SolveKit"
    description="Free ladder angle calculator: angle, height reached and base distance of a ladder, with the OSHA 4 to 1 rule."
    lede="Work out a ladder's angle and where to set its base."
    about="A leaning ladder forms a right triangle: angle = atan(height ÷ base). OSHA 1926.1053(b)(5)(i) sets the base out a quarter of the working length (a 4 : 1 ratio, about 75.5°). Side rails should also extend at least 3 ft above an upper landing."
    :calc="['engine' => 'con-framing', 'tool' => 'ladder', 'fields' => ['length', 'mode', 'base', 'height'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the ladder length', 'text' => 'The working length, extended.'],
        ['name' => 'Enter the base or height', 'text' => 'The other side is worked out.'],
    ]"
    :faqs="[
        ['question' => 'What angle should a ladder be?', 'answer' => 'About 75.5°: 1 ft out for every 4 ft of length.'],
        ['question' => 'How far out for a 20 ft ladder?', 'answer' => '5 ft.'],
        ['question' => 'How high does a 24 ft ladder reach at 4 : 1?', 'answer' => 'About 23 ft 3 in.'],
    ]"
>
    <x-calc.field name="length" label="Ladder working length" value="20" min="0" placeholder="Ladder working length">
        <label for="calc-length-unit" class="sr-only">Ladder working length unit</label>
        <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.segmented name="mode" legend="Known" :options="['base' => 'Base distance', 'height' => 'Height reached']" selected="base" />

    <div data-show-when="mode:base">
        <x-calc.field name="base" label="Base distance from the wall" value="5" min="0" placeholder="Base distance from the wall">
            <label for="calc-base-unit" class="sr-only">Base distance from the wall unit</label>
            <select id="calc-base-unit" name="base-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:height" hidden>
        <x-calc.field name="height" label="Height reached" value="18" min="0" placeholder="Height reached">
            <label for="calc-height-unit" class="sr-only">Height reached unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Ladder angle" />

    <x-calc.options :examples="[
        '20 ft ladder, 5 ft out' => ['length' => 20, 'length-unit' => 'ft', 'mode' => 'base', 'base' => 5, 'base-unit' => 'ft'],
        '24 ft ladder to 22 ft' => ['length' => 24, 'length-unit' => 'ft', 'mode' => 'height', 'height' => 22, 'height-unit' => 'ft'],
        '6 m ladder, 2 m out' => ['length' => 6, 'length-unit' => 'm', 'mode' => 'base', 'base' => 2, 'base-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'height' => ['label' => 'Height'],
            'base' => ['label' => 'Base'],
            'ideal' => ['label' => '4 : 1 setting'],
            'check' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>angle = atan(height ÷ base)</li>
            <li>height = √(length² − base²)</li>
            <li>4 : 1 rule: base = length ÷ 4</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
