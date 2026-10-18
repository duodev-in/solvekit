<x-calc.page
    title="Bra Size Calculator - SolveKit"
    description="Free bra size calculator: band and cup size from underbust and bust measurements, in US, UK, EU, French and Australian sizes, with sister sizes."
    lede="Find your bra size from two measurements."
    about="There are two measuring methods. The modern one, used by many fitters, takes the underbust to the nearest even inch as the band; the traditional one adds 4 inches (5 if odd), and most brand and country conversion charts are built on it. Either way the cup is the bust minus the band in whole inches (1 = A, 2 = B, 3 = C, 4 = D, 5 = DD), and US and UK cups differ after DD. European sizes (EN 13402) use the underbust in centimeters rounded to 5, with a cup letter for each 2 cm of difference from 12 cm (A). Brands fit differently, so treat both as a starting point."
    :calc="['engine' => 'ev-clothing', 'tool' => 'bra', 'fields' => ['underbust', 'bust', 'leaning'], 'unitFields' => ['underbust' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'bust' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'leaning' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure under the bust', 'text' => 'Snug and level.'],
        ['name' => 'Measure around the fullest part', 'text' => 'Standing, and leaning forward if you like.'],
    ]"
    :faqs="[
        ['question' => 'What size is a 32 in underbust and 37 in bust?', 'answer' => '32DD by modern measuring, 36A by the traditional +4 method, and 80A in European sizes.'],
        ['question' => 'What are sister sizes?', 'answer' => 'A band size up with a cup down (or the reverse) has the same cup volume.'],
        ['question' => 'Why are US and UK cups different?', 'answer' => 'After DD, US uses DDD/F, G, H; UK uses E, F, FF, G.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="underbust" label="Underbust (snug)" value="32" min="0" placeholder="Underbust (snug)">
            <label for="calc-underbust-unit" class="sr-only">Underbust (snug) unit</label>
            <select id="calc-underbust-unit" name="underbust-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bust" label="Bust (standing)" value="37" min="0" placeholder="Bust (standing)">
            <label for="calc-bust-unit" class="sr-only">Bust (standing) unit</label>
            <select id="calc-bust-unit" name="bust-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="leaning" label="Bust leaning forward (optional)" value="" min="0" placeholder="Bust leaning forward (optional)">
            <label for="calc-leaning-unit" class="sr-only">Bust leaning forward (optional) unit</label>
            <select id="calc-leaning-unit" name="leaning-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="US size (modern measuring)" />

    <x-calc.options :decimals="false" :examples="[
        '32 / 37 in' => ['underbust' => 32, 'underbust-unit' => 'in', 'bust' => 37, 'bust-unit' => 'in', 'leaning' => '', 'leaning-unit' => 'in'],
        '75 / 90 cm' => ['underbust' => 75, 'underbust-unit' => 'cm', 'bust' => 90, 'bust-unit' => 'cm', 'leaning' => '', 'leaning-unit' => 'cm'],
        '34 / 39 in, leaning 41' => ['underbust' => 34, 'underbust-unit' => 'in', 'bust' => 39, 'bust-unit' => 'in', 'leaning' => 41, 'leaning-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'uk' => ['label' => 'UK'],
            'old' => ['label' => 'Traditional method'],
            'eu' => ['label' => 'Europe'],
            'fr' => ['label' => 'France and Belgium'],
            'au' => ['label' => 'Australia'],
            'sister' => ['label' => 'Sister sizes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>band = underbust rounded to even inches</li>
            <li>cup = bust − band (in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
