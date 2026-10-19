<x-calc.page
    title="ROIC Calculator – Return on Invested Capital - SolveKit"
    description="Free ROIC Calculator – Return on Invested Capital: ROIC = NOPAT ÷ invested capital. Return on invested capital measures how well a company turns capital into operating profit."
    lede="Work out the ROIC from NOPAT and invested capital (debt + equity − cash)."
    about="Return on invested capital measures how well a company turns capital into operating profit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roic', 'fields' => ['nopat', 'capital']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'NOPAT, Invested capital (debt + equity − cash).'],
        ['name' => 'Read the result', 'text' => 'The ROIC appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ROIC?', 'answer' => 'ROIC = NOPAT ÷ invested capital.'],
        ['question' => 'What is the ROIC for NOPAT $800,000, invested capital $6,000,000?', 'answer' => '13.33%.'],
        ['question' => 'And for NOPAT $150,000, invested capital $1,900,000?', 'answer' => '7.895%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'ROIC above WACC creates value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nopat" label="NOPAT" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="capital" label="Invested capital (debt + equity − cash)" value="6000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="ROIC" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nopat' => 800000, 'capital' => 6000000],
        'Example B' => ['nopat' => 150000, 'capital' => 1900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROIC = NOPAT ÷ invested capital</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
