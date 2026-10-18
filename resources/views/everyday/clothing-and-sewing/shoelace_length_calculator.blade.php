<x-calc.page
    title="Shoelace Length Calculator - SolveKit"
    description="Free shoelace length calculator: the lace length for criss-cross lacing from the number of eyelet pairs, the gap between eyelet columns and the spacing between rows."
    lede="Work out the shoelace length your shoes need."
    about="For criss-cross lacing the lace runs once across the bottom pair, then diagonally between the columns for each row above: length = width + 2 × (pairs − 1) × √(width² + row spacing²), plus enough at each end to tie a bow. This follows Ian Fieggen's shoelace geometry. The nearest standard length is suggested."
    :calc="['engine' => 'ev-clothing', 'tool' => 'shoelace', 'fields' => ['pairs', 'width', 'spacing', 'ends'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'ends' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Count the eyelet pairs', 'text' => 'And measure the gaps.'],
        ['name' => 'Set the bow length', 'text' => 'About 10 in per end.'],
    ]"
    :faqs="[
        ['question' => 'How long should laces be for 6 eyelet pairs?', 'answer' => 'About 43 in for criss-cross lacing with these gaps: buy 45 in.'],
        ['question' => 'How do I measure the gap?', 'answer' => 'Across the shoe between eyelet centers, with the shoe laced.'],
        ['question' => 'What are standard lace lengths?', 'answer' => '27, 36, 40, 45, 54, 63 and 72 in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pairs" label="Eyelet pairs" value="6" min="2" max="14" step="1" />
        <x-calc.field name="width" label="Gap between columns" value="2" min="0" placeholder="Gap between columns">
            <label for="calc-width-unit" class="sr-only">Gap between columns unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spacing" label="Spacing between rows" value="0.6" min="0" placeholder="Spacing between rows">
            <label for="calc-spacing-unit" class="sr-only">Spacing between rows unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="ends" label="Length per end for the bow" value="10" min="0" placeholder="Length per end for the bow">
        <label for="calc-ends-unit" class="sr-only">Length per end for the bow unit</label>
        <select id="calc-ends-unit" name="ends-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Lace length" />

    <x-calc.options :examples="[
        'Sneaker, 6 pairs' => ['pairs' => 6, 'width' => 2, 'width-unit' => 'in', 'spacing' => 0.6, 'spacing-unit' => 'in', 'ends' => 10, 'ends-unit' => 'in'],
        'Boot, 8 pairs' => ['pairs' => 8, 'width' => 2.2, 'width-unit' => 'in', 'spacing' => 0.8, 'spacing-unit' => 'in', 'ends' => 10, 'ends-unit' => 'in'],
        'Dress shoe, metric' => ['pairs' => 5, 'width' => 3.5, 'width-unit' => 'cm', 'spacing' => 1.3, 'spacing-unit' => 'cm', 'ends' => 20, 'ends-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'buy' => ['label' => 'Buy'],
            'laced' => ['label' => 'Through the eyelets'],
            'note' => ['label' => 'Basis'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = w + 2(n − 1)√(w² + s²) + 2 × end</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
