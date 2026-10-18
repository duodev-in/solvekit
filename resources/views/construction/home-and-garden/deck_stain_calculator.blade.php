<x-calc.page
    title="Deck Stain Calculator - SolveKit"
    description="Free deck stain calculator: gallons of deck stain or sealer for the deck boards, railings and steps, by coats and label coverage."
    lede="Work out how much stain a deck needs."
    about="Stain = area × coats ÷ coverage. Railings are counted on both sides and each step adds about 18 in of tread and riser. Coverage depends on the wood and product: most labels give 150–300 ft² per gallon, and rough or dry wood takes more."
    :calc="['engine' => 'con-finish', 'tool' => 'stain', 'fields' => ['deck_length', 'deck_width', 'rail_length', 'rail_height', 'stairs', 'stair_width', 'coverage', 'coats', 'price'], 'unitFields' => ['deck_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'deck_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'rail_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'rail_height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'stair_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the deck and railings', 'text' => 'And steps if any.'],
        ['name' => 'Enter the coverage and coats', 'text' => 'From the label.'],
    ]"
    :faqs="[
        ['question' => 'How much stain for a 16 × 12 deck?', 'answer' => 'About 1.8 gal per coat with 40 ft of railing and four steps at 250 ft²/gal.'],
        ['question' => 'Should I do two coats?', 'answer' => 'Follow the label: many semi-transparent stains need one or two thin coats.'],
        ['question' => 'How long should new wood weather?', 'answer' => 'Often a few weeks to months; check the stain maker.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="deck_length" label="Deck length" value="16" min="0" placeholder="Deck length">
            <label for="calc-deck_length-unit" class="sr-only">Deck length unit</label>
            <select id="calc-deck_length-unit" name="deck_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="deck_width" label="Deck width" value="12" min="0" placeholder="Deck width">
            <label for="calc-deck_width-unit" class="sr-only">Deck width unit</label>
            <select id="calc-deck_width-unit" name="deck_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rail_length" label="Railing length (optional)" value="40" min="0" placeholder="Railing length (optional)">
            <label for="calc-rail_length-unit" class="sr-only">Railing length (optional) unit</label>
            <select id="calc-rail_length-unit" name="rail_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rail_height" label="Railing height" value="36" min="0" placeholder="Railing height">
            <label for="calc-rail_height-unit" class="sr-only">Railing height unit</label>
            <select id="calc-rail_height-unit" name="rail_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stairs" label="Steps (optional)" value="4" min="0" step="1" />
        <x-calc.field name="stair_width" label="Step width" value="4" min="0" placeholder="Step width">
            <label for="calc-stair_width-unit" class="sr-only">Step width unit</label>
            <select id="calc-stair_width-unit" name="stair_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coverage" label="Coverage from the label" value="250" min="1" suffix="ft²/gal" />
        <x-calc.field name="coats" label="Coats" value="2" min="1" step="1" />
        <x-calc.field name="price" label="Price per gallon (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Stain needed" />

    <x-calc.options :examples="[
        '16 × 12 ft deck' => ['deck_length' => 16, 'deck_length-unit' => 'ft', 'deck_width' => 12, 'deck_width-unit' => 'ft', 'rail_length' => 40, 'rail_length-unit' => 'ft', 'rail_height' => 36, 'rail_height-unit' => 'in', 'stairs' => 4, 'stair_width' => 4, 'stair_width-unit' => 'ft', 'coverage' => 250, 'coats' => 2],
        'Floor only, one coat' => ['deck_length' => 20, 'deck_length-unit' => 'ft', 'deck_width' => 14, 'deck_width-unit' => 'ft', 'rail_length' => '', 'stairs' => 0, 'coverage' => 300, 'coats' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'buy' => ['label' => 'To buy'],
            'area' => ['label' => 'Surfaces'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area = deck + 2 × railing length × height + steps × width × 18 in</li>
            <li>gallons = area × coats ÷ coverage</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
