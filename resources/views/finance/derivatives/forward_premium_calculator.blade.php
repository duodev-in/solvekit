<x-calc.page
    title="Forward Premium Calculator - SolveKit"
    description="Free Forward Premium Calculator: premium = (F − S) ÷ S × 360 ÷ days. A positive figure is a forward premium, negative a discount, annualized on a 360-day year (365 for sterling)."
    lede="Work out the annualized forward premium from forward rate, spot rate and days to delivery."
    about="A positive figure is a forward premium, negative a discount, annualized on a 360-day year (365 for sterling). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'forward_premium', 'fields' => ['forward', 'spot', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Forward rate, Spot rate, Days to delivery.'],
        ['name' => 'Read the result', 'text' => 'The annualized forward premium appears as you type, with premium for the period below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the annualized forward premium?', 'answer' => 'Premium = (F − S) ÷ S × 360 ÷ days.'],
        ['question' => 'What is the annualized forward premium for forward rate 1.105, spot rate 1.09, days to delivery 90?', 'answer' => '5.505%. Premium for the period: 1.376%.'],
        ['question' => 'And for forward rate 149.2, spot rate 151.5, days to delivery 180?', 'answer' => '−3.036%. Premium for the period: −1.518%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Covered interest parity links it to the interest rate gap.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="forward" label="Forward rate" value="1.105" step="any" />
        <x-calc.field name="spot" label="Spot rate" value="1.09" step="any" />
        <x-calc.field name="days" label="Days to delivery" value="90" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Annualized forward premium" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['forward' => 1.105, 'spot' => 1.09, 'days' => 90],
        'Example B' => ['forward' => 149.2, 'spot' => 151.5, 'days' => 180],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Premium for the period'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>premium = (F − S) ÷ S × 360 ÷ days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
