<x-calc.page
    title="Desk Height Calculator - SolveKit"
    description="Free desk height calculator: the right desk, chair and monitor height for your height, or from your measured elbow height."
    lede="Find the right desk, chair and monitor height for you."
    about="A desk (or keyboard) should sit at seated elbow height with the shoulders relaxed and elbows at about 90°. From average body proportions (Pheasant, Bodyspace): seat height ≈ 0.25 × height, seated elbow ≈ 0.14 × height above the seat, seated eye ≈ 0.455 × height above the seat, plus shoes. Measuring your own seated elbow height is more accurate."
    :calc="['engine' => 'ev-office', 'tool' => 'desk_height', 'fields' => ['height', 'shoes', 'elbow'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'shoes' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'elbow' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter your height', 'text' => 'Or measure your seated elbow height from the floor.'],
        ['name' => 'Set up chair and monitor', 'text' => 'From the results.'],
    ]"
    :faqs="[
        ['question' => 'What desk height for someone 175 cm tall?', 'answer' => 'About 71 cm (28 in) with 2.5 cm shoes.'],
        ['question' => 'How high should my monitor be?', 'answer' => 'Top of the screen at or slightly below eye level.'],
        ['question' => 'My desk is too high: what can I do?', 'answer' => 'Raise the chair and use a footrest, or add a keyboard tray.'],
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
        <x-calc.field name="elbow" label="Seated elbow height (optional)" value="" min="0" placeholder="Seated elbow height (optional)">
            <label for="calc-elbow-unit" class="sr-only">Seated elbow height (optional) unit</label>
            <select id="calc-elbow-unit" name="elbow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Desk (keyboard) height" />

    <x-calc.options :examples="[
        '175 cm' => ['height' => 175, 'height-unit' => 'cm', 'shoes' => 2.5, 'shoes-unit' => 'cm', 'elbow' => '', 'elbow-unit' => 'cm'],
        '5 ft 4 in' => ['height' => 64, 'height-unit' => 'in', 'shoes' => 1, 'shoes-unit' => 'in', 'elbow' => '', 'elbow-unit' => 'in'],
        'Measured elbow 70 cm' => ['height' => 180, 'height-unit' => 'cm', 'shoes' => 2.5, 'shoes-unit' => 'cm', 'elbow' => 70, 'elbow-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'chair' => ['label' => 'Chair'],
            'monitor' => ['label' => 'Monitor'],
            'standard' => ['label' => 'Standard desk'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>desk ≈ 0.39 × height + shoes (seated elbow)</li>
            <li>chair ≈ 0.25 × height + shoes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
