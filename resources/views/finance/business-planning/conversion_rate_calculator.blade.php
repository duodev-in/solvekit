<x-calc.page
    title="Conversion Rate Calculator - SolveKit"
    description="Free Conversion Rate Calculator: conversion rate = conversions ÷ visitors. The share of visitors who complete the goal, such as a purchase or sign-up."
    lede="Work out the conversion rate from conversions and visitors or sessions."
    about="The share of visitors who complete the goal, such as a purchase or sign-up. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'conversion_rate', 'fields' => ['conversions', 'visitors']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Conversions, Visitors or sessions.'],
        ['name' => 'Read the result', 'text' => 'The conversion rate appears as you type, with visitors per conversion below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the conversion rate?', 'answer' => 'Conversion rate = conversions ÷ visitors.'],
        ['question' => 'What is the conversion rate for conversions 125, visitors or sessions 5,000?', 'answer' => '2.5%. Visitors per conversion: 40.'],
        ['question' => 'And for conversions 42, visitors or sessions 1,300?', 'answer' => '3.231%. Visitors per conversion: 30.95.'],
        ['question' => 'What does the result tell me?', 'answer' => 'E-commerce stores often convert 1–4% of sessions.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="conversions" label="Conversions" value="125" min="0" step="1" />
        <x-calc.field name="visitors" label="Visitors or sessions" value="5000" min="0" step="1" />
    </div>

    <x-calc.result label="Conversion rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['conversions' => 125, 'visitors' => 5000],
        'Example B' => ['conversions' => 42, 'visitors' => 1300],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Visitors per conversion'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>conversion rate = conversions ÷ visitors</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
