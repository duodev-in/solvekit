<x-calc.page
    title="Text Case Converter - SolveKit"
    description="Free text case converter: change text to UPPER CASE, lower case, Title Case, Sentence case, camelCase, snake_case, kebab-case and more."
    lede="Change the case of any text."
    about="Title Case capitalizes major words and keeps short words such as a, of and the lower case unless they come first or after a colon. Sentence case capitalizes the first letter of each sentence. camelCase, PascalCase, snake_case and kebab-case join the words for code and file names."
    :calc="['engine' => 'ev-office', 'tool' => 'text_case', 'fields' => ['text', 'mode']]"
    :how-to="[
        ['name' => 'Paste your text', 'text' => 'Any length.'],
        ['name' => 'Pick a case', 'text' => 'All the others are listed too.'],
    ]"
    :faqs="[
        ['question' => 'What is title case?', 'answer' => 'Major words capitalized, short words such as of and the in lower case.'],
        ['question' => 'What is camelCase?', 'answer' => 'Words joined, each after the first capitalized: helloWorld.'],
        ['question' => 'What is snake_case?', 'answer' => 'Lower-case words joined by underscores.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="the lord of the rings: the return of the king" rows="4" />

    <x-calc.select name="mode" label="Convert to" :options="['upper' => 'UPPER CASE', 'lower' => 'lower case', 'title' => 'Title Case', 'sentence' => 'Sentence case', 'camel' => 'camelCase', 'pascal' => 'PascalCase', 'snake' => 'snake_case', 'kebab' => 'kebab-case', 'constant' => 'CONSTANT_CASE', 'alternating' => 'aLtErNaTiNg', 'inverse' => 'iNVERSE']" selected="title" />

    <x-calc.result label="Converted" />

    <x-calc.options :decimals="false" :examples="[
        'Book title' => ['text' => 'the lord of the rings: the return of the king', 'mode' => 'title'],
        'Variable name' => ['text' => 'Total amount due', 'mode' => 'camel'],
        'Shouting' => ['text' => 'Please read the instructions.', 'mode' => 'upper'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Every case" name="all" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Title Case keeps a, an, and, as, at, but, by, for, in, of, on, or, the, to, via lower case</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
