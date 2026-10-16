<x-calc.page
    title="pH Calculator - SolveKit"
    description="Free pH calculator: exact pH of strong and weak acids and bases, including polyprotic acids, with species distribution."
    lede="Work out the pH of an acid or base solution exactly."
    about="The pH is solved from the full charge balance: every dissociation step and water's own ions are included, so there is no “x is small” approximation and very dilute solutions come out right (10⁻⁸ M HCl is pH 6.98, not 8). pKa and pKb values are at 25 °C from the CRC Handbook."
    :calc="['engine' => 'chem-mix', 'tool' => 'ph', 'fields' => ['choice', 'kind', 'strength', 'pkas', 'pkb', 'concentration'], 'data' => ['acids' => config('chemistry_data.acids'), 'bases' => config('chemistry_data.bases')]]"
    :how-to="[
        ['name' => 'Pick the acid or base', 'text' => 'Or define a custom one.'],
        ['name' => 'Enter the concentration', 'text' => 'In mol/L.'],
    ]"
    :faqs="[
        ['question' => 'What is the pH of 0.1 M acetic acid?', 'answer' => '2.88.'],
        ['question' => 'Why is 10⁻⁸ M HCl not pH 8?', 'answer' => 'Water itself supplies 10⁻⁷ M H⁺, so the solution stays slightly acidic, at pH 6.98.'],
        ['question' => 'How is a polyprotic acid handled?', 'answer' => 'All dissociation steps are solved together.'],
    ]"
>
    <x-calc.select name="choice" label="Acid or base" :options="collect(config('chemistry_data.acids'))->mapWithKeys(fn ($a, $k) => ['acid:'.$k => $a['name'].' ('.$a['formula'].')'])->merge(collect(config('chemistry_data.bases'))->mapWithKeys(fn ($b, $k) => ['base:'.$k => $b['name'].' ('.$b['formula'].')']))->put('custom', 'Custom acid or base')->all()" selected="acid:acetic_acid" />

    <div data-show-when="choice:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.segmented name="kind" legend="Type" :options="['acid' => 'Acid', 'base' => 'Base']" selected="acid" />
            <x-calc.segmented name="strength" legend="Strength" :options="['weak' => 'Weak', 'strong' => 'Strong']" selected="weak" />
        </div>
    </div>

    <div data-show-when="choice:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="pkas" label="pKa values (acid)" value="4.76" type="text" help="Comma separated for polyprotic acids" />
            <x-calc.field name="pkb" label="pKb (base)" value="4.75" />
        </div>
    </div>

    <x-calc.field name="concentration" label="Concentration" value="0.1" min="0" suffix="mol/L" />

    <x-calc.result label="pH" />

    <x-calc.options :examples="[
        '0.1 M acetic acid' => ['choice' => 'acid:acetic_acid', 'concentration' => 0.1],
        '0.1 M phosphoric acid' => ['choice' => 'acid:phosphoric_acid', 'concentration' => 0.1],
        '0.05 M ammonia' => ['choice' => 'base:ammonia', 'concentration' => 0.05],
        '10⁻⁸ M HCl' => ['choice' => 'acid:hydrochloric_acid', 'concentration' => 1e-08],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'poh' => ['label' => 'pOH'],
            'h' => ['label' => '[H⁺]'],
            'oh' => ['label' => '[OH⁻]'],
            'dissociation' => ['label' => 'Dissociation'],
        ]" />
        <x-calc.quick-ref heading="Species" name="species" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>charge balance: [H⁺] + Σ cations = [OH⁻] + Σ anions</li>
            <li>Kw = 10^−13.995 at 25 °C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
