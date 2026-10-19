<x-calc.page
    title="EVM Calculator - SolveKit"
    description="Free earned value management calculator: CV, SV, CPI, SPI, EAC, ETC, VAC and TCPI from budget at completion, planned value, earned value and actual cost (PMBOK)."
    lede="Measure project performance with earned value."
    about="Earned value (EV) is the budgeted cost of work done. Cost variance CV = EV − AC; schedule variance SV = EV − PV; CPI = EV ÷ AC; SPI = EV ÷ PV. Estimate at completion EAC = BAC ÷ CPI (if current cost performance continues); ETC = EAC − AC; VAC = BAC − EAC; TCPI = (BAC − EV) ÷ (BAC − AC). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'evm', 'fields' => ['bac', 'pv', 'ev', 'ac']]"
    :how-to="[
        ['name' => 'Enter BAC, PV, EV and AC', 'text' => ''],
        ['name' => 'Read the indexes', 'text' => 'Below 1 is unfavorable.'],
    ]"
    :faqs="[
        ['question' => 'How is a project doing with PV 200k, EV 180k and AC 210k on a 500k budget?', 'answer' => 'CPI 0.8571: Over budget, behind schedule (SPI 0.9); EAC 583,333.33.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bac" label="Budget at completion (BAC)" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="pv" label="Planned value (PV)" value="200000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ev" label="Earned value (EV)" value="180000" step="0.01" suffix="$" />
        <x-calc.field name="ac" label="Actual cost (AC)" value="210000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cost performance index (CPI)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bac' => 500000, 'pv' => 200000, 'ev' => 180000, 'ac' => 210000],
        'On track' => ['bac' => 500000, 'pv' => 200000, 'ev' => 210000, 'ac' => 195000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cv' => ['label' => 'Cost variance (CV)'],
            'sv' => ['label' => 'Schedule variance (SV)'],
            'spi' => ['label' => 'SPI'],
            'eac' => ['label' => 'EAC'],
            'etc' => ['label' => 'ETC'],
            'vac' => ['label' => 'VAC'],
            'tcpi' => ['label' => 'TCPI'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CPI = EV ÷ AC, SPI = EV ÷ PV</li>
            <li>EAC = BAC ÷ CPI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
