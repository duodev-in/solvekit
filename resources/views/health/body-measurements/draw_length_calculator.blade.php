<x-calc.page
    title="Draw Length Calculator - SolveKit"
    description="Free draw length calculator: estimate archery draw length from your arm span."
    lede="Estimate your bow draw length."
    about="Stand with arms out to the sides, palms forward, and measure fingertip to fingertip. The archery rule of thumb (Archery Trade Association) is draw length ≈ arm span ÷ 2.5. A shop can check it against your form. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'draw_length', 'fields' => ['span'], 'unitFields' => ['span' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure your arm span', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What draw length does a 70 in arm span give?', 'answer' => '28.0 in.'],
    ]"
>
    <x-calc.field name="span" label="Arm span" value="178" min="0" placeholder="Arm span">
        <label for="calc-span-unit" class="sr-only">Arm span unit</label>
        <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Draw length" />

    <x-calc.options :decimals="false" :examples="[
        '70 in' => ['span' => 70, 'span-unit' => 'in'],
        '180 cm' => ['span' => 180, 'span-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bow' => ['label' => 'Bows'],
            'check' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>draw ≈ span ÷ 2.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
