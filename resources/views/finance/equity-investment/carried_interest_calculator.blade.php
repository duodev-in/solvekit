<x-calc.page
    title="Carried Interest Calculator - SolveKit"
    description="Free carried interest calculator: the general partner's carry from a European waterfall with a preferred return (hurdle) and GP catch-up."
    lede="Work out carried interest in a fund waterfall."
    about="In a European (whole-fund) waterfall LPs first get their capital back, then a preferred return (often 8% a year compounded). With a full catch-up the GP then takes 100% until it has its carry share (often 20%) of all profit; the rest is split 80/20. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'carried_interest', 'fields' => ['capital', 'proceeds', 'hurdle', 'years', 'carry', 'catchup']]"
    :how-to="[
        ['name' => 'Enter capital and proceeds', 'text' => ''],
        ['name' => 'Enter hurdle, years and carry', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the carry on a $100M fund returning $200M after 5 years with an 8% hurdle?', 'answer' => '$20,000,000.00.'],
        ['question' => 'Without a catch-up?', 'answer' => '$10,613,438.46.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="capital" label="Capital contributed" value="100000000" step="0.01" suffix="$" />
        <x-calc.field name="proceeds" label="Total proceeds" value="200000000" step="0.01" suffix="$" />
        <x-calc.field name="hurdle" label="Preferred return" value="8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="years" label="Years held" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="carry" label="Carry" value="20" step="any" suffix="%" />
        <x-calc.select name="catchup" label="GP catch-up" :options="['full' => 'Full (100%)', 'none' => 'None']" selected="full" />
    </div>

    <x-calc.result label="Carried interest to the GP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['capital' => 100000000, 'proceeds' => 200000000, 'hurdle' => 8, 'years' => 5, 'carry' => 20, 'catchup' => 'full'],
        'No catch-up' => ['capital' => 100000000, 'proceeds' => 200000000, 'hurdle' => 8, 'years' => 5, 'carry' => 20, 'catchup' => 'none'],
        'Below hurdle' => ['capital' => 100000000, 'proceeds' => 130000000, 'hurdle' => 8, 'years' => 5, 'carry' => 20, 'catchup' => 'full'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'profit' => ['label' => 'Total profit'],
            'preferred' => ['label' => 'Preferred return'],
            'lp' => ['label' => 'LP profit'],
            'multiple' => ['label' => 'Multiples'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1. return capital</li>
            <li>2. preferred return to LPs</li>
            <li>3. GP catch-up</li>
            <li>4. split profits (carry %)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
