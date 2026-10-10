<x-tool-page-layout
    title="Number to Million Converter - SolveKit"
    description="Professional number to million converter for medium scale analysis. Convert any number to millions and understand its magnitude in business and everyday contexts."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Number to Million</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Number -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputNumber" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Any Number
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputNumber" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter any number (e.g., 5000000)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Number</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter any positive or negative number</p>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <select id="domain">
                                                                                    <option value="general" selected>General Numbers</option>
                                                                                </select>
                                                                                <input type="radio" name="baseline" value="relative" checked>
                                                                                <input type="radio" name="baseline" value="absolute">
                                                                                <input type="radio" name="detailLevel" value="basic">
                                                                                <input type="radio" name="detailLevel" value="detailed" checked>
                                                                                <input type="radio" name="detailLevel" value="comprehensive">
                                                                                <input type="radio" name="precision" value="1">
                                                                                <input type="radio" name="precision" value="3" checked>
                                                                                <input type="radio" name="precision" value="6">
                                                                                <input type="radio" name="precision" value="auto">
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-medium rounded-lg transition-colors duration-200"
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

                                                                            <!-- Primary Result - Millions -->
                                                                            <div class="p-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border-l-4 border-amber-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1">In Millions</h4>
                                                                                        <p class="text-sm text-gray-600">Primary conversion result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-amber-600 font-mono" id="millionOutput">--</div>
                                                                                        <button class="text-xs text-amber-600 hover:text-amber-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Scale Hierarchy Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Thousands -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Thousands</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="thousandDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10³</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Millions -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millions</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="millionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁶</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Billions -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="billionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁹</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Smaller Scale Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Hundreds -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Hundreds</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="hundredDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10²</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Units -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Units</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="unitDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁰</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scientific -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scientific</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="scientificDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Exponential</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Cross-Cultural Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Indian System -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Lakhs (Indian)</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="lakhDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁵</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Crores -->
                                                                                <div class="p-4 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Crores (Indian)</h4>
                                                                                        <div class="text-lg font-bold text-teal-600 font-mono" id="croreDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁷</div>
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
                        const inputNumber = document.getElementById('inputNumber');
                        const domain = document.getElementById('domain');
                        const baselineRadios = document.getElementsByName('baseline');
                        const detailLevelRadios = document.getElementsByName('detailLevel');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const millionOutput = document.getElementById('millionOutput');
                        const thousandDisplay = document.getElementById('thousandDisplay');
                        const millionDisplay = document.getElementById('millionDisplay');
                        const billionDisplay = document.getElementById('billionDisplay');
                        const hundredDisplay = document.getElementById('hundredDisplay');
                        const unitDisplay = document.getElementById('unitDisplay');
                        const scientificDisplay = document.getElementById('scientificDisplay');
                        const lakhDisplay = document.getElementById('lakhDisplay');
                        const croreDisplay = document.getElementById('croreDisplay');
                        const copyResult = document.getElementById('copyResult');

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }

                            const absolute = Math.abs(num);
                            if (absolute >= 1e21 || (absolute !== 0 && absolute < 1e-9)) {
                                return num.toExponential(4).replace(/\.?0+e/, 'e');
                            }

                            if (absolute !== 0 && absolute < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }

                            const fractionDigits = precision === 'auto' ? 6 : precision;
                            return num.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function convert() {
                            const inputVal = parseFloat(inputNumber.value);
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Basic conversions
                                const millions = inputVal / 1e6;
                                const thousands = inputVal / 1e3;
                                const billions = inputVal / 1e9;
                                const hundreds = inputVal / 100;
                                const lakhs = inputVal / 1e5;
                                const crores = inputVal / 1e7;

                                // Update primary display
                                millionOutput.textContent = formatNumber(millions, precision);

                                // Update all scale displays
                                thousandDisplay.textContent = formatNumber(thousands, precision);
                                millionDisplay.textContent = formatNumber(millions, precision);
                                billionDisplay.textContent = formatNumber(billions, precision);
                                hundredDisplay.textContent = formatNumber(hundreds, precision);
                                unitDisplay.textContent = formatNumber(inputVal, precision);
                                scientificDisplay.textContent = inputVal.toExponential(3);
                                lakhDisplay.textContent = formatNumber(lakhs, precision);
                                croreDisplay.textContent = formatNumber(crores, precision);
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            millionOutput.textContent = '--';
                            thousandDisplay.textContent = '--';
                            millionDisplay.textContent = '--';
                            billionDisplay.textContent = '--';
                            hundredDisplay.textContent = '--';
                            unitDisplay.textContent = '--';
                            scientificDisplay.textContent = '--';
                            lakhDisplay.textContent = '--';
                            croreDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputNumber.value = '';
                            domain.value = 'general';
                            clearOutputs();
                            inputNumber.focus();
                        }

                        // Event listeners
                        inputNumber.addEventListener('input', convert);
                        domain.addEventListener('change', convert);
                        
                        baselineRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        detailLevelRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = millionOutput.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Domain example buttons
                        const domainExamples = document.querySelectorAll('.domain-example');
                        domainExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const context = this.getAttribute('data-context');
                                
                                inputNumber.value = value;
                                convert();
                                
                                // Update button styles
                                domainExamples.forEach(btn => btn.classList.remove('bg-amber-100', 'text-amber-700'));
                                domainExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-amber-100', 'text-amber-700');
                            });
                        });

                        // Initialize
                        inputNumber.focus();
                        convert();

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
