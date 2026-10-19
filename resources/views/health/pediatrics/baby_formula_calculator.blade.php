<x-calc.page
    title="Baby Formula Calculator - SolveKit"
    description="Free baby formula calculator: how much formula a baby needs a day and per feed from weight (2.5 oz per lb, up to 32 oz)."
    lede="Work out how much formula your baby needs."
    about="The AAP (HealthyChildren.org) suggests babies take about 2.5 oz of formula per pound of body weight a day (about 165 mL/kg), up to a maximum of about 32 oz (960 mL). Newborns feed 8–12 times a day, older babies 6–8. Follow your baby's hunger and fullness cues, and make up formula exactly as the tin says. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'formula', 'fields' => ['weight', 'feeds'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter your baby\'s weight', 'text' => ''],
        ['name' => 'Enter feeds a day', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much formula does a 5.5 kg baby need over 7 feeds?', 'answer' => '30 oz (896 mL) (About 4.3 oz (128 mL) per feed over 7 feeds).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="5.5" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="feeds" label="Feeds a day" value="7" min="1" max="14" step="1" />
    </div>

    <x-calc.result label="Formula a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 5.5, 'weight-unit' => 'kg', 'feeds' => 7],
        'In pounds' => ['weight' => 10, 'weight-unit' => 'lb', 'feeds' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perFeed' => ['label' => 'Per feed'],
            'rule' => ['label' => 'Rule'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>oz/day = 2.5 × lb (max 32)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
