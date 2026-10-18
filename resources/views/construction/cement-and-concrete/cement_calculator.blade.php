<x-calc.page
    title="Cement Calculator - SolveKit"
    description="Free cement calculator: bags of cement and the sand, aggregate and water for a concrete volume at a nominal mix such as 1:2:4 or 1:1.5:3."
    lede="Work out the cement, sand and aggregate for a concrete mix."
    about="Nominal mixes are proportions by volume of cement : sand : coarse aggregate. Because the wet concrete is smaller than its dry ingredients, site practice multiplies the wet volume by a dry-volume factor, usually 1.54 (a convention, not an exact value). Cement is taken at 1440 kg/m³. Designed mixes from a lab are more accurate than nominal ones."
    :calc="['engine' => 'con-concrete', 'tool' => 'cement', 'fields' => ['volume', 'mix', 'part_cement', 'part_sand', 'part_aggregate', 'dry', 'bag', 'wc'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Enter the concrete volume', 'text' => 'Wet, in place.'],
        ['name' => 'Choose the mix', 'text' => 'Or your own proportions.'],
        ['name' => 'Check the bag size', 'text' => 'And the water–cement ratio.'],
    ]"
    :faqs="[
        ['question' => 'How many bags of cement in 1 m³ of 1:2:4 concrete?', 'answer' => 'About 6.3 bags of 50 kg with the 1.54 factor.'],
        ['question' => 'Why multiply by 1.54?', 'answer' => 'Dry materials have air voids and shrink when mixed with water; 1.54 is the usual site allowance.'],
        ['question' => 'What water–cement ratio should I use?', 'answer' => 'About 0.45–0.55 for ordinary work; lower is stronger but harder to place.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Concrete volume" value="1" min="0" placeholder="Concrete volume">
            <label for="calc-volume-unit" class="sr-only">Concrete volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mix" label="Mix (cement : sand : aggregate)" :options="['1:1:2' => '1 : 1 : 2 (about M25)', '1:1.5:3' => '1 : 1.5 : 3 (about M20)', '1:2:4' => '1 : 2 : 4 (about M15)', '1:3:6' => '1 : 3 : 6 (about M10)', '1:4:8' => '1 : 4 : 8 (lean, M7.5)', 'custom' => 'My own proportions']" selected="1:2:4" />
    </div>

    <div data-show-when="mix:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="part_cement" label="Cement" value="1" min="0" step="0.1" />
            <x-calc.field name="part_sand" label="Sand" value="2" min="0" step="0.1" />
            <x-calc.field name="part_aggregate" label="Aggregate" value="4" min="0" step="0.1" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="dry" label="Dry-volume factor" value="1.54" min="1" step="0.01" />
        <x-calc.select name="bag" label="Cement bag" :options="collect(config('construction_data.bags.cement'))->map(fn ($b) => $b['name'])->all()" selected="kg_50" />
        <x-calc.field name="wc" label="Water–cement ratio" value="0.5" min="0" step="0.01" />
    </div>

    <x-calc.result label="Cement" />

    <x-calc.options :examples="[
        '1 m³ of 1:2:4' => ['volume' => 1, 'volume-unit' => 'm3', 'mix' => '1:2:4', 'dry' => 1.54, 'bag' => 'kg_50', 'wc' => 0.5],
        '2 yd³ of 1:1.5:3' => ['volume' => 2, 'volume-unit' => 'yd3', 'mix' => '1:1.5:3', 'dry' => 1.54, 'bag' => 'us_94', 'wc' => 0.45],
        'Lean mix 0.5 m³' => ['volume' => 0.5, 'volume-unit' => 'm3', 'mix' => '1:4:8', 'dry' => 1.54, 'bag' => 'kg_50', 'wc' => 0.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cement' => ['label' => 'Cement'],
            'sand' => ['label' => 'Sand'],
            'aggregate' => ['label' => 'Coarse aggregate'],
            'water' => ['label' => 'Water'],
            'dry' => ['label' => 'Dry volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dry volume = wet volume × 1.54</li>
            <li>part = dry volume × share ÷ sum of shares</li>
            <li>cement kg = cement m³ × 1440</li>
            <li>water = cement kg × w/c</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
