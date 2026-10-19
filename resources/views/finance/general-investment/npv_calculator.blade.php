<x-calc.page
    title="NPV Calculator – Net Present Value - SolveKit"
    description="Free NPV calculator: net present value of a series of cash flows at a discount rate, with the profitability index, IRR and a discounted cash-flow table."
    lede="Find the net present value of an investment."
    about="NPV = Σ CFₜ ÷ (1 + r)^t, with the initial investment as a negative cash flow at t = 0. A positive NPV means the project earns more than the discount rate, usually the cost of capital. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'npv', 'fields' => ['rate', 'flows']]"
    :how-to="[
        ['name' => 'Enter the discount rate', 'text' => 'Your cost of capital or required return.'],
        ['name' => 'List the cash flows', 'text' => 'The investment first, as a negative number.'],
    ]"
    :faqs="[
        ['question' => 'What is the NPV of −10,000 then 3,000, 4,200 and 6,800 at 8%?', 'answer' => '$1,776.66; IRR 16.34%.'],
        ['question' => 'And at 15%?', 'answer' => '$255.61.'],
    ]"
>
    <x-calc.field name="rate" label="Discount rate" value="8" step="any" suffix="%" />

    <x-calc.textarea name="flows" label="Cash flows, year 0 first (one per line)" value="-10000
3000
4200
6800" rows="6" />

    <x-calc.result label="Net present value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => 8, 'flows' => '-10000
3000
4200
6800'],
        'At 15%' => ['rate' => 15, 'flows' => '-10000
3000
4200
6800'],
        'Five years' => ['rate' => 10, 'flows' => '-50000
12000
14000
16000
18000
20000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'inflows' => ['label' => 'PV of later cash flows'],
            'investment' => ['label' => 'Initial cash flow'],
            'index' => ['label' => 'Profitability index'],
            'irr' => ['label' => 'IRR'],
        ]" />
        <x-calc.grid heading="Discounted cash flows" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NPV = Σ CFₜ ÷ (1 + r)^t, t = 0…n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
