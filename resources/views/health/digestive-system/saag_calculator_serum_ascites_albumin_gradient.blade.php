<x-calc.page
    title="SAAG Calculator – Serum-Ascites Albumin Gradient - SolveKit"
    description="Free SAAG calculator: serum-ascites albumin gradient to tell portal hypertension from other causes of ascites."
    lede="Calculate the serum-ascites albumin gradient."
    about="SAAG = serum albumin − ascitic fluid albumin, measured the same day. Runyon et al. (1992) found a gradient of 1.1 g/dL (11 g/L) or more indicates portal hypertension (cirrhosis, heart failure, Budd–Chiari) with about 97% accuracy; under 1.1 points to other causes such as cancer, tuberculosis, pancreatitis or nephrotic syndrome. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'saag', 'fields' => ['serum', 'serum_unit', 'ascites', 'ascites_unit']]"
    :how-to="[
        ['name' => 'Enter serum albumin', 'text' => ''],
        ['name' => 'Enter ascitic albumin', 'text' => 'Same day.'],
    ]"
    :faqs="[
        ['question' => 'What is the SAAG for serum 3.0 and ascites 1.2 g/dL?', 'answer' => '1.8 g/dL: 1.1 g/dL or more: portal hypertension (cirrhosis, heart failure, Budd–Chiari).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="serum" label="Serum albumin" value="3.0" min="0" step="any" />
        <x-calc.select name="serum_unit" label="Serum albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ascites" label="Ascitic fluid albumin" value="1.2" min="0" step="any" />
        <x-calc.select name="ascites_unit" label="Ascitic fluid albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.result label="Serum-ascites albumin gradient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['serum' => 3.0, 'serum_unit' => 'g/dL', 'ascites' => 1.2, 'ascites_unit' => 'g/dL'],
        'Low gradient' => ['serum' => 32, 'serum_unit' => 'g/L', 'ascites' => 26, 'ascites_unit' => 'g/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SAAG = serum − ascitic albumin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
