<x-tool-page-layout
    title="Nm to ft-lbs Converter - SolveKit"
    description="Professional Newton meters to foot-pounds converter for engineering applications. Convert between Nm and ft-lbs torque units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Torque (ft-lbs)</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="nmInput" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Torque (Newton meters)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="nmInput" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter torque in Newton meters"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Nm</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Input torque value in Newton meters (SI unit)</p>
                                                                            </div>

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer bg-purple-50 border-purple-300">
                                                                                        <input type="radio" name="mode" value="nm-to-ftlbs" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Nm → ft-lbs</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="ftlbs-to-nm" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">ft-lbs → Nm</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Torque in Foot-pounds</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Imperial torque unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-3xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="unit-display">ft-lbs</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Bidirectional Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton meters</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="nmDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">SI Unit</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Foot-pounds</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="ftlbsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Imperial Unit</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Related Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Inch-pounds</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="inlbsDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">kgf·m</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="kgfmDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">kN·m</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="knmDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Conversion Constant -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2 text-center">Conversion Constant</h4>
                                                                                <div class="text-center text-sm text-gray-600 font-mono" id="conversionConstant">
                                                                                    1 Nm = 0.737562 ft-lbs
                                                                                </div>
                                                                                <div class="text-center text-xs text-gray-500 mt-1">
                                                                                    Exact conversion factor
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Values -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Torque Values (Nm)
                                                        </label>
                                                        <div class="grid grid-cols-4 gap-2">
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="10">10 Nm</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="50">50 Nm</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="100">100 Nm</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="250">250 Nm</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Torque Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 Nm = 0.7376 ft-lbs</div>
                                                        <div>• 1 ft-lbs = 1.3558 Nm</div>
                                                        <div>• 1 Nm = 8.851 in-lbs</div>
                                                        <div>• 1 ft-lbs = 12 in-lbs</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Nm to ft-lbs Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">SI to Imperial</h4>
                                    <p>This converter bridges the gap between SI (Newton meters) and Imperial (foot-pounds) torque units. The conversion factor 0.737562 is derived from the fundamental relationships between newtons and pounds-force, and meters and feet.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Practical Applications</h4>
                                    <p>Essential for automotive work, mechanical engineering, and any situation where torque specifications need to be converted between metric and imperial systems. Common in international projects and tool calibration.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <p class="text-sm text-purple-800">
                                    <strong>Conversion Tip:</strong> To remember the conversion: 1 Nm ≈ 0.74 ft-lbs (about 3/4), or 1 ft-lbs ≈ 1.36 Nm (about 4/3)!
                                </p>
                            </div>
                        </div>

                        <!-- Common Torque Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Torque Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Bike Pedal</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="50">50 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 37 ft-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car Lug Nut</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="120">120 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 89 ft-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Engine Torque</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="300">300 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 221 ft-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Heavy Bolt</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="500">500 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 369 ft-lbs</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const nmInput = document.getElementById('nmInput');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const nmDisplay = document.getElementById('nmDisplay');
                        const ftlbsDisplay = document.getElementById('ftlbsDisplay');
                        const inlbsDisplay = document.getElementById('inlbsDisplay');
                        const kgfmDisplay = document.getElementById('kgfmDisplay');
                        const knmDisplay = document.getElementById('knmDisplay');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const conversionConstant = document.getElementById('conversionConstant');
                        const clearButton = document.getElementById('clearButton');
                        const modeRadios = document.getElementsByName('mode');
                        const precisionRadios = document.getElementsByName('precision');

                        // Conversion constants
                        const NM_TO_FTLBS = 0.737562149;
                        const FTLBS_TO_NM = 1.3558179;
                        const NM_TO_INLBS = 8.8507458;
                        const NM_TO_KGFM = 0.101971621;
                        const NM_TO_KNM = 0.001;

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 10000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 1 });
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (num >= 1) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                    return Number(num.toPrecision(4)).toExponential();
                                } else {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                            } else {
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -precision)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function updateLabelsAndConstant() {
                            const mode = getMode();
                            if (mode === 'nm-to-ftlbs') {
                                nmInput.placeholder = 'Enter torque in Newton meters';
                                resultTitle.textContent = 'Torque in Foot-pounds';
                                resultDescription.textContent = 'Imperial torque unit';
                                conversionConstant.textContent = '1 Nm = 0.737562 ft-lbs';
                            } else {
                                nmInput.placeholder = 'Enter torque in foot-pounds';
                                resultTitle.textContent = 'Torque in Newton-meters';
                                resultDescription.textContent = 'SI torque unit';
                                conversionConstant.textContent = '1 ft-lbs = 1.35582 Nm';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(nmInput.value);
                            const precision = getPrecision();
                            const mode = getMode();

                            if (!isNaN(inputVal) && inputVal !== 0) {
                                let nmValue, ftlbsValue;

                                if (mode === 'nm-to-ftlbs') {
                                    nmValue = inputVal;
                                    ftlbsValue = inputVal * NM_TO_FTLBS;
                                    output.textContent = formatNumber(ftlbsValue, precision);
                                    unitDisplay.textContent = 'ft-lbs';
                                } else {
                                    ftlbsValue = inputVal;
                                    nmValue = inputVal * FTLBS_TO_NM;
                                    output.textContent = formatNumber(nmValue, precision);
                                    unitDisplay.textContent = 'Nm';
                                }

                                // Update all displays
                                nmDisplay.textContent = formatNumber(nmValue, precision) + ' Nm';
                                ftlbsDisplay.textContent = formatNumber(ftlbsValue, precision) + ' ft-lbs';
                                inlbsDisplay.textContent = formatNumber(nmValue * NM_TO_INLBS, precision) + ' in-lbs';
                                kgfmDisplay.textContent = formatNumber(nmValue * NM_TO_KGFM, precision) + ' kgf·m';
                                knmDisplay.textContent = formatNumber(nmValue * NM_TO_KNM, precision) + ' kN·m';

                            } else {
                                const mode = getMode();
                                output.textContent = '--';
                                unitDisplay.textContent = mode === 'nm-to-ftlbs' ? 'ft-lbs' : 'Nm';
                                nmDisplay.textContent = '--';
                                ftlbsDisplay.textContent = '--';
                                inlbsDisplay.textContent = '--';
                                kgfmDisplay.textContent = '--';
                                knmDisplay.textContent = '--';
                            }
                        }

                        function clearAll() {
                            nmInput.value = '';
                            convert();
                            nmInput.focus();
                        }

                        // Event listeners
                        nmInput.addEventListener('input', convert);
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabelsAndConstant();
                                convert();
                            });
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Quick value buttons
                        const quickValues = document.querySelectorAll('.quick-value');
                        quickValues.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                nmInput.value = value;
                                convert();
                                
                                // Update button styles
                                quickValues.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                quickValues.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-value]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                nmInput.value = value;
                                convert();
                                nmInput.focus();
                            });
                        });

                        // Initialize
                        nmInput.focus();
                        updateLabelsAndConstant();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === 'nm-to-ftlbs' ? 'ftlbs-to-nm' : 'nm-to-ftlbs';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateLabelsAndConstant();
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
