<x-tool-page-layout
    title="Byte Conversion Calculator - SolveKit"
    description="Professional byte conversion calculator for digital storage units. Convert between bytes, kilobytes, megabytes, gigabytes, terabytes, and more with detailed calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Byte Conversion Calculator</h1>
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
                                                                                        Storage Size
                                                                                    </label>
                                                                                    <input
                                                                                        type="number"
                                                                                        id="inputValue"
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                        placeholder="e.g. 1024"
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
                                                                                        <option value="byte">Byte (B)</option>
                                                                                        <option value="kilobyte" selected>Kilobyte (KB)</option>
                                                                                        <option value="megabyte">Megabyte (MB)</option>
                                                                                        <option value="gigabyte">Gigabyte (GB)</option>
                                                                                        <option value="terabyte">Terabyte (TB)</option>
                                                                                        <option value="petabyte">Petabyte (PB)</option>
                                                                                        <option value="exabyte">Exabyte (EB)</option>
                                                                                        <option value="zettabyte">Zettabyte (ZB)</option>
                                                                                        <option value="yottabyte">Yottabyte (YB)</option>
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
                                                                                        <option value="byte">Byte (B)</option>
                                                                                        <option value="kilobyte">Kilobyte (KB)</option>
                                                                                        <option value="megabyte" selected>Megabyte (MB)</option>
                                                                                        <option value="gigabyte">Gigabyte (GB)</option>
                                                                                        <option value="terabyte">Terabyte (TB)</option>
                                                                                        <option value="petabyte">Petabyte (PB)</option>
                                                                                        <option value="exabyte">Exabyte (EB)</option>
                                                                                        <option value="zettabyte">Zettabyte (ZB)</option>
                                                                                        <option value="yottabyte">Yottabyte (YB)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Binary vs Decimal -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Standard
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer bg-teal-50 border-teal-300">
                                                                                        <input type="radio" name="standard" value="binary" class="text-teal-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Binary (1024)</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="standard" value="decimal" class="text-teal-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Decimal (1000)</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-teal-100 hover:bg-teal-200 text-teal-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border-l-4 border-teal-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="resultTitle">Megabytes (MB)</h4>
                                                                                        <p class="text-sm text-gray-600" id="conversionDescription">Enter a storage size to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-teal-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-teal-600 hover:text-teal-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Unit Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Bytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border-l-4 border-gray-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Bytes (B)</h4>
                                                                                        <div class="text-lg font-bold text-gray-600 font-mono" id="bytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Base unit</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Kilobytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilobytes (KB)</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="kilobytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1024 B</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Medium Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Megabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Megabytes (MB)</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="megabytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1024 KB</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Gigabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Gigabytes (GB)</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="gigabytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1024 MB</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Large Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Terabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Terabytes (TB)</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="terabytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1024 GB</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Petabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Petabytes (PB)</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="petabytesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1024 TB</div>
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
                            const standardRadios = document.getElementsByName('standard');
                            const clearButton = document.getElementById('clearButton');

                            // Output elements
                            const output = document.getElementById('output');
                            const resultTitle = document.getElementById('resultTitle');
                            const conversionDescription = document.getElementById('conversionDescription');
                            const bytesDisplay = document.getElementById('bytesDisplay');
                            const kilobytesDisplay = document.getElementById('kilobytesDisplay');
                            const megabytesDisplay = document.getElementById('megabytesDisplay');
                            const gigabytesDisplay = document.getElementById('gigabytesDisplay');
                            const terabytesDisplay = document.getElementById('terabytesDisplay');
                            const petabytesDisplay = document.getElementById('petabytesDisplay');
                            const copyResult = document.getElementById('copyResult');

                            // Unit multipliers (in bytes)
                            const unitMultipliers = {
                                binary: {
                                    byte: 1,
                                    kilobyte: 1024,
                                    megabyte: 1024 ** 2,
                                    gigabyte: 1024 ** 3,
                                    terabyte: 1024 ** 4,
                                    petabyte: 1024 ** 5,
                                    exabyte: 1024 ** 6,
                                    zettabyte: 1024 ** 7,
                                    yottabyte: 1024 ** 8
                                },
                                decimal: {
                                    byte: 1,
                                    kilobyte: 1e3,
                                    megabyte: 1e6,
                                    gigabyte: 1e9,
                                    terabyte: 1e12,
                                    petabyte: 1e15,
                                    exabyte: 1e18,
                                    zettabyte: 1e21,
                                    yottabyte: 1e24
                                }
                            };

                            const unitLabels = {
                                byte: 'B',
                                kilobyte: 'KB',
                                megabyte: 'MB',
                                gigabyte: 'GB',
                                terabyte: 'TB',
                                petabyte: 'PB',
                                exabyte: 'EB',
                                zettabyte: 'ZB',
                                yottabyte: 'YB'
                            };

                            const unitNames = {
                                byte: 'Bytes',
                                kilobyte: 'Kilobytes',
                                megabyte: 'Megabytes',
                                gigabyte: 'Gigabytes',
                                terabyte: 'Terabytes',
                                petabyte: 'Petabytes',
                                exabyte: 'Exabytes',
                                zettabyte: 'Zettabytes',
                                yottabyte: 'Yottabytes'
                            };

                            function getStandard() {
                                const checked = document.querySelector('input[name="standard"]:checked');
                                return checked ? checked.value : 'binary';
                            }

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

                            function convert() {
                                const inputVal = parseFloat(inputValue.value);
                                const from = fromUnit.value;
                                const to = toUnit.value;
                                const standard = getStandard();

                                if (Number.isNaN(inputVal) || inputVal < 0) {
                                    clearOutputs();
                                    return;
                                }

                                // Convert input to bytes first, then to the target unit
                                const bytes = inputVal * unitMultipliers[standard][from];
                                const result = bytes / unitMultipliers[standard][to];

                                output.textContent = `${formatNumber(result)} ${unitLabels[to]}`;
                                resultTitle.textContent = `${unitNames[to]} (${unitLabels[to]})`;
                                conversionDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                bytesDisplay.textContent = formatNumber(bytes);
                                kilobytesDisplay.textContent = formatNumber(bytes / unitMultipliers[standard].kilobyte);
                                megabytesDisplay.textContent = formatNumber(bytes / unitMultipliers[standard].megabyte);
                                gigabytesDisplay.textContent = formatNumber(bytes / unitMultipliers[standard].gigabyte);
                                terabytesDisplay.textContent = formatNumber(bytes / unitMultipliers[standard].terabyte);
                                petabytesDisplay.textContent = formatNumber(bytes / unitMultipliers[standard].petabyte);
                            }

                            function clearOutputs() {
                                output.textContent = '--';
                                resultTitle.textContent = `${unitNames[toUnit.value]} (${unitLabels[toUnit.value]})`;
                                conversionDescription.textContent = 'Enter a storage size to convert';
                                [bytesDisplay, kilobytesDisplay, megabytesDisplay, gigabytesDisplay, terabytesDisplay, petabytesDisplay].forEach(display => {
                                    display.textContent = '--';
                                });
                            }

                            function clearAll() {
                                inputValue.value = '';
                                fromUnit.value = 'kilobyte';
                                toUnit.value = 'megabyte';
                                document.querySelector('input[name="standard"][value="binary"]').checked = true;
                                clearOutputs();
                                inputValue.focus();
                            }

                            // Event listeners
                            inputValue.addEventListener('input', convert);
                            fromUnit.addEventListener('change', convert);
                            toUnit.addEventListener('change', convert);

                            standardRadios.forEach(radio => {
                                radio.addEventListener('change', convert);
                            });

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
