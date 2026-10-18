<x-calc.page
    title="Standing Desk Height Calculator - SolveKit"
    description="Free standing desk height calculator: the right standing desk and monitor height for your height, or from your measured elbow height."
    lede="Find the right height for a standing desk."
    about="A standing desk should be at standing elbow height with the forearms level. From average body proportions (Drillis and Contini), standing elbow height ≈ 0.63 × height and eye height ≈ 0.936 × height, plus shoes. Measuring your own elbow height is more accurate; alternate sitting and standing through the day."
    :calc="['engine' => 'ev-office', 'tool' => 'standing_desk', 'fields' => ['height', 'shoes', 'elbow'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'shoes' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'elbow' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter your height', 'text' => 'Or measure your elbow height standing.'],
        ['name' => 'Set the desk and monitor', 'text' => 'From the results.'],
    ]"
    :faqs="[
        ['question' => 'What standing desk height for 175 cm?', 'answer' => 'About 113 cm (44.4 in) with 2.5 cm shoes.'],
        ['question' => 'How high should the monitor be?', 'answer' => 'Top of the screen at or slightly below eye level.'],
        ['question' => 'How long should I stand?', 'answer' => 'Alternate: change position every 30–60 minutes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Your height" value="175" min="0" placeholder="Your height">
            <label for="calc-height-unit" class="sr-only">Your height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="shoes" label="Shoe height" value="2.5" min="0" placeholder="Shoe height">
            <label for="calc-shoes-unit" class="sr-only">Shoe height unit</label>
            <select id="calc-shoes-unit" name="shoes-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="elbow" label="Standing elbow height (optional)" value="" min="0" placeholder="Standing elbow height (optional)">
            <label for="calc-elbow-unit" class="sr-only">Standing elbow height (optional) unit</label>
            <select id="calc-elbow-unit" name="elbow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Standing desk height" />

    <x-calc.options :examples="[
        '175 cm' => ['height' => 175, 'height-unit' => 'cm', 'shoes' => 2.5, 'shoes-unit' => 'cm', 'elbow' => '', 'elbow-unit' => 'cm'],
        '6 ft' => ['height' => 72, 'height-unit' => 'in', 'shoes' => 1, 'shoes-unit' => 'in', 'elbow' => '', 'elbow-unit' => 'in'],
        'Measured 105 cm' => ['height' => 168, 'height-unit' => 'cm', 'shoes' => 2, 'shoes-unit' => 'cm', 'elbow' => 105, 'elbow-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'monitor' => ['label' => 'Monitor'],
            'seated' => ['label' => 'When sitting'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>desk ≈ 0.63 × height + shoes</li>
            <li>eye ≈ 0.936 × height + shoes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
