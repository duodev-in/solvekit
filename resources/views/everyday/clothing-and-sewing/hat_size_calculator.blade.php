<x-calc.page
    title="Hat Size Calculator - SolveKit"
    description="Free hat size calculator: US, UK, European and letter hat sizes from your head circumference."
    lede="Find your hat size from a head measurement."
    about="Measure around the head just above the ears and across the forehead. US hat sizes are the head circumference in inches ÷ π, to the nearest ⅛ (a 22½ in head is 7⅛). UK sizes run ⅛ smaller, and European sizes are the circumference in centimeters. Letter sizes are each brand's grouping."
    :calc="['engine' => 'ev-clothing', 'tool' => 'hat', 'fields' => ['head'], 'unitFields' => ['head' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure your head', 'text' => 'Above the ears, across the forehead.'],
    ]"
    :faqs="[
        ['question' => 'What hat size is 22.5 inches?', 'answer' => 'US 7⅛, UK 7, European 57.'],
        ['question' => 'How do I measure for a hat?', 'answer' => 'Around the widest part, about ⅛ in above the ears.'],
        ['question' => 'Between sizes?', 'answer' => 'Choose the larger and add sizing tape.'],
    ]"
>
    <x-calc.field name="head" label="Head circumference" value="22.5" min="0" placeholder="Head circumference">
        <label for="calc-head-unit" class="sr-only">Head circumference unit</label>
        <select id="calc-head-unit" name="head-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Hat size" />

    <x-calc.options :decimals="false" :examples="[
        '22½ in' => ['head' => 22.5, 'head-unit' => 'in'],
        '58 cm' => ['head' => 58, 'head-unit' => 'cm'],
        'Child 20 in' => ['head' => 20, 'head-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'uk' => ['label' => 'UK size'],
            'eu' => ['label' => 'European size'],
            'letter' => ['label' => 'Letter size'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>US size = circumference (in) ÷ π</li>
            <li>EU = circumference (cm)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
