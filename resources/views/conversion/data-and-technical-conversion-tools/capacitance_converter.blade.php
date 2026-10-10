<x-tool-page-layout
    title="Capacitance Converter - ConvertPro"
    description="Professional capacitance converter for electrical engineering and electronics. Convert between farads, millifarads, microfarads, nanofarads, and picofarads with detailed calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Capacitance Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid gap-3 sm:grid-cols-3">
                                                                                <!-- Input Value -->
                                                                                <div class="space-y-2">
                                                                                    <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                        Capacitance Value
                                                                                    </label>
                                                                                    <input
                                                                                        type="number"
                                                                                        id="inputValue"
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                        placeholder="e.g. 100"
                                                                                        step="any"
                                                                                    >
                                                                                </div>

                                                                                <!-- From Unit -->
                                                                                <div class="space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        From Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="farad">Farad (F)</option>
                                                                                        <option value="millifarad">Millifarad (mF)</option>
                                                                                        <option value="microfarad" selected>Microfarad (μF)</option>
                                                                                        <option value="nanofarad">Nanofarad (nF)</option>
                                                                                        <option value="picofarad">Picofarad (pF)</option>
                                                                                        <option value="femtofarad">Femtofarad (fF)</option>
                                                                                        <option value="attofarad">Attofarad (aF)</option>
                                                                                    </select>
                                                                                </div>

                                                                                <!-- To Unit -->
                                                                                <div class="space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        To Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="farad">Farad (F)</option>
                                                                                        <option value="millifarad">Millifarad (mF)</option>
                                                                                        <option value="microfarad">Microfarad (μF)</option>
                                                                                        <option value="nanofarad" selected>Nanofarad (nF)</option>
                                                                                        <option value="picofarad">Picofarad (pF)</option>
                                                                                        <option value="femtofarad">Femtofarad (fF)</option>
                                                                                        <option value="attofarad">Attofarad (aF)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>




                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="resultTitle">Nanofarads (nF)</h4>
                                                                                        <p class="text-sm text-gray-600" id="conversionDescription">Enter a capacitance value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Unit Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Farad -->
                                                                                <div class="p-4 bg-gradient-to-r from-red-50 to-rose-50 rounded-lg border-l-4 border-red-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Farad (F)</h4>
                                                                                        <div class="text-lg font-bold text-red-600 font-mono" id="faradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Base unit</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Millifarad -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millifarad (mF)</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="millifaradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁻³ F</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Microfarad -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Microfarad (μF)</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="microfaradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁻⁶ F</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Nanofarad -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Nanofarad (nF)</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="nanofaradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁻⁹ F</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Small Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Picofarad -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Picofarad (pF)</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="picofaradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁻¹² F</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Femtofarad -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Femtofarad (fF)</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="femtofaradDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁻¹⁵ F</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    
</x-slot>


    <x-slot name="scripts">
        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const inputValue = document.getElementById('inputValue');
                            const fromUnit = document.getElementById('fromUnit');
                            const toUnit = document.getElementById('toUnit');
                            const clearButton = document.getElementById('clearButton');

                            // Output elements
                            const output = document.getElementById('output');
                            const resultTitle = document.getElementById('resultTitle');
                            const conversionDescription = document.getElementById('conversionDescription');
                            const faradDisplay = document.getElementById('faradDisplay');
                            const millifaradDisplay = document.getElementById('millifaradDisplay');
                            const microfaradDisplay = document.getElementById('microfaradDisplay');
                            const nanofaradDisplay = document.getElementById('nanofaradDisplay');
                            const picofaradDisplay = document.getElementById('picofaradDisplay');
                            const femtofaradDisplay = document.getElementById('femtofaradDisplay');
                            const copyResult = document.getElementById('copyResult');

                            // Unit multipliers (in farads)
                            const unitMultipliers = {
                                farad: 1,
                                millifarad: 1e-3,
                                microfarad: 1e-6,
                                nanofarad: 1e-9,
                                picofarad: 1e-12,
                                femtofarad: 1e-15,
                                attofarad: 1e-18
                            };

                            const unitLabels = {
                                farad: 'F',
                                millifarad: 'mF',
                                microfarad: 'μF',
                                nanofarad: 'nF',
                                picofarad: 'pF',
                                femtofarad: 'fF',
                                attofarad: 'aF'
                            };

                            const unitNames = {
                                farad: 'Farads',
                                millifarad: 'Millifarads',
                                microfarad: 'Microfarads',
                                nanofarad: 'Nanofarads',
                                picofarad: 'Picofarads',
                                femtofarad: 'Femtofarads',
                                attofarad: 'Attofarads'
                            };

                            function formatNumber(num) {
                                if (!Number.isFinite(num)) {
                                    return '--';
                                }

                                const abs = Math.abs(num);

                                if (abs === 0) {
                                    return '0';
                                }

                                if (abs >= 1e15 || abs < 1e-6) {
                                    return num.toExponential(6).replace(/\.?0+e/, 'e');
                                }

                                if (abs >= 1) {
                                    return num.toLocaleString('en-US', { maximumFractionDigits: 6 });
                                }

                                return num.toLocaleString('en-US', { maximumSignificantDigits: 6 });
                            }

                            /**
                             * Divide using exponent-aligned factors to avoid floating point noise such as 123000.00000000001.
                             */
                            function convertValue(value, from, to) {
                                return Number((value * (unitMultipliers[from] / unitMultipliers[to])).toPrecision(12));
                            }

                            function convert() {
                                const inputVal = parseFloat(inputValue.value);
                                const from = fromUnit.value;
                                const to = toUnit.value;

                                if (Number.isNaN(inputVal) || inputVal < 0) {
                                    clearOutputs();
                                    return;
                                }

                                const result = convertValue(inputVal, from, to);

                                output.textContent = `${formatNumber(result)} ${unitLabels[to]}`;
                                resultTitle.textContent = `${unitNames[to]} (${unitLabels[to]})`;
                                conversionDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                faradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'farad'));
                                millifaradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'millifarad'));
                                microfaradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'microfarad'));
                                nanofaradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'nanofarad'));
                                picofaradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'picofarad'));
                                femtofaradDisplay.textContent = formatNumber(convertValue(inputVal, from, 'femtofarad'));
                            }

                            function clearOutputs() {
                                output.textContent = '--';
                                resultTitle.textContent = `${unitNames[toUnit.value]} (${unitLabels[toUnit.value]})`;
                                conversionDescription.textContent = 'Enter a capacitance value to convert';
                                [faradDisplay, millifaradDisplay, microfaradDisplay, nanofaradDisplay, picofaradDisplay, femtofaradDisplay].forEach(display => {
                                    display.textContent = '--';
                                });
                            }

                            function clearAll() {
                                inputValue.value = '';
                                fromUnit.value = 'microfarad';
                                toUnit.value = 'nanofarad';
                                clearOutputs();
                                inputValue.focus();
                            }

                            // Event listeners
                            inputValue.addEventListener('input', convert);
                            fromUnit.addEventListener('change', convert);
                            toUnit.addEventListener('change', convert);
                            clearButton.addEventListener('click', clearAll);

                            // Copy functionality
                            copyResult.addEventListener('click', function() {
                                const text = output.textContent;
                                if (text !== '--') {
                                    navigator.clipboard.writeText(text).then(() => {
                                        this.textContent = 'Copied!';
                                        setTimeout(() => {
                                            this.textContent = 'Copy Result';
                                        }, 2000);
                                    });
                                }
                            });

                            // Initialize
                            clearOutputs();
                            inputValue.focus();

                            // Keyboard shortcuts
                            document.addEventListener('keydown', function(e) {
                                if (e.key === 'Escape') {
                                    clearAll();
                                }
                            });
                        });
                </script>
    </x-slot>
</x-tool-page-layout>
