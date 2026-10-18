<x-calc.page
    title="Belt Size Calculator - SolveKit"
    description="Free belt size calculator: the belt size to buy from your pant waist size or a belt you own, in inches and centimeters."
    lede="Find the right belt size."
    about="A common maker's rule is to buy a belt 2 inches larger than your pant waist size: 34 in pants take a 36 belt. Belt size is measured from the fold of the buckle to the middle hole, so you can also measure a belt that fits you. Letter sizes vary by brand."
    :calc="['engine' => 'ev-clothing', 'tool' => 'belt', 'fields' => ['basis', 'waist'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pant size or a belt that fits.'],
        ['name' => 'Enter the size', 'text' => 'In inches or cm.'],
    ]"
    :faqs="[
        ['question' => 'What belt size for 34 waist pants?', 'answer' => 'Size 36.'],
        ['question' => 'How is a belt measured?', 'answer' => 'From the buckle fold to the middle hole.'],
        ['question' => 'What size is a medium belt?', 'answer' => 'Often 34–36, but it varies by brand.'],
    ]"
>
    <x-calc.segmented name="basis" legend="From" :options="['pants' => 'Pant waist size', 'belt_worn' => 'A belt that fits']" selected="pants" />

    <x-calc.field name="waist" label="Size" value="34" min="0" placeholder="Size">
        <label for="calc-waist-unit" class="sr-only">Size unit</label>
        <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Belt size" />

    <x-calc.options :decimals="false" :examples="[
        '34 in pants' => ['basis' => 'pants', 'waist' => 34, 'waist-unit' => 'in'],
        'Belt that fits: 95 cm' => ['basis' => 'belt_worn', 'waist' => 95, 'waist-unit' => 'cm'],
        '40 in pants' => ['basis' => 'pants', 'waist' => 40, 'waist-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'In cm'],
            'letter' => ['label' => 'Letter size'],
            'note' => ['label' => 'How belts are measured'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>belt = pant waist + 2 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
