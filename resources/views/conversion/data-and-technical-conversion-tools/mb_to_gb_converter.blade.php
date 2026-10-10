<x-tool-page-layout
    title="MB to GB Converter - ConvertPro"
    description="Professional megabyte to gigabyte converter for digital storage calculations. Convert between MB and GB with binary and decimal standards, storage context, and detailed explanations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">MB to GB Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer bg-indigo-50 border-indigo-300">
                                                                                        <input type="radio" name="mode" value="mb-to-gb" class="text-indigo-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">MB → GB</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="gb-to-mb" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">GB → MB</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Megabytes (MB)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value (e.g., 1024)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">MB</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter any positive number</p>
                                                                            </div>

                                                                            <!-- Calculation Standard -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Standard
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer bg-indigo-50 border-indigo-300">
                                                                                        <input type="radio" name="standard" value="binary" class="text-indigo-600 focus:ring-slate-200" checked>
                                                                                        <div class="text-left">
                                                                                            <div class="text-sm font-medium">Binary (1024)</div>
                                                                                            <div class="text-xs text-gray-500">Operating systems</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="standard" value="decimal" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <div class="text-left">
                                                                                            <div class="text-sm font-medium">Decimal (1000)</div>
                                                                                            <div class="text-xs text-gray-500">Manufacturers</div>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>





                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border-l-4 border-indigo-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Gigabytes (GB)</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted to gigabytes</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-indigo-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-indigo-600 hover:text-indigo-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Both Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Megabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Megabytes (MB)</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="mbDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁶ bytes</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Gigabytes -->
                                                                                <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Gigabytes (GB)</h4>
                                                                                        <div class="text-lg font-bold text-indigo-600 font-mono" id="gbDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁹ bytes</div>
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
                            const modeRadios = document.getElementsByName('mode');
                            const standardRadios = document.getElementsByName('standard');
                            const clearButton = document.getElementById('clearButton');
                            const inputLabel = document.getElementById('inputLabel');
                            const inputUnit = document.getElementById('inputUnit');
                            const inputHelp = document.getElementById('inputHelp');

                            // Output elements
                            const output = document.getElementById('output');
                            const resultTitle = document.getElementById('result-title');
                            const resultDescription = document.getElementById('result-description');
                            const mbDisplay = document.getElementById('mbDisplay');
                            const gbDisplay = document.getElementById('gbDisplay');
                            const copyResult = document.getElementById('copyResult');

                            function getMode() {
                                const checked = document.querySelector('input[name="mode"]:checked');
                                return checked ? checked.value : 'mb-to-gb';
                            }

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

                            function updateInterface() {
                                if (getMode() === 'mb-to-gb') {
                                    inputLabel.textContent = 'Enter Megabytes (MB)';
                                    inputUnit.textContent = 'MB';
                                    inputHelp.textContent = 'Enter megabytes to convert to gigabytes';
                                    resultTitle.textContent = 'Gigabytes (GB)';
                                    inputValue.placeholder = 'Enter MB (e.g., 1024)';
                                } else {
                                    inputLabel.textContent = 'Enter Gigabytes (GB)';
                                    inputUnit.textContent = 'GB';
                                    inputHelp.textContent = 'Enter gigabytes to convert to megabytes';
                                    resultTitle.textContent = 'Megabytes (MB)';
                                    inputValue.placeholder = 'Enter GB (e.g., 5)';
                                }
                            }

                            function convert() {
                                const inputVal = parseFloat(inputValue.value);
                                const mode = getMode();
                                const divisor = getStandard() === 'binary' ? 1024 : 1000;

                                if (Number.isNaN(inputVal) || inputVal < 0) {
                                    clearOutputs();
                                    return;
                                }

                                const mb = mode === 'mb-to-gb' ? inputVal : inputVal * divisor;
                                const gb = mode === 'mb-to-gb' ? inputVal / divisor : inputVal;

                                output.textContent = mode === 'mb-to-gb' ? `${formatNumber(gb)} GB` : `${formatNumber(mb)} MB`;
                                resultDescription.textContent = mode === 'mb-to-gb'
                                    ? `${formatNumber(inputVal)} MB = ${formatNumber(gb)} GB`
                                    : `${formatNumber(inputVal)} GB = ${formatNumber(mb)} MB`;

                                mbDisplay.textContent = formatNumber(mb);
                                gbDisplay.textContent = formatNumber(gb);
                            }

                            function clearOutputs() {
                                output.textContent = '--';
                                resultDescription.textContent = getMode() === 'mb-to-gb' ? 'Converted to gigabytes' : 'Converted to megabytes';
                                mbDisplay.textContent = '--';
                                gbDisplay.textContent = '--';
                            }

                            function clearAll() {
                                inputValue.value = '';
                                document.querySelector('input[name="mode"][value="mb-to-gb"]').checked = true;
                                document.querySelector('input[name="standard"][value="binary"]').checked = true;
                                updateInterface();
                                clearOutputs();
                                inputValue.focus();
                            }

                            // Event listeners
                            inputValue.addEventListener('input', convert);

                            modeRadios.forEach(radio => {
                                radio.addEventListener('change', () => {
                                    updateInterface();
                                    convert();
                                });
                            });

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
                            updateInterface();
                            clearOutputs();
                            inputValue.focus();

                            // Keyboard shortcuts
                            document.addEventListener('keydown', function(e) {
                                if (e.key === 'Escape') {
                                    clearAll();
                                } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                    e.preventDefault();
                                    const newMode = getMode() === 'mb-to-gb' ? 'gb-to-mb' : 'mb-to-gb';
                                    document.querySelector(`input[name="mode"][value="${newMode}"]`).checked = true;
                                    updateInterface();
                                    convert();
                                }
                            });
                        });
                </script>
    </x-slot>
</x-tool-page-layout>
