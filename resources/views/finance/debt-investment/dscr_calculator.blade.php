<x-calc.page
    title="Debt Service Coverage Ratio Calculator (DSCR) - SolveKit"
    description="Free Debt Service Coverage Ratio Calculator (DSCR): DSCR = net operating income ÷ debt service. DSCR shows how many times income covers loan payments."
    lede="Work out the DSCR from net operating income and annual debt service (principal + interest)."
    about="DSCR shows how many times income covers loan payments. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dscr', 'fields' => ['noi', 'service']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net operating income, Annual debt service (principal + interest).'],
        ['name' => 'Read the result', 'text' => 'The DSCR appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the DSCR?', 'answer' => 'DSCR = net operating income ÷ debt service.'],
        ['question' => 'What is the DSCR for net operating income $150,000, annual debt service $110,000?', 'answer' => '1.364×.'],
        ['question' => 'And for net operating income $48,000, annual debt service $42,000?', 'answer' => '1.143×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Lenders commonly require 1.20–1.25 for commercial property loans.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="noi" label="Net operating income" value="150000" step="0.01" suffix="$" />
        <x-calc.field name="service" label="Annual debt service (principal + interest)" value="110000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="DSCR" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['noi' => 150000, 'service' => 110000],
        'Example B' => ['noi' => 48000, 'service' => 42000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DSCR = net operating income ÷ debt service</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
