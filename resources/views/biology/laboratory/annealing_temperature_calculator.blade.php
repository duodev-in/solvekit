<x-calc.page
    title="Annealing Temperature Calculator - SolveKit"
    description="Free PCR annealing temperature calculator: primer Tm by nearest-neighbour thermodynamics and the optimal annealing temperature."
    lede="Work out primer melting temperatures and the PCR annealing temperature."
    about="Primer Tm uses SantaLucia (1998) nearest-neighbour values with a salt correction for the sodium and primer concentrations. With the product length and GC% the annealing temperature follows Rychlik (1990); otherwise it is about 5 °C below the lower primer Tm. Polymerase kits may give their own rule, so follow theirs where it differs."
    :calc="['engine' => 'sequence', 'tool' => 'annealing', 'fields' => ['forward', 'reverse', 'sodium', 'primer', 'product_length', 'product_gc']]"
    :how-to="[
        ['name' => 'Paste both primers', 'text' => '5′ to 3′, bases only.'],
        ['name' => 'Check the buffer', 'text' => 'Na⁺ and primer concentrations of your reaction.'],
        ['name' => 'Add the product', 'text' => 'Length and GC% for the Rychlik formula.'],
    ]"
    :faqs="[
        ['question' => 'How far apart should primer Tms be?', 'answer' => 'Within about 5 °C, ideally 2 °C.'],
        ['question' => 'Why does my kit give a different Tm?', 'answer' => 'Formulas and salt corrections differ; use the kit\'s calculator for its own buffer.'],
        ['question' => 'What if I get non-specific bands?', 'answer' => 'Raise the annealing temperature in 2 °C steps or run a gradient.'],
    ]"
>
    <x-calc.textarea name="forward" label="Forward primer (5′→3′)" value="AGCGGATAACAATTTCACACAGGA" rows="2" />

    <x-calc.textarea name="reverse" label="Reverse primer (5′→3′)" value="GTAAAACGACGGCCAGT" rows="2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sodium" label="Na⁺" value="50" min="0" suffix="mM" />
        <x-calc.field name="primer" label="Primer" value="250" min="0" suffix="nM" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="product_length" label="Product length (optional)" value="500" min="0" suffix="bp" placeholder="Optional" />
        <x-calc.field name="product_gc" label="Product GC (optional)" value="50" min="0" max="100" suffix="%" placeholder="Optional" />
    </div>

    <x-calc.result label="Annealing temperature" />

    <x-calc.options :examples="[
        'M13 primers' => ['forward' => 'AGCGGATAACAATTTCACACAGGA', 'reverse' => 'GTAAAACGACGGCCAGT', 'sodium' => 50, 'primer' => 250, 'product_length' => 500, 'product_gc' => 50],
        'T7 / T7 term' => ['forward' => 'TAATACGACTCACTATAGGG', 'reverse' => 'GCTAGTTATTGCTCAGCGG', 'sodium' => 50, 'primer' => 250, 'product_length' => '', 'product_gc' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tm_forward' => ['label' => 'Forward primer Tm'],
            'tm_reverse' => ['label' => 'Reverse primer Tm'],
            'difference' => ['label' => 'Tm difference'],
            'product' => ['label' => 'Product Tm'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Tm = ΔH ÷ (ΔS + R ln(Cₜ ÷ 4)) − 273.15 (nearest neighbour)</li>
            <li>salt: ΔS + 0.368 × (N − 1) × ln[Na⁺]</li>
            <li>Ta = 0.3 × Tm(primer) + 0.7 × Tm(product) − 14.9</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
