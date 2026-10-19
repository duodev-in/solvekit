<x-calc.page
    title="Vaccine Efficacy Calculator - SolveKit"
    description="Free vaccine efficacy calculator: efficacy from cases in vaccinated and unvaccinated groups, with relative risk and a 95% confidence interval."
    lede="Calculate vaccine efficacy."
    about="Vaccine efficacy = 1 − (attack rate in the vaccinated ÷ attack rate in the unvaccinated) = 1 − relative risk, as a percentage. Measured in trials it is efficacy; in real-world studies it is called effectiveness. The confidence interval uses the log relative risk (Katz method). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'vaccine', 'fields' => ['vc', 'vn', 'uc', 'un']]"
    :how-to="[
        ['name' => 'Enter cases and group sizes', 'text' => 'For both groups.'],
    ]"
    :faqs="[
        ['question' => 'What is the efficacy with 8 cases in 15,000 vaccinated and 160 in 15,000 unvaccinated?', 'answer' => '95.0% (95% CI 89.8% to 97.5%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="vc" label="Cases among vaccinated" value="8" min="0" step="1" />
        <x-calc.field name="vn" label="Vaccinated group size" value="15000" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="uc" label="Cases among unvaccinated" value="160" min="0" step="1" />
        <x-calc.field name="un" label="Unvaccinated group size" value="15000" min="0" step="1" />
    </div>

    <x-calc.result label="Vaccine efficacy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['vc' => 8, 'vn' => 15000, 'uc' => 160, 'un' => 15000],
        'Flu season' => ['vc' => 120, 'vn' => 5000, 'uc' => 240, 'un' => 5000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rr' => ['label' => 'Relative risk'],
            'attack' => ['label' => 'Attack rates'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VE = 1 − ARV ÷ ARU</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
