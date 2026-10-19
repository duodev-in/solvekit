<x-calc.page
    title="LGD Calculator – Loss Given Default - SolveKit"
    description="Free LGD Calculator – Loss Given Default: LGD = EAD × (1 − recovery). Loss given default is what a lender loses if the borrower defaults, after recoveries (Basel framework)."
    lede="Work out the loss given default from exposure at default, recovery rate and probability of default (optional)."
    about="Loss given default is what a lender loses if the borrower defaults, after recoveries (Basel framework). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lgd', 'fields' => ['ead', 'recovery', 'pd']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Exposure at default, Recovery rate, Probability of default (optional).'],
        ['name' => 'Read the result', 'text' => 'The loss given default appears as you type, with LGD rate, expected loss below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the loss given default?', 'answer' => 'LGD = EAD × (1 − recovery); expected loss = PD × LGD.'],
        ['question' => 'What is the loss given default for exposure at default $100,000, recovery rate 40%, probability of default 2%?', 'answer' => '$60,000.00. LGD rate: 60%.'],
        ['question' => 'And for exposure at default $250,000, recovery rate 65%, probability of default 1%?', 'answer' => '$87,500.00. LGD rate: 35%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Senior secured loans usually recover more than unsecured bonds.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ead" label="Exposure at default" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="recovery" label="Recovery rate" value="40" step="any" suffix="%" />
        <x-calc.field name="pd" label="Probability of default (optional)" value="2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Loss given default" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ead' => 100000, 'recovery' => 40, 'pd' => 2],
        'Example B' => ['ead' => 250000, 'recovery' => 65, 'pd' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'LGD rate'],
            'r2' => ['label' => 'Expected loss'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LGD = EAD × (1 − recovery)</li>
            <li>expected loss = PD × LGD</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
